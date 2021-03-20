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
abstract class SiteTreeGoogleSitemapBuilder extends SiteTreeBuilderCore {
    /**
     * @since 4.0
     */
    const MAX_NUMBER_OF_URLs = 1000;

    /**
     * @since 4.0
     * @var string
     */
    protected $postTypesList = '';

    /**
     * @since 4.0
     * @var int
     */
    protected $gmtOffset;

    /**
     * The timezone offset expressed in hours (ex. +02:00).
     *
     * @since 4.0
     * @var string
     */
    protected $timezoneOffset;
    
    /**
     * @since 4.0
     * @var string
     */
    protected $siteCharset;
    
    /**
     * @since 4.0
     * @var string
     */
    protected $lineBreak = '';

    /**
     * @since 4.0
     * @param object $plugin
     */
    public function __construct( $plugin ) {
        parent::__construct( $plugin );

        $post_types        = get_post_types( array( 'public' => true ) );
        $content_types_key = static::SITEMAP_ID . '_content_types';
        
        foreach ( $post_types as $post_type ) {
            if ( $this->db->getOption( $post_type, false, $content_types_key ) ) {
                $this->postTypesList .= "'" . $post_type . "',";
            }
        }

        // Removes the trailing comma from the string.
        $this->postTypesList = substr( $this->postTypesList, 0, -1);

        $this->buildingCapacity = static::MAX_NUMBER_OF_URLs;
        $this->siteCharset      = get_bloginfo( 'charset' );
        $this->gmtOffset        = (int) get_option( 'gmt_offset' );
        $this->timezoneOffset   = sprintf( '%+03d:00', $this->gmtOffset );

        if ( WP_DEBUG ) {
            $this->lineBreak = "\n";
        }
    }

    /**
     * @since 4.0
     *
     * @param string $attribute
     * @param int $max_length
     * @return string
     */
    protected function prepareAttribute( $attribute, $max_length = 70 ) {
        $attribute = html_entity_decode( $attribute, ENT_QUOTES, $this->siteCharset );
        $attribute = preg_replace( '/[\n\r\t\040]+/', ' ', strip_tags( $attribute ) );
        $attribute = sitetree_fn\truncate_sentence( $attribute, $max_length );
        
        return htmlspecialchars( $attribute, ENT_QUOTES );
    }

    /**
     * @since 4.0
     *
     * @param bool $count_ghost_pages
     * @return 
     */
    protected function countExcludedPosts( $count_ghost_pages = false ) {
        $exclude_from_key = 'exclude_from_' . static::SITEMAP_ID;
        $meta_keys        = $this->db->prepareMetaKey( $exclude_from_key );

        if ( $count_ghost_pages ) {
            $meta_keys .= ',';
            $meta_keys .= $this->db->prepareMetaKey( 'is_ghost_page' );
        }
        
        $query_results = $this->wpdb->get_results(
            "SELECT COUNT(*) AS count 
             FROM {$this->wpdb->posts} AS p
             INNER JOIN {$this->wpdb->postmeta} AS pm ON p.ID = pm.post_id
             WHERE pm.meta_key IN ({$meta_keys}) AND pm.meta_value = '1' AND 
                   p.post_type IN ({$this->postTypesList}) AND 
                   p.post_status = 'publish' AND p.post_password = ''"
        );
                
        return $query_results[0]->count;
    }
}
?>