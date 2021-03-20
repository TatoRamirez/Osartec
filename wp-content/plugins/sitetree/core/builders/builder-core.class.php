<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 * 
 *
 * @since 2.0
 */
abstract class SiteTreeBuilderCore {
    /**
     * @since 4.0
     * @var object
     */
    protected $plugin;

    /**
	 * @since 2.0
	 * @var object
	 */
	protected $db;

    /**
     * Reference to the global $wpdb object.
     *
     * @since 2.0
     * @var object
     */
    protected $wpdb;

    /**
     * @since 2.0
     * @var string
     */
    protected $output = '';

    /**
     * Total number of items that have been created.
     *
     * The nature of the items is determined by 
     * the nature of the parent class.
     *
     * @since 2.0
     * @var int
     */
    protected $numberOfItems = 0;

    /**
     * Maximum number of items that the builder can create.
     *
     * @since 2.0
     * @var int
     */
    protected $buildingCapacity;
	
	/**
     * Collection of information about the 
     * building process.
     *
     * @since 4.0
     * @var array
     */
    protected $stats = array();
	
	/**
	 * @since 2.0
	 * @param object $plugin
     */
    public function __construct( $plugin ) {
        global $wpdb;
        
        $this->plugin = $plugin;
        $this->db     = $plugin->db();
        $this->wpdb   = $wpdb;
    }

    /**
     * @since 4.0
     * @return string
     */
    public function sitemapID() {
        return static::SITEMAP_ID;
    }

    /**
     * @since 4.0.1
     * @return int
     */
    public function getNumberOfItems() {
        return $this->numberOfItems;
    }

    /**
     * @see $stats
     * @since 2.0
     *
     * @return array
     */
    public function getStats() {
        return $this->stats;
    }

    /**
     * Starts the buiding process and returns its product.
     *
     * @since 2.0
     * @return string
     */ 
    public function &build() {
        $this->startCounters();
        $this->runBuildingProcess();
        $this->stopCounters();

        return $this->output;
    }

    /**
     * @since 2.0
     */
    abstract protected function runBuildingProcess();

    /**
     * @since 2.0
     */
    protected function startCounters() {
        $this->stats['runtime']     = -microtime( true );
        $this->stats['num_queries'] = -get_num_queries();
    }

    /**
     * @since 2.0
     */
    protected function stopCounters() {
        $this->stats['num_items']    = $this->numberOfItems;
        $this->stats['num_queries'] += get_num_queries();
        $this->stats['runtime']      = round( $this->stats['runtime'] + microtime(true), 3 );
    }

    /**
     * @see $numberOfItems
     * @since 2.0
     */
    public function incrementItemsCounter() {
        $this->numberOfItems += 1;
    }

    /**
     * Returns the maximum number of items that the builder
     * can still create.
     *
     * @since 2.0
     * @return int
     */ 
    protected function buildingCapacityLeft() {
        return $this->buildingCapacity - $this->numberOfItems;
    }
}
?>