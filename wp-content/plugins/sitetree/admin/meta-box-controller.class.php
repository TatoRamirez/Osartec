<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 1.3
 */
final class SiteTreeMetaBoxController {
	/**
     * @since 1.4
     * @var object
     */
    private $plugin;
	
	/**
	 * @since 1.3
	 * @var object
	 */
	private $db;
	
	/**
	 * @since 1.3.1
	 * @var array
	 */
	private $sections = array();
	
	/**
	 * @since 1.3
	 * @param object $plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->db	  = $plugin->db();
	}

	/**
	 * @since 2.0
     *
     * @param string $post_type
	 * @param object $post
	 */
	public function wpDidAddMetaBoxes( $post_type, $post ) {
        if ( $this->initSections( $post ) ) {
			add_meta_box( 'sitetree', 'SiteTree', array( $this, 'displayMetaBox' ), $post_type, 'side' );
        }
	}

    /**
     * @since 2.0
     *
     * @param object $post
     * @return bool
     */
    private function initSections( $post ) {
        if ( $post->ID == get_option( 'page_on_front' ) ) {
            return false;
        }

        $is_sitemap_active = $this->plugin->isSitemapActive();
        $site_tree_id      = (int) $this->db->getOption( 'page_for_site_tree' );

        if (
            $is_sitemap_active &&
            ( $post->post_type == 'page' ) &&
            ( $post->ID != $site_tree_id ) &&
            ( $post->ID != get_option( 'page_for_posts' ) )
        ) {
            $this->sections[] = new SiteTreeSection();

            $this->sections[0]->addField(
                new SiteTreeField( 'is_ghost_page','SiteTreeMetaCheckbox', 'bool', '', 
                                   __( 'This is a Ghost Page', 'sitetree' ), false )
            );
        }

        $exclude_section = new SiteTreeSection( __( 'Exclude From...', 'sitetree' ) );
        
        if (
            ( $post->ID != $site_tree_id ) &&
            $this->plugin->isSitemapActive( 'site_tree' ) &&
            $this->db->getOption( $post->post_type, false, 'site_tree_content_types' )
        ) {
            $exclude_section->addField(
                new SiteTreeField( 'exclude_from_site_tree','SiteTreeMetaCheckbox', 'bool', '', 
                                   'Site Tree', false, array( 'context' => 'site_tree' ) )
            );
        }

        if ( 
            $is_sitemap_active &&
            $this->db->getOption( $post->post_type, false, 'sitemap_content_types' )
        ) {
            $exclude_section->addField(
                new SiteTreeField( 'exclude_from_sitemap', 'SiteTreeMetaCheckbox', 'bool', '',
                                   'Google Sitemap', false, array( 'context' => 'sitemap' ) )
            );
        }

        if ( 
            $this->plugin->isSitemapActive( 'newsmap' ) &&
            $this->db->getOption( $post->post_type, false, 'newsmap_content_types' )
        ) {
            $exclude_section->addField(
                new SiteTreeField( 'exclude_from_newsmap', 'SiteTreeMetaCheckbox', 'bool', '',
                                   'News Sitemap', false, array( 'context' => 'newsmap' ) )
            );
        }

        if ( $exclude_section->hasFields() ) {
            $this->sections[] = $exclude_section;
        }
        
        return !empty( $this->sections );
    }

	/**
	 * @since 2.0
	 * @param object $post
	 */
	public function displayMetaBox( $post ) {
        echo '<input type="hidden" name="sitetree_nonce" value="';
        echo wp_create_nonce( 'sitetre_metadata' );
        echo '">';
        
        foreach ( $this->sections as $section ) {
            $fields        = $section->fields();
            $section_title = $section->title();

            if ( $section_title ) {
                echo '<h4>', $section->title(), '</h4>';   
            }
           
            foreach ( $fields as $field ) {
                $value = $this->db->getPostMeta( $post->ID,
                                                 $field->id(),
                                                 $field->defaultValue() );
                
                $filter = new SiteTreeOptionsFilter( $value, $field );
                $value  = $filter->filterOption();
                
                $fieldView = SiteTreeFieldView::makeView( $field );
                $fieldView->init( $value );

                echo '<div style="margin-top:10px;">';

                $fieldView->display();

                echo '</div>';
            }
        }
    }
	
