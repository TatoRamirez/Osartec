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
final class SiteTreeAdminController {
    /**
     * @since 2.0
     * @var object
     */
    private $plugin;

    /**
     * @since 2.0
     * @var object
     */
    private $db;

    /**
     * @since 2.0
     * @var object
     */
    private $dataController;

    /**
     * @since 2.0
     * @var string
     */
    private $currentPageId;

    /**
     * Local copy of the global $pagenow.
     *
     * @since 2.0
     * @var string
     */
    private $wpAdminPageId;

    /**
     * @since 2.0
     * @param string
     */
    private $taxonomyId;

    /**
     * @since 2.0
     *
     * @param object $plugin
     * @param object $dataController
     */
    public function __construct( $plugin, $dataController = null ) {
        global $pagenow;

        $this->plugin         = $plugin;
        $this->db             = $plugin->db();
        $this->wpAdminPageId  = $pagenow;
        $this->dataController = $dataController;
    }

    /**
     * @since 2.0
     */
    public function init() {
        $this->listenForUserAction();
        $this->registerActions();
    }

    /**
     * @since 2.0
     */
    private function listenForUserAction() {
        if ( $_POST && isset( $_POST['sitetree_page'] ) ) {
            $page_id = sanitize_key( $_POST['sitetree_page'] );
        }
        elseif ( $_GET && isset( $_GET['page'], $_GET['sitetree_nonce'] ) ) {
            $namespaced_page_id = sanitize_key( $_GET['page'] );
            $page_id            = str_replace( 'sitetree-', '', $namespaced_page_id );
        }
        else {
            return false;
        }

        $this->plugin->load( 'admin/page-view-delegate-protocols.php' );
        $this->plugin->load( 'admin/page-controller-classes.php' );

        $page = $this->dataController->page( $page_id );
        
        if ( !( $page && $this->wpAdminPageId == $page->menuId() ) ) {
            wp_die( __( 'Request sent to a non existent page.', 'sitetree' ) );
        }

        if ( !( isset( $_REQUEST['action'] ) && current_user_can( 'manage_options' ) ) ) {
            wp_die( 'You are being a bad fellow.' );
        }
            
        if ( is_multisite() && !is_super_admin() ) {
            wp_die( 'You are being a bad fellow.' );
        }

        $action_id      = sanitize_key( $_REQUEST['action'] );
        $pageController = SiteTreePageController::makeController( $page,
                                                                  $this->plugin,
                                                                  $this->dataController );

        check_admin_referer( $action_id, 'sitetree_nonce' );

        $redirect_url = $pageController->performUserAction( $action_id );

        if (! $redirect_url ) {
            wp_die( __( 'Unknown action.', 'sitetree' ) );
        }

        wp_redirect( $redirect_url );
        exit;
    }

    /**
     * @since 2.0
     */
    private function registerActions() {
        add_action( 'admin_menu', array( $this, 'registerAdminPages' ) );

        switch ( $this->wpAdminPageId ) {
            case 'post.php':
            case 'post-new.php':
                $this->plugin->load( 'admin/sitetree-field-view.class.php' );
                $this->plugin->load( 'admin/meta-box-controller.class.php' );
                
                $metaBoxController = new SiteTreeMetaBoxController( $this->plugin );
                
                add_action( 'add_meta_boxes', array( $metaBoxController, 'wpDidAddMetaBoxes' ), 10, 2 );
                add_action( 'edit_attachment', array( $this, 'wpDidModifyAttachment' ), 100 );
                add_action( 'delete_attachment', array( $this, 'wpDidModifyAttachment' ), 100 );
                
                // When the POST request is sent from 'post-new.php',
                // sometimes WordPress doesn't invoke wpDidSavePost()
                // if it has been registered with a priority higher than 20.
                add_action( 'save_post', array( $metaBoxController, 'wpDidSavePost' ), 20, 2 );
                // Break omitted.

            case 'edit.php':
                add_action( 'trashed_post', array( $this, 'wpDidTrashPost' ), 100 );
                add_action( 'untrashed_post', array( $this, 'wpDidTrashPost' ), 100 );
                break;

            case 'plugins.php':
                $filter_name = 'plugin_action_links_' . $this->plugin->basename();

                add_filter( $filter_name, array( $this, 'addDashboardLinkToActionLinks' ) );
                add_filter( 'plugin_row_meta', array( $this, 'wpWillDisplayPluginRowMetadata' ), 10, 2 );
                break;

            case 'edit-tags.php':
                if (! isset( $_REQUEST['taxonomy'] ) ) {
                    break;
                }

                $this->taxonomyId = sanitize_key( $_REQUEST['taxonomy'] );

                if (! taxonomy_exists( $this->taxonomyId ) ) {
                    break;
                }

                add_action( 'edit_' . $this->taxonomyId, array( $this, 'wpDidModifyTaxonomy' ), 100 );
                add_action( 'create_' . $this->taxonomyId, array( $this, 'wpDidModifyTaxonomy' ), 100 );
                add_action( 'delete_' . $this->taxonomyId, array( $this, 'wpDidModifyTaxonomy' ), 100 );
                break;
                
            case 'user-new.php':
                add_action( 'user_register', array( $this, 'wpDidModifyUserProfile' ), 100 );
                break;
                
            case 'user-edit.php':
            case 'profile.php': 
                add_action( 'profile_update', array( $this, 'wpDidModifyUserProfile' ), 100 );
                break;
                
            case 'users.php':
                add_action( 'delete_user', array( $this, 'wpDidModifyUserProfile' ), 100 );
                break;
        }
    }

