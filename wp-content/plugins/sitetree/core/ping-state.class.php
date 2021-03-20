<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 3.2
 */
final class SiteTreePingState {
    /**
     * @since 4.1
     * @var string
     */
    private $sitemapID;

    /**
     * Status code that identifies the overall state 
     * of the instance.
     *
     * @since 3.2
     * @var string
     */
    private $code = 'no_pings_yet';
    
    /**
     * Timestamp of the latest ping event.
     *
     * @since 4.1
     * @var int
     */
    private $latestTime = 0;

    /**
     * Array of timestamps related to when each ping was sent.
     *
     * @since 3.2
     * @deprecated Since version 4.1
     *
     * @var array
     */
    private $times = array();

    /**
     * @since 3.2
     * @param string $sitemap_id
     */
    public function __construct( $sitemap_id ) {
        $this->sitemapID = $sitemap_id;
    }

    /**
     * @since 4.1
     *
     * @param string $sitemap_id
     * @return string
     */
    public function setSitemapID( $sitemap_id ) {
        $this->sitemapID = $sitemap_id;
    }

    /**
     * @since 4.1
     * @return string
     */
    public function sitemapID() {
        return $this->sitemapID;
    }

    /**
     * @since 3.2
     * @param string $code
     */
    public function setCode( $code ) {
        $this->code = $code;
    }

    /**
     * @since 3.2
     * @return string
     */
    public function getCode() {
        return $this->code; 
    }

    /**
     * @since 3.2
     */
    public function registerTime() {
        $this->latestTime = time();
    }
    
    /**
     * @since 4.1
     * return int
     */
    public function getLatestTime() {
        return $this->latestTime;
    }

    /**
     * Utility method called by the Upgrader.
     * Accesses the deprecated property {@see $times}.
     *
     * @since 4.1
     */
    public function resetTimes() {
        $this->latestTime = max( $this->times );
        $this->times      = array();
    }
}
?>