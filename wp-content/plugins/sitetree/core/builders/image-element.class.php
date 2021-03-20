<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 */
interface SiteTreeImageElementInterface {
    /**
     * Returns a SiteTreeImageElement object.
     *
     * @since 2.1
     *
     * @param string $url     Absolute URL of the image file.
     * @param string $title   Optional.
     * @param string $caption Optional.
     * @return object
     */
    public static function make( $url, $title = '', $caption = '' );
}


/*
 * @since 2.0
 */
final class SiteTreeImageElement implements SiteTreeImageElementInterface {
	/**
     * @since 2.1
     * @var int
     */
    private $ID;

    /**
     * @since 2.0
     * @var string
     */
    private $url;

    /**
     * @since 2.0
     * @var string
     */
    private $title;

    /**
     * @since 2.0
     * @var string
     */
    private $caption;

    /**
     * {@inheritdoc}
     */
    public static function make( $url, $title = '', $caption = '' ) {
        $url = esc_url( $url );

        if ( $title ) {
            $title = sanitize_text_field( $title );
        }

        if ( $caption ) {
            $caption = sanitize_text_field( $caption );
        }

        return new self( $url, $title, $caption );
    }

    /**
     * @since 2.1
     *
     * @param object $attachment
     * @return object
     */
    public static function makeFromAttachment( $attachment ) {
        $caption = '';
        
        if ( $attachment->post_excerpt ) {
            $caption = $attachment->post_excerpt;
        }
        else {
            $caption = $attachment->post_content;
        }

        $image     = new self( '', $attachment->post_title, $caption );
        $image->ID = $attachment->ID;

        return $image;
    }

    /**
     * @since 2.0
     *
     * @param string $url
     * @param string $title
     * @param string $caption
     */
    private function __construct( $url, $title, $caption ) {
        $this->url     = $url;
        $this->title   = $title;
        $this->caption = $caption;
    }

    /**
     * @since 2.0
     * @return string
     */
    public function url() {
    	if ( $this->ID && !$this->url ) {
    		$this->url = wp_get_attachment_url( $this->ID );
    	}

    	return $this->url;
    }

    /**
     * @since 2.0
     * @return string
     */
    public function title() {
    	return $this->title;
    }

    /**
     * @since 2.0
     * @return string
     */
    public function caption() {
    	return $this->caption;
    }
}
?>