	/**
	 * @since 2.0
	 *
	 * @param string $post_id
	 * @param object $post
	 */
	public function wpDidSavePost( $post_id, $post ) {
        if ( 
            !isset( $_POST['sitetree_nonce'] ) || 
            ( $post->post_status == 'auto-draft' ) ||
            wp_is_post_revision( $post )
        ) {
            return false;
        }

        check_admin_referer( 'sitetre_metadata', 'sitetree_nonce' );
            
        if (! current_user_can( 'edit_post', $post ) ) {
            wp_die( 'Bad fellow.' );
        }
        
        if (! $this->initSections( $post ) ) {
            wp_die( 'Bad fellow.' );
        }

        if ( isset( $_POST['sitetree'] ) && !is_array( $_POST['sitetree'] ) ) {
            wp_die( 'Bad fellow.' );
        }

        $fields = $this->sections[0]->fields();

        if ( $fields[0]->id() == 'is_ghost_page' ) {
            $is_ghost_page = false;

            if ( isset( $_POST['sitetree']['is_ghost_page'] ) ) {
                $filter        = new SiteTreeOptionsFilter( $_POST['sitetree']['is_ghost_page'], $fields[0] );
                $is_ghost_page = $filter->filterOption();
            }

            if ( $is_ghost_page ) {
                $was_ghost_page = $this->db->getPostMeta( $post->ID, 'is_ghost_page' );

                if (! $was_ghost_page ) {
                    $this->db->setPostMeta( $post->ID, 'is_ghost_page', true );
                    $this->db->deletePostMeta( $post->ID, 'exclude_from_sitemap' );
                    $this->db->deletePostMeta( $post->ID, 'exclude_from_site_tree' );
                    $this->plugin->flushCachedData( 'sitemap' );
                    $this->plugin->flushCachedData( 'site_tree' );
                }
                
                return true;
            }
            
            $fields = $this->sections[1]->fields();
            
            $this->db->deletePostMeta( $post->ID, 'is_ghost_page' );
        }
        
        foreach ( $fields as $field ) {
            $value    = false;
            $field_id = $field->id();
            
            if ( isset( $_POST['sitetree'][$field_id] ) ) {
                $filter = new SiteTreeOptionsFilter( $_POST['sitetree'][$field_id], $field );
                $value  = $filter->filterOption();
            }
            
            $this->processExcludeFlag( $post, $field, $value );
        }
    }

    /**
     * @since 2.0
     *
     * @param object $post
     * @param object $field
     * @param bool $exclude
     * @return bool
     */
    private function processExcludeFlag( $post, $field, $exclude ) {
        $is_excluded = (bool) $this->db->getPostMeta( $post->ID, $field->id() );

        if ( $exclude ) {
            if ( $is_excluded ) {
                return false;
            }

            $this->db->setPostMeta( $post->ID, $field->id(), $exclude );
        }
        elseif ( $is_excluded ) {
            $this->db->deletePostMeta( $post->ID, $field->id() );  
        }

        if ( $post->post_status != 'publish' ) {
            return false;
        }

        $is_new_post = ( strtotime( $post->post_modified ) - strtotime( $post->post_date ) < 5 );

        if ( !( $exclude && $is_new_post ) ) {
            $this->plugin->flushCachedData( $field->config['context'] );
        }
        
        if (
            !$exclude && 
            $is_new_post && 
            ( $field->config['context'] != 'site_tree' ) &&
            ( $this->db->getOption( 'automatic_pinging_on' ) || ( $field->config['context'] == 'newsmap' ) )
        ) {
            $this->plugin->pingController()->ping( $field->config['context'], true );
        }
        
        return true;
    }
}