    /**
     * @since 2.0
     */
    public function registerAdminPages() {
        $pages = $this->dataController->pages( false );

        foreach ( $pages as $page ) {
            $namespaced_page_id = 'sitetree-' . $page->id();

            if ( isset( $_GET['page'] ) && 
                 $_GET['page'] == $namespaced_page_id &&
                 $this->wpAdminPageId == $page->menuId() )
            {
                $this->plugin->load( 'admin/sitetree-field-view.class.php' );
                $this->plugin->load( 'admin/sitetree-page-view.class.php' );
                $this->plugin->load( 'admin/page-view-delegate-protocols.php' );
                $this->plugin->load( 'admin/page-controller-classes.php' );

                $this->currentPageId = $namespaced_page_id;
                
                $pageController = SiteTreePageController::makeController( $page,
                                                                          $this->plugin,
                                                                          $this->dataController );
                
                $pageView = $pageController->loadPageView();
                $page_uid = add_submenu_page( $page->menuId(), $page->title(), $page->menuTitle(),
                                              'manage_options', $namespaced_page_id,
                                              array( $pageView, 'display' ) );

                if ( $page->hasHelpPanel() )
                    add_action( 'load-' . $page_uid, array( $pageController, 'registerHelpPanel' ) );

                add_action( 'admin_enqueue_scripts', array( $this, 'enqueueStylesAndScripts' ) );
                add_action( 'admin_print_footer_scripts', array( $this, 'printInitScript' ) );
            }
            else {
                add_submenu_page( $page->menuId(), $page->title(), $page->menuTitle(),
                                  'manage_options', $namespaced_page_id, '__return_false' );
            }
        }
    }

    /**
     * @since 2.0
     */
    public function enqueueStylesAndScripts() {
        $min_suffix   = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '-min';
        $version      = $this->plugin->version();
        $css_file_url = $this->plugin->dirURL( 'resources/sitetree' . $min_suffix . '.css' );
        $js_file_url  = $this->plugin->dirURL( 'resources/sitetree' . $min_suffix . '.js' );
        
        wp_enqueue_style( 'sitetree', $css_file_url, null, $version );
        wp_enqueue_script( 'sitetree', $js_file_url, array( 'jquery' ), $version );
    }

    /**
     * @since 2.0
     *
     * @param array $action_links
     * @return array
     */
    public function addDashboardLinkToActionLinks( $action_links ) {
        $action_links['dashboard'] = '<a href="' . $this->dashboardURL()
                                   . '">' . __( 'Dashboard', 'sitetree' )
                                   . '</a>';

        return $action_links;
    }

    /**
     * @since 2.0
     */
    public function dashboardURL() {
        $dashboard          = $this->dataController->page( 'dashboard' );
        $namespaced_page_id = 'sitetree-' . $dashboard->id();
        $arguments          = array( 'page' => $namespaced_page_id );  

        return add_query_arg( $arguments, admin_url( $dashboard->menuId() ) );
    }

    /**
     * @since 2.0
     */
    public function printInitScript() {
        echo '<script>SiteTree.init("', $this->currentPageId,'");</script>';
    }

    /**
     * @since 2.2
     *
     * @param array $metadata
     * @param string $plugin_basename
     * @return array
     */
    public function wpWillDisplayPluginRowMetadata( $metadata, $plugin_basename ) {
    	if ( $plugin_basename == $this->plugin->basename() ) {
    		$metadata[] = '<a href="' . $this->plugin->pluginURI( 'go-pro/' ) 
    		            . '">' . __( 'Upgrade', 'sitetree' ) . '</a>';
    	}

    	return $metadata;
    }

    /**
     * @since 2.0
     *
     * @param string $post_id
     * @param object $post
     */
    public function wpDidSavePost( $post_id, $post ) {
        if ( !( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
            return false;
        }

        if ( ( $post->post_status != 'publish' ) || !current_user_can( 'edit_post', $post ) ) {
            return false;
        }

        if ( $post->ID == get_option( 'page_on_front' ) ) {
            $this->plugin->flushCachedData( 'sitemap' );
        }
    }

    /**
     * @since 2.0
     * @param int $post_id
     */
    public function wpDidTrashPost( $post_id ) {
        $post = get_post( $post_id );

        if (! $post ) {
            return false;
        }

        if (
            $this->plugin->isSitemapActive( 'site_tree' ) &&
            $this->db->getOption( $post->post_type, false, 'site_tree_content_types' ) && 
            !$this->db->getPostMeta( $post->ID, 'exclude_from_site_tree' )
        ) {
            $this->plugin->flushCachedData( 'site_tree' );
        }
        
        if (
            $this->plugin->isSitemapActive() &&
            $this->db->getOption( $post->post_type, false, 'sitemap_content_types' )
        ) {
            $this->plugin->flushCachedData( 'sitemap' );
        }

        if ( 
            $this->plugin->isSitemapActive( 'newsmap' ) &&
            $this->db->getOption( $post->post_type, false, 'newsmap_content_types' )
        ) {
            $this->plugin->flushCachedData( 'newsmap' );
        }
    }
    
    /**
     * @since 2.0
     * @param int $user_id
     */
    public function wpDidModifyUserProfile( $user_id ) {
        if (
            $this->plugin->isSitemapActive( 'site_tree' ) &&
            (
                $this->db->getOption( 'authors', false, 'site_tree_content_types' ) || 
                $this->db->getOption( 'group_by', false, 'post', 'site_tree' ) == 'author'
            )
        ) {
            $excluded_authors = explode( ', ', $this->db->getOption( 'exclude', '', 'authors', 'site_tree' ) );

            if ( 
                !( 
                    $excluded_authors && 
                    in_array( get_userdata( $user_id )->user_nicename, $excluded_authors )
                ) 
            ) {
                $this->plugin->flushCachedData( 'site_tree' );
            }            
        }
        
        if (
            $this->plugin->isSitemapActive() &&
            $this->db->getOption('authors', false, 'sitemap_content_types')
        ) {
            $this->plugin->flushCachedData( 'sitemap' );
        }
    }
    
    /**
     * @since 2.0
     * @param int $term_id
     */ 
    public function wpDidModifyTaxonomy( $term_id ) {
        if ( 
            $this->plugin->isSitemapActive( 'site_tree' ) &&
            $this->db->getOption( $this->taxonomyId, false, 'site_tree_content_types' )
        ) {
            $excluded_ids = $this->db->getOption( 'exclude', '', $this->taxonomyId, 'site_tree' );

            if ( !( $excluded_ids && in_array( $term_id, wp_parse_id_list( $excluded_ids ) ) ) ) {
                $this->plugin->flushCachedData( 'site_tree' );
            }
        }

        if (
            $this->plugin->isSitemapActive() &&
            $this->db->getOption( $this->taxonomyId, false, 'sitemap_content_types' )
        ) {
            $excluded_ids = $this->db->getOption( 'exclude', '', $this->taxonomyId, 'sitemap' );

            if ( !( $excluded_ids && in_array( $term_id, wp_parse_id_list( $excluded_ids ) ) ) ) {
                $this->plugin->flushCachedData( 'sitemap' );
            }
        }
    }

    /**
     * @since 2.0
     * @param int $attachment_id
     */
    public function wpDidModifyAttachment( $attachment_id ) {
        if ( $this->plugin->isSitemapActive() ) {
            $attachment = get_post( $attachment_id );
        
            if ( 
                $attachment && 
                $attachment->post_parent &&
                !$this->db->getPostMeta( $attachment->post_parent, 'exclude_from_sitemap' )
            ) {
                $this->plugin->flushCachedData( 'sitemap' );
            }
        }
    }
}
?>