<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * Plugin's main class.
 *
 * @since 1.0
 */
final class SiteTree extends sitetree\Plugin {
    /**
	 * Shared instance of the {@see SiteTreeDB} class.
     *
     * @since 1.3
     * @var object
     */
    private $db;

    /**
     * @since 3.2
     * @var object
     */
    private $pingController;

    /**
     * @since 1.4
     * @return object
     */
    public function db() {
        return $this->db;
    }

    /**
     * @since 3.2
     * @return object
     */
    public function pingController() {
        if (! $this->pingController ) {
            $this->load( 'core/ping-state.class.php' );
            $this->load( 'core/ping-controller.class.php' );
        
            $this->pingController = new SiteTreePingController( $this );
        }
        
        return $this->pingController;
    }

    /**
     * @since 1.5
     *
     * @param string $loader_path
     * @return bool
     */
    public static function launch( $loader_path ) {
        if (! parent::launch( $loader_path ) ) {
            return false;
        }

        self::$plugin->load( 'core/db-classes.php' );
        self::$plugin->load( 'library/functions.php' );

        self::$plugin->db = new SiteTreeDB( 'sitetree' );

        if ( !is_admin() && self::$plugin->isSitemapActive() ) {
            add_filter( 'wp_sitemaps_enabled', '__return_false' ); 
        }
        
        add_action( 'init', array( self::$plugin, 'finishLaunching' ) );
        add_action( 'shutdown', array( self::$plugin, 'wpWillShutDown' ) );

        return true;
    }
    
    /**
     * @since 1.4
     * @return bool
     */
    public function finishLaunching() {
        $is_sitemap_active = $this->isSitemapActive();

        $this->verifyVersionOfStoredData();

        if ( $is_sitemap_active ) {
            global $wp;

            $wp->add_query_var( 'sitetree' );
            $wp->add_query_var( 'id' );

            $this->registerRewriteRules();
        }

        if ( is_admin() ) {
            $this->load( 'admin/admin-controller.class.php' );
            $this->load( 'data-model/data-model-classes.php' );

            $dataController  = new SiteTreeDataController( $this );
            $adminController = new SiteTreeAdminController( $this, $dataController );

            add_action( 'wp_loaded', array( $adminController, 'init' ) );
        }
        elseif ( $is_sitemap_active && ( strpos( $_SERVER['REQUEST_URI'], '/wp-json/' ) === 0 ) ) {
            $this->load( 'admin/admin-controller.class.php' );

            $adminController = new SiteTreeAdminController( $this );

            add_action( 'save_post', array( $adminController, 'wpDidSavePost' ), 10, 2 );
        }
        else {
            $this->load( 'core/sitetree-delegate.class.php' );

            $sitetreeDelegate = new SiteTreeDelegate( $this );

            add_action( 'wp', array( $sitetreeDelegate, 'listenToPageRequest' ), 5 );

            if ( $is_sitemap_active ) {
                add_filter( 'wp_headers', array( $sitetreeDelegate, 'wpWillSendHeaders' ), 10, 2 );  
            }
        }
        
        return true;
    }
    
    /**
     * @since 2.0
     */
    public function wpWillShutDown() {
    	$this->db->consolidate();
    }
    
    /**
     * Verifies that the data stored into the database are compatible with 
     * this version of the plugin and if needed invokes the upgrader.
     *
     * @since 2.0
     * @return bool
     */
    private function verifyVersionOfStoredData() {
        $current_version = $this->db->getOption( 'version' );
        
        if ( $current_version === $this->version ) {
            return true;
        }

        if ( $current_version ) {
            $this->load( 'core/upgrader.class.php' );

            $upgrader = new SiteTreeUpgrader( $this );
            $upgrader->upgrade();
        }

        $now = time();

        if ( !$current_version || version_compare( $current_version, '1.5.3', '<=' ) ) {
            $this->db->setOption( 'installed_on', $now );
        }

        $this->db->setOption( 'last_updated', $now );
        $this->db->setOption( 'version', $this->version );
        
        return true;
    }

    /**
     * @since 1.4
     * @return bool|int
     */
    public function registerRewriteRules() {
        add_action( 'generate_rewrite_rules', array( $this, 'wpRewriteDidGenerateRules' ) );
    }

    /**
     * @since 2.0
     * @param object $wp_rewrite
     */
    public function wpRewriteDidGenerateRules( $wp_rewrite ) {
        $sitetree_rules = array(
            '^(sitemap|newsmap)-template\.xsl$' => 'index.php?sitetree=$matches[1]&id=stylesheet'
        );

        if ( $this->isSitemapActive() ) {
            $sitetree_rules['^sitemap\.xml$'] = 'index.php?sitetree=sitemap';
        }

        if ( $this->isSitemapActive( 'newsmap' ) ) {
            $sitetree_rules['^news-sitemap\.xml$'] = 'index.php?sitetree=newsmap';
        }

        $wp_rewrite->rules = $sitetree_rules + $wp_rewrite->rules;
    }

    /**
     * @since 2.0
     *
     * @param string $sitemap_id
     * @return bool
     */
    public function isSitemapActive( $sitemap_id = 'sitemap' ) {
        if ( $sitemap_id == 'site_tree' ) {
            return (bool) $this->db->getOption( 'page_for_site_tree' );    
        }

        return (bool) $this->db->getOption( $sitemap_id, false, 'is_sitemap_active' );
    }

    /**
     * @since 2.0
     *
     * @param string $sitemap_id
     * @return string
     */
    public function sitemapURL( $sitemap_id = 'sitemap' ) {
        global $wp_rewrite;

        switch ( $sitemap_id ) {
            case 'sitemap':
            case 'newsmap':
                if ( $wp_rewrite->using_permalinks() ) {
                    $relative_url = ( ( $sitemap_id == 'sitemap' ) ? '/sitemap.xml' : '/news-sitemap.xml' );

                    return home_url( $relative_url );
                }
                
                return add_query_arg( 'sitetree', $sitemap_id, home_url( '/' ) );

            case 'site_tree':
                return get_permalink( $this->db->getOption( 'page_for_site_tree' ) );
        }

        return '';
    }

    /**
     * @since 3.2
     * @return bool
     */
    public function isServerLocal() {
        return (
            ( $_SERVER['SERVER_ADDR'] == '127.0.0.1' ) ||
            ( $_SERVER['SERVER_ADDR'] == '::1' )
        );
    }

    /**
     * @since 4.0
     * @param string $sitemap_id
     */
    public function flushCachedData( $sitemap_id ) {
        if ( $sitemap_id == 'site_tree' ) {
            if ( defined( 'WP_CACHE' ) && WP_CACHE && function_exists( 'wpsc_delete_url_cache' ) ) {
                wpsc_delete_url_cache( $this->sitemapURL( $sitemap_id ) );
            }
        }

        $this->db->setNonAutoloadOption( 'stats', false, 'stats_are_fresh', $sitemap_id );
    }
}
?>