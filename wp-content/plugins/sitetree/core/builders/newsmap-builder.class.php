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
final class SiteTreeNewsmapBuilder extends SiteTreeGoogleSitemapBuilder {
    /**
     * @since 4.0
     */
    const SITEMAP_ID = 'newsmap';

    /**
     * @since 4.0
     * @var array
     */
    private $rawQueriedPosts;

    /**
     * @since 4.0
     * @param object $plugin
     */
    public function __construct( $plugin ) {
        parent::__construct( $plugin );

        $this->publicationLanguage = $this->db->getOption( 'publication_lang' );
        $this->publicationName     = $this->prepareAttribute( $this->db->getOption( 'publication_name' ) );

        if (! preg_match( '/^[a-z]{2}-?[a-z]{1,2}$/', $this->publicationLanguage ) ) {
            $this->publicationLanguage = 'eng';
        }
    }

    /**
     * @see parent::getStats()
     * @since 4.0
     */
    public function getStats() {
        $this->stats['excluded_news_count'] = $this->countExcludedPosts();

        return $this->stats;
    }

    /**
     * @see parent::runBuildingProcess()
     * @since 4.0
     */
    protected function runBuildingProcess() {
        if (! $this->queryPosts() ) {
            return false;
        }

        foreach ( $this->rawQueriedPosts as $post ) {
            $post = sanitize_post( $post, 'raw' );

            wp_cache_add( $post->ID, $post, 'posts' );

            $this->buildURLElement( $post );
        }

        unset( $this->rawQueriedPosts );

        return true;
    }

    /**
     * @since 4.0
     * @param object $post
     */
    public function buildURLElement( $post ) {
        $this->incrementItemsCounter();

        $this->output .= '<url>' . $this->lineBreak
                       . '<loc>' . get_permalink( $post ) . '</loc>' . $this->lineBreak
                       . '<news:news>' . $this->lineBreak . '<news:publication>' . $this->lineBreak
                       . '<news:name>' . $this->publicationName . '</news:name>' . $this->lineBreak
                       . '<news:language>' . $this->publicationLanguage . '</news:language>' . $this->lineBreak
                       . '</news:publication>' . $this->lineBreak
                       . '<news:title>' . $this->prepareAttribute( $post->post_title ) . '</news:title>' . $this->lineBreak 
                       . '<news:publication_date>' . gmdate( 'Y-m-d\TH:i:s', strtotime( $post->post_date ) )
                       . $this->timezoneOffset . '</news:publication_date>' . $this->lineBreak
                       . '</news:news>' . $this->lineBreak 
                       . '</url>' . $this->lineBreak;
    }

    /**
     * @since 4.0
     * @return bool
     */
    private function queryPosts() {
        $meta_key            = $this->db->prepareMetaKey( 'exclude_from_newsmap' );
        $max_number_of_posts = $this->buildingCapacityLeft();

        $this->rawQueriedPosts = $this->wpdb->get_results(
            "SELECT p.ID, p.post_name, p.post_date, p.post_title, p.post_parent, p.post_type, p.post_status 
             FROM {$this->wpdb->posts} AS p
             LEFT OUTER JOIN {$this->wpdb->postmeta} AS pm 
                ON p.ID = pm.post_id AND pm.meta_key = {$meta_key}
             WHERE p.post_type IN ({$this->postTypesList}) AND 
                   ( p.post_date_gmt >= UTC_TIMESTAMP() - INTERVAL 2 DAY ) AND
                   p.post_status = 'publish' AND p.post_password = '' AND pm.post_id IS NULL
             ORDER BY p.post_date DESC
             LIMIT {$max_number_of_posts}"
        );

        return (bool) $this->rawQueriedPosts;
    }
}
?>