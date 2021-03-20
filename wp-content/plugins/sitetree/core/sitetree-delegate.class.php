<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 4.0
 */
final class SiteTreeDelegate {
    /**
     * @since 4.0
     * @var object
     */
    private $plugin;

    /**
     * @since 4.0
     * @var object
     */
    private $db;

    /**
     * ID of the Google Sitemap to serve.
     *
     * @since 4.0
     * @var string
     */
    private $sitemapToServe;

    /**
     * @since 4.0
     * @param object $plugin
     */
    public function __construct( $plugin ) {
        $this->plugin = $plugin;
        $this->db     = $plugin->db();
    }

    /**
     * @since 4.0
     *
     * @param object $wp
     * @return bool Always true.
     */
    public function listenToPageRequest( $wp ) {
        global $wp_query;

        $site_tree_id = (int) $this->db->getOption( 'page_for_site_tree', 0 );

        if ( ( $site_tree_id > 0 ) && $wp_query->is_page( $site_tree_id ) ) {
            // A priority of 12 registers the method just after the wp_autop() function.
            add_filter( 'the_content', array( $this, 'wpWillDisplayPageContent' ), 12 );

            return true;
        }

        if (! $this->plugin->isSitemapActive() ) {
            return false;
        }

        if ( $wp_query->is_page() && $this->db->getPostMeta( $wp_query->get_queried_object_id(), 'is_ghost_page' ) ) {
            header( 'X-Robots-Tag: noindex, nofollow' );

            // For the WP Super Cache plugin.
            if (! defined( 'DONOTCACHEPAGE' ) ) {
                define( 'DONOTCACHEPAGE', true );
            }
        }
        elseif ( $wp_query->is_robots() ) {
            $this->plugin->load( 'core/robots-delegate.class.php' );

            $robotsDelegate = new SiteTreeRobotsDelegate( $this->plugin );

            add_filter( 'robots_txt', array( $robotsDelegate, 'wpDidGenerateRobotsFileContent' ), 50, 2 );
        }

        return true;
    }

    /**
     * @since 4.0
     *
     * @param array $headers
     * @param object $wp
     * @return array
     */
    public function wpWillSendHeaders( $headers, $wp ) {
        if ( 
            isset( $wp->query_vars['sitetree'] ) &&
            ( ( $wp->query_vars['sitetree'] == 'sitemap' ) || ( $wp->query_vars['sitetree'] == 'newsmap' ) )
        ) {
            global $wp_rewrite;

            if ( isset( $wp->query_vars['id'] ) && ( $wp->query_vars['id'] == 'stylesheet' ) ) {
                $this->plugin->load( 'core/builders/stylesheet-builder.class.php' );

                $stylesheetBuilder       = new SiteTreeStylesheetBuilder( $this->plugin, $wp->query_vars['sitetree'] );
                $templateBuilderDelegate = $stylesheetBuilder;

                $headers = array( 'Content-Type' => 'text/xsl; charset=UTF-8' );
            }
            else {
               // If the sitemap is requested via query variable and a permalink
                // structure is in place, it redirects the request to the sitemap's permalink.
                if ( !$wp->did_permalink && $wp_rewrite->using_permalinks() ) {
                    wp_redirect( $this->plugin->sitemapURL( $wp->query_vars['sitetree'] ), 301 );

                    exit;
                }

                $templateBuilderDelegate = $this;

                $last_modified = gmdate( 'D, d M Y H:i:s', time() ) . ' GMT';
                $headers       = array(
                    'Content-Type'  => 'application/xml; charset=UTF-8',
                    'Last-Modified' => $last_modified,
                    'Cache-Control' => 'no-cache'
                );
                
                $this->sitemapToServe = $wp->query_vars['sitetree']; 
            }

            remove_filter( 'template_redirect', 'redirect_canonical' );
            add_action( 'template_redirect', array( $templateBuilderDelegate, 'wpWillLoadTemplate' ) );
        }
        
        return $headers;
    }

    /**
     * @since 4.0
     */
    public function wpWillLoadTemplate() {
        // For the WP Super Cache plugin.
        define( 'DONOTCACHEPAGE', true );

        $this->plugin->load( 'core/builders/builder-core.class.php' );
        $this->plugin->load( 'core/builders/google-sitemap-builder.class.php' );
        
        switch ( $this->sitemapToServe ) {
            case 'sitemap':
                $this->plugin->load( 'core/builders/builders-interfaces.php' );
                $this->plugin->load( 'core/builders/sitemap-builder.class.php' );
                $this->plugin->load( 'core/builders/image-element.class.php' );

                $builder          = new SiteTreeSitemapBuilder( $this->plugin );
                $additional_xmlns = 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1';
                break;

            case 'newsmap':
                $this->plugin->load( 'core/builders/newsmap-builder.class.php' );

                $builder          = new SiteTreeNewsmapBuilder( $this->plugin );
                $additional_xmlns = 'xmlns:news="http://www.google.com/schemas/sitemap-news/0.9';
                break;

            default:
                return false;
        }

        $sitemap = $builder->build();

        $this->updateStats( $builder );

        $plugin_version  = $this->plugin->version();
        $stylesheet_name = $this->sitemapToServe . '-template.xsl';

        exit( '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . '<?xml-stylesheet type="text/xsl" href="' . home_url( $stylesheet_name ) 
            . '?ver=' . $plugin_version . '"?>' . "\n"
            . '<!-- Sitemap generated by ' . $this->plugin->name() . ' ' . $plugin_version
            . ' - ' . $this->plugin->pluginURI() . " -->\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ' . $additional_xmlns 
            . '">' . $sitemap . '</urlset>' );
    }
    
    /**
     * Appends the Site Tree to the content of the page where the Site Tree must be shown.
     *
     * This method is hooked into the the_content filter hook.
     *
     * @since 4.0
     *
     * @param string $the_content
     * @return string
     */
    public function &wpWillDisplayPageContent( $the_content ) {
        if ( in_the_loop() ) {
            $this->plugin->load( 'core/builders/builder-core.class.php' );
            $this->plugin->load( 'core/builders/builders-interfaces.php' );
            $this->plugin->load( 'core/builders/site-tree-builder.class.php' );
            
            $builder = new SiteTreeBuilder( $this->plugin );
            
            $the_content .= "<!-- Site Tree start -->\n";
            $the_content .= $builder->build();
            $the_content .= "<!-- Site Tree end -->\n";

            $this->updateStats( $builder );

            remove_filter( 'the_content', array( $this, 'wpWillDisplayPageContent' ), 12 );
        }

        return $the_content;
    }

    /**
     * @since 4.0
     * 
     * @param objetc $builder
     * @return bool
     */
    private function updateStats( $builder ) {
        $sitemap_id = $builder->sitemapID();

        if ( $this->db->getNonAutoloadOption( 'stats', false, 'stats_are_fresh', $sitemap_id ) ) {
            if ( $builder->getNumberOfItems() == $this->db->getNonAutoloadOption( 'stats', -1, 'num_items', $sitemap_id ) ) {
                return false;
            }
        }

        $stats = $builder->getStats();

        $stats['stats_computed_on'] = time();
        $stats['stats_are_fresh']   = true;

        $this->db->setNonAutoloadOption( 'stats', $stats, $sitemap_id );
        
        return true;
    }
}
?>