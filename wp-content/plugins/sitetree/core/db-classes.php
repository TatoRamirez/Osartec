<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * Abstraction layer built upon the Database APIs.
 *
 * @since 1.2
 */
final class SiteTreeDB {
	/**
     * 30 days.
     *
	 * @since 2.0
	 */
	const CACHE_LIFETIME = 2592000;

    /**
     * @since 2.1
     * @var string
     */
    private $optionsID;
    
    /**
     * @since 2.0
     * @var string
     */
    private $dbKeyPrefix;

    /**
     * @since 2.0
     * @var string
     */
    private $metaKeyPrefix;

    /**
     * @since 2.1
     * @var object
     */
    private $wpdb;

    /**
     * @since 2.1
     * @var array
     */
    private $options;

    /**
     * @since 3.2
     * @var array
     */
    private $nonAutoloadOptions = array();

    /**
     * @since 3.2
     * @var bool
     */
    private $consolidateOptions;

    /**
     * @since 3.2
     * @var array
     */
    private $nonAutoloadOptionsToConsolidate = array();

    /**
     * @since 1.5
     * @var array
     */
    private $metadata;

    /**
     * @since 2.1
     * @var bool
     */
    private $consolidate = false;

    /**
     * @since 1.5
     * @param string $options_id
     */
    public function __construct( $options_id ) {
        global $wpdb;

        $this->wpdb          = $wpdb;
        $this->optionsID     = $options_id;
        $this->dbKeyPrefix   = str_replace( '_', '', $options_id ) . '_';
        $this->metaKeyPrefix = '_' . $this->dbKeyPrefix;
        $this->options       = get_option( $options_id );

        if (! is_array( $this->options ) ) {
            $this->options = array();
        }
    }

    /**
     * @since 2.1
     * @return string
     */
    public function optionsID() {
        return $this->optionsID;
    }

    /**
     * @since 2.1
     * @return string
     */
    public function dbKeyPrefix() {
        return $this->dbKeyPrefix;
    }

    /**
     * @since 2.1
     * @return string
     */
    public function metaKeyPrefix() {
        return $this->metaKeyPrefix;
    }

    /**
     * @since 3.1
     *
     * @param string $key
     * @return string
     */
    public function prepareMetaKey( $key ) {
        return "'{$this->metaKeyPrefix}{$key}'";
    }

    /**
     * @since 2.1
     *
     * @param string $key
     * @param mixed $default
     * @param string $group
     * @param string $context
     * @return mixed
     */
    public function getOption( $key, $default = false, $group = '', $context = '' ) {
        if ( $group === '' ) {
            if ( isset( $this->options[$key] ) ) {
                if ( is_object( $this->options[$key] ) ) {
                    return clone $this->options[$key];
                }

                return $this->options[$key];
            }
        }
        elseif ( $context  === '' ) {
            if ( isset( $this->options[$group][$key] ) ) {
                if ( is_object( $this->options[$group][$key] ) ) {
                    return clone $this->options[$group][$key];
                }
                
                return $this->options[$group][$key];
            }
        }
        elseif ( isset( $this->options[$context][$group][$key] ) ) {
            if ( is_object( $this->options[$context][$group][$key] ) ) {
                return clone $this->options[$context][$group][$key];
            }
            
            return $this->options[$context][$group][$key];
        }
        
        return $default;
    }

    /**
     * @since 2.1
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function setOption( $key, $value, $group = '', $context = '' ) {
        $old_value = $this->getOption( $key, false, $group, $context );

        if ( $value === null ) {
            $value = false;
        }

        if ( ( $value === $old_value ) || ( maybe_serialize( $value ) === maybe_serialize( $old_value ) ) ) {
            return false;
        }

        if ( is_object( $value ) ){
            $value = clone $value;
        }

        if ( $group === '' ){
            $this->options[$key] = $value;
        }
        elseif ( $context === '' ) {
            $this->options[$group][$key] = $value;
        }
        else {
            $this->options[$context][$group][$key] = $value;
        }

        $this->consolidateOptions = true;
        
        return true;
    }
    
    /**
     * @since 2.1
     *
     * @param string $key
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function deleteOption( $key, $group = '', $context = '' ) {
        if ( $this->getOption( $key, null, $group, $context ) === null ) {
            return false;
        }

        if ( $group === '' ) {
            unset( $this->options[$key] );
        }
        elseif ( $context === '' ) {
            unset( $this->options[$group][$key] );
        }
        else {
            unset( $this->options[$context][$group][$key] );
        }

        $this->consolidateOptions = true;

        return true;
    }

    /**
     * @since 2.1
     *
     * @param string $key
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function optionExists( $key, $group = '', $context = '' ) {
        if ( $group === '' ) {
            return isset( $this->options[$key] );
        }

        if ( $context === '' ) {
            return isset( $this->options[$group][$key] );
        }
    
        return isset( $this->options[$context][$group][$key] );
    }

    /**
     * @since 2.1
     *
     * @param array $options
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function setOptions( $options, $group = '', $context = '' ) {
        $options_set = false;

        foreach ( $options as $key => &$value ) {
            if ( $this->setOption( $key, $value, $group, $context ) ) {
                $options_set = true;
            }
        }
        
        return $options_set;
    }
    
    /**
     * Returns a copy of the whole {@see $options} array.
     *
     * @since 2.1
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @since 2.1
     *
     * @param array $new_options
     * @return bool
     */
    public function overwriteOptions( $new_options ) {
        if ( serialize( $this->options ) ===  serialize( $new_options ) ) {
            return false;
        }

        $this->consolidateOptions = true;
        $this->options            = $new_options;

        return true;
    }

    /**
     * @since 3.2
     *
     * @param string $id
     * @return bool
     */
    private function initNonAutoloadOptionsElement( $id ) {
        if ( isset( $this->nonAutoloadOptions[$id] ) ) {
            return false;
        }

        $option_id = $this->dbKeyPrefix . $id;

        $this->nonAutoloadOptions[$id] = get_option( $option_id );

        return true;
    }

    /**
     * @since 3.2
     *
     * @param string $id
     * @param mixed $default
     * @param string $key
     * @param string $group
     * @param string $context
     * @return mixed
     */
    public function getNonAutoloadOption( $id, $default = false, $key = '', $group = '', $context = '' ) {
        $this->initNonAutoloadOptionsElement( $id );

        if ( $key === '' ) {
            if ( isset( $this->nonAutoloadOptions[$id] ) ) {
                if ( is_object( $this->nonAutoloadOptions[$id] ) ) {
                    return clone $this->nonAutoloadOptions[$id];
                }

                return $this->nonAutoloadOptions[$id];
            }
        }   
        elseif ( $group === '' ) {
            if ( isset( $this->nonAutoloadOptions[$id][$key] ) ) {
                if ( is_object( $this->nonAutoloadOptions[$id][$key] ) ) {
                    return clone $this->nonAutoloadOptions[$id][$key];
                }

                return $this->nonAutoloadOptions[$id][$key];
            }
        }
        elseif ( $context  === '' ) {
            if ( isset( $this->nonAutoloadOptions[$id][$group][$key] ) ) {
                if ( is_object( $this->nonAutoloadOptions[$id][$group][$key] ) ) {
                    return clone $this->nonAutoloadOptions[$id][$group][$key];
                }
                
                return $this->nonAutoloadOptions[$id][$group][$key];
            }
        }
        elseif ( isset( $this->nonAutoloadOptions[$id][$context][$group][$key] ) ) {
            if ( is_object( $this->nonAutoloadOptions[$id][$context][$group][$key] ) ) {
                return clone $this->nonAutoloadOptions[$id][$context][$group][$key];
            }
            
            return $this->nonAutoloadOptions[$id][$context][$group][$key];
        }
        
        return $default;
    }

    /**
     * @since 3.2
     *
     * @param string $id
     * @param mixed $value
     * @param string $key
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function setNonAutoloadOption( $id, $value, $key = '', $group = '', $context = '' ) {
        $old_value = $this->getNonAutoloadOption( $id, false, $key, $group, $context );

        if ( $value === null ) {
            $value = false;
        }

        if ( ( $value === $old_value ) || ( maybe_serialize( $value ) === maybe_serialize( $old_value ) ) ) {
            return false;
        }

        if ( is_object( $value ) ){
            $value = clone $value;
        }

        if ( $key === '' ){
            $this->nonAutoloadOptions[$id] = $value;
        }
        elseif ( $group === '' ){
            $this->nonAutoloadOptions[$id][$key] = $value;
        }
        elseif ( $context === '' ) {
            $this->nonAutoloadOptions[$id][$group][$key] = $value;
        }
        else {
            $this->nonAutoloadOptions[$id][$context][$group][$key] = $value;
        }

        $this->nonAutoloadOptionsToConsolidate[$id] = $id;
        
        return true;
    }

    /**
     * @since 3.2
     *
     * @param string $id
     * @param string $key
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function deleteNonAutoloadOption( $id, $key = '', $group = '', $context = '' ) {
        if ( $this->getNonAutoloadOption( $id, null, $key, $group, $context ) === null ) {
            return false;
        }

        if ( $key !== '' ) {
            $this->nonAutoloadOptionsToConsolidate[$id] = $id;

            if ( $group === '' ) {
                unset( $this->nonAutoloadOptions[$id][$key] );
            }
            elseif ( $context === '' ) {
                unset( $this->nonAutoloadOptions[$id][$group][$key] );
            }
            else {
                unset( $this->nonAutoloadOptions[$id][$context][$group][$key] );
            }

            return true;
        }
        
        unset( $this->nonAutoloadOptions[$id] );

        $option_id = $this->dbKeyPrefix . $id;

        return delete_option( $option_id ); 
    }

    /**
     * @since 3.2
     *
     * @param string $id
     * @param string $key
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function nonAutoloadOptionExists( $id, $key = '', $group = '', $context = '' ) {
        $this->initNonAutoloadOptionsElement( $id );

        if ( $key === '' ) {
            return !empty( $this->nonAutoloadOptions[$id] );
        }

        if ( $group === '' ) {
            return isset( $this->nonAutoloadOptions[$id][$key] );
        }

        if ( $context === '' ) {
            return isset( $this->nonAutoloadOptions[$id][$group][$key] );
        }
    
        return isset( $this->nonAutoloadOptions[$id][$context][$group][$key] );
    }

    /**
     * @since 3.2
     *
     * @param string $id
     * @param array $options
     * @param string $group
     * @param string $context
     * @return bool
     */
    public function setNonAutoloadOptions( $id, $options, $group = '', $context = '' ) {
        $options_set = false;

        foreach ( $options as $key => &$value ) {
            if ( $this->setNonAutoloadOption( $id, $value, $key, $group, $context ) ) {
                $options_set = true;
            }
        }
        
        return $options_set;
    }
    
    /**
     * @since 1.5
     *
     * @param int $post_id
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setPostMeta( $post_id, $key, $value ) {
        $meta_key = $this->metaKeyPrefix . $key;
        
        $this->metadata[$post_id][$meta_key][0] = $value;

        return update_metadata( 'post', $post_id, $meta_key, $value );
    }
    
    /**
     * @since 1.5
     *
     * @param int $post_id
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPostMeta( $post_id, $key, $default = false ) {
        $meta_key = $this->metaKeyPrefix . $key;
        
        if (! isset( $this->metadata[$post_id] ) ) {
            $this->metadata[$post_id] = get_metadata( 'post', $post_id );
        }

        if ( isset( $this->metadata[$post_id][$meta_key][0] ) ) {
            return $this->metadata[$post_id][$meta_key][0];
        }
        
        return $default;
    }
    
    /**
     * @since 1.5
     *
     * @param int $post_id
     * @param string $key
     * @return bool
     */
    public function deletePostMeta( $post_id, $key ) {
        $meta_key = $this->metaKeyPrefix . $key;
        
        unset( $this->metadata[$post_id][$meta_key] );
        
        return delete_metadata( 'post', $post_id, $meta_key );
    }

    /**
     * @since 2.1
     * @return bool
     */
    public function consolidate() {
        if ( isset( $this->consolidateOptions ) ){
            update_option( $this->optionsID, $this->options );
        }

        foreach ( $this->nonAutoloadOptionsToConsolidate as $id ) {
            $option_id = $this->dbKeyPrefix . $id;

            update_option( $option_id, $this->nonAutoloadOptions[$id], 'no' );
        }
    }
}
?>