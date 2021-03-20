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
class SiteTreePageController implements SiteTreePageViewDelegateProtocol {
    /**
     * @since 2.0
     * @var object
     */
    protected $plugin;

    /**
     * @since 2.0
     * @var object
     */
    protected $db;

    /**
     * @since 2.0
     * @var object
     */
    protected $dataController;
    
    /**
     * @since 2.0
     * @var object
     */
    protected $page;
    
    /**
     * @since 2.0
     *
     * @param object $page
     * @param object $plugin
     * @param object $dataController
     * @return object
     */
    public static function makeController( $page, $plugin, $dataController = null ) {
        $base_class       = __CLASS__;
        $controller_class = $page->controllerClass();

        $controller                 = new $controller_class;
        $controller->page           = $page;
        $controller->plugin         = $plugin;
        $controller->db             = $plugin->db();
        $controller->dataController = $dataController;

        if ( $controller instanceof $base_class )
            return $controller;

        $message = __METHOD__ . '() cannot create objects of class ' . $controller_class;
        
        trigger_error( $message, E_USER_ERROR );
    }

    /**
     * @since 2.0
     */
    protected function __construct() {}

    /**
     * @since 2.0
     * @return object
     */
    public function loadPageView() {
        $pageView = SiteTreePageView::makeView( $this->page );
        $sections = $this->dataController->loadPageSections( $this->page->id() );
        
        $pageView->setSections( $sections );
        $pageView->setDelegate( $this );

        return $pageView;
    }

    /**
     * @since 2.0
     */
    public function registerHelpPanel() {
        $helpPanel = $this->page->helpPanel();
        $help_tabs = $helpPanel->tabs();

        $screen = get_current_screen();
        $screen->set_help_sidebar( $helpPanel->sidebar() );

        foreach ( $help_tabs as &$help_tab )
            $screen->add_help_tab( $help_tab );
    }

    /**
     * @since 2.0
     *
     * @param string $action
     * @return string|bool
     */
    public function performUserAction( $action ) {
        if ( $action != 'update_settings' ) {
            return false;
        }

        $page_id     = $this->page->id();
        $raw_options = isset( $_POST['sitetree'] ) ? $_POST['sitetree'] : array();
		$options     = $this->dataController->sanitiseOptions( $raw_options, $this->page );
        
        switch ( $page_id ) {
        	case 'sitemap':
        		$notice_text = __( 'Settings saved. %sView Sitemap%s', 'sitetree' );
        		break;

        	case 'site_tree':
        		$notice_text = __( 'Settings saved. %sView Site Tree%s', 'sitetree' );
            
	            uasort ( $options['site_tree'], function( $options_group_a, $options_group_b ) {
	                return $options_group_a['position'] - $options_group_b['position'];
	            });
	            break;

	        default:
	        	return false;
        }
        
        $link_opening_tag = '<a href="' . $this->plugin->sitemapURL( $page_id ) . '" target="sitetree_admin">';
        $notice           = sprintf( $notice_text, $link_opening_tag, '</a>' );

        $this->registerNotice( $notice );
        $this->db->setOptions( $options );
        $this->plugin->flushCachedData( $page_id );

        return $this->pageURL( array( 'settings-updated' => 'true' ) );
    }
    
    /**
     * A reimplementation of the function 'add_settings_error()'
     * unfortunately undefined outside of the page 'options.php'.
     *
     * @since 2.0
     *
     * @param string $notice
     * @param string $code
     */
    protected function registerNotice( $notice, $code = 'updated' ) {
        set_transient( 'settings_errors', array(array(
            'setting' => 'sitetree',
            'code'    => 'sitetree',
            'message' => $notice,
            'type'    => $code
        )), 30 );
    }

    /**
     * @since 2.0
     *
     * @param array $query_arguments
     * @param string $page_id
     * @return string
     */
    protected function pageURL( $query_arguments = array(), $page_id = '' ) {
        if (! $page_id ) {
            $page = $this->page;
        }
        else {
            $page = $this->dataController->page( $page_id );

            if (! $page ) {
                return '';
            }
        }

        $arguments = array( 'page' => 'sitetree-' . $page->id() );
        
        if ( $query_arguments ) {
            $arguments += $query_arguments;
            
            if ( isset( $arguments['action'] ) ) {
                $arguments['sitetree_nonce'] = wp_create_nonce( $arguments['action'] );
            }
        }   
        
        return add_query_arg( $arguments, admin_url( $page->menuId() ) );
    }
    
    /**
     * {@inheritdoc}
     */
    public function pageViewWillDisplayForm( $pageView ) {}
    
    /**
     * {@inheritdoc}
     */
    public function pageViewFormAction( $pageView ) { 
    	return 'update_settings';
    }
    
    /**
     * {@inheritdoc}
     */
    public function pageViewFieldValue( $field, $section_id ) {
    	$context = ( $this->page->id() == 'dashboard' ) ? '' : $this->page->id();
        $value   = $this->db->getOption( $field->id(), $field->defaultValue(), $section_id, $context );
        $filter  = new SiteTreeOptionsFilter( $value, $field );
        
        return $filter->filterOption();
    }
}


/**
 * @since 2.0
 */
final class SiteTreeDashboardController
    extends SiteTreePageController
 implements SiteTreeDashboardDelegateProtocol {
    /**
     * @since 3.0
     */
    private $configMode;

    /**
     * @since 2.0
     */
    private $showLicenceKeyErrorMsg;

    /**
     * @since 2.0
     */
    protected function __construct() {
        if ( isset( $_GET['config'] ) ) {
    		$this->configMode = sanitize_key( $_GET['config'] );
    	}

        add_filter( 'admin_footer_text', array( $this, 'wpWillShowThankYouMessage' ) );
        add_filter( 'update_footer', array( $this, 'wpWillShowFooterUpgradeContent') );
    }

    /**
     * @see parent::performUserAction()
     * @since 2.0
     */
    public function performUserAction( $action ) {
        switch ( $action ) {
            case 'send_pings':
                if (! isset( $_GET['sitemap_id'] ) ) {
                    return false;
                }

                if ( $this->plugin->isServerLocal() ) {
                    return false;
                }

                $sitemap_id = sanitize_key( $_GET['sitemap_id'] );
                
                $this->plugin->pingController()->ping( $sitemap_id );
                break;

            case 'configure':
            	if (! $this->doConfigureAction() ) {
            		return false;
            	}
            	break;
            
            case 'deactivate':
                if (! isset( $_POST['sitetree_form_id'] ) ) {
                    return false;
                }

                $form_id = sanitize_key( $_POST['sitetree_form_id'] );

                switch( $form_id ) {
                    case 'sitemap':
                    case 'newsmap':
                        $this->db->setOption( $form_id, false, 'is_sitemap_active' );
                        flush_rewrite_rules( false );      
                        break;

                    case 'site_tree':
                        $this->db->setOption( 'page_for_site_tree', 0 );
                        break;

                    default:
                        return false;
                }
                break;

            case 'redirect_to_reviews_forum':
                $this->db->setOption( 'ask4rating_clicked', true );
                
                return 'https://wordpress.org/support/plugin/sitetree/reviews/';

            default:
                return false;
        }

        return $this->pageURL();
    }

    /**
     * @since 3.0
     * @return bool
     */
    public function doConfigureAction() {
        if (! isset( $_POST['sitetree_form_id'] ) ) {
            return false;
        }
        
        $raw_options       = isset( $_POST['sitetree'] ) ? $_POST['sitetree'] : array();
        $form_id           = sanitize_key( $_POST['sitetree_form_id'] );
        $config_options    = $this->dataController->sanitiseOptions( $raw_options, $this->page, $form_id );
        $is_sitemap_active = $this->plugin->isSitemapActive( $form_id );

        if ( $form_id == 'site_tree' ) {
             $old_site_tree_id = (int) $this->db->getOption( 'page_for_site_tree' );
        }
        
        $content_types_id = $form_id . '_content_types';
        $content_flags    = $config_options[$content_types_id];
        $at_least_one_content_type_is_included = false;

        foreach ( $content_flags as $content_type_included ) {
            if ( $content_type_included ) {
                $at_least_one_content_type_is_included = true;

                break;
            }
        }

        if (! $at_least_one_content_type_is_included ) {
            if ( $form_id == 'newsmap' ) {
                $config_options[$content_types_id]['post'] = true;
            }
            else {
                $config_options[$content_types_id]['page'] = true;
            }
        }

        if ( !$this->db->setOptions( $config_options ) && $is_sitemap_active ) {
            return true;
        }

        $this->plugin->flushCachedData( $form_id );

        $content_options = array();
        $defaults        = $this->dataController->defaultsForPage( $form_id );

        if ( isset( $defaults[$form_id] ) ) {
            $old_content_options = $this->db->getOption( $form_id );

            if ( is_array( $old_content_options ) ) {
                $content_options[$form_id] = array_merge( $defaults[$form_id], $old_content_options );
            }
            else {
                $content_options[$form_id] = $defaults[$form_id];
            }
        }

        switch ( $form_id ) {
            case 'sitemap':
            case 'newsmap':
                if ( $content_options ) {
                    $this->db->setOptions( $content_options );
                }
                
                if (! $is_sitemap_active  ){
                    $this->db->setOption( $form_id, true, 'is_sitemap_active' );
                    $this->plugin->registerRewriteRules();
                    flush_rewrite_rules( false );
                }
                break;
            
            case 'site_tree':
                $site_tree_id = $config_options['page_for_site_tree'];

                uasort ( $content_options[$form_id], function( $options_group_a, $options_group_b ) {
                    return $options_group_a['position'] - $options_group_b['position'];
                });

                $this->db->setOptions( $content_options );

                if ( $site_tree_id != $old_site_tree_id ) {
                    if ( $old_site_tree_id > 0 ) {
                        $this->db->deletePostMeta( $old_site_tree_id, 'exclude_from_site_tree' );
                    }

                    if ( $site_tree_id > 0 ) {
                        $this->db->setPostMeta( $site_tree_id, 'exclude_from_site_tree', true );
                    }
                }
                break;

            default:
                return false;
        }

        return true;
    }

    /**
     * @since 2.1
     * @param string $message
     */
    public function wpWillShowThankYouMessage( $message ) {
    	$less_than_15_days_elapsed_since_installation = ( time() - $this->db->getOption( 'installed_on' ) < DAY_IN_SECONDS*15 );
    	
    	if ( $less_than_15_days_elapsed_since_installation || $this->db->getOption( 'ask4rating_clicked' ) ) {
    		$link    = '<a href="' . $this->plugin->pluginURI() . '">SiteTree</a>';
	    	$message = sprintf( __( 'Thank you for using %s.', 'sitetree' ), $link );
    	}
    	else {
 			$opening_tag  = '<a href="' . $this->pageURL( array( 'action' => 'redirect_to_reviews_forum' ) ) . '">';
 			$message = sprintf( __( 'Please, %1$sgive SiteTree a rating%2$s.', 'sitetree' ), $opening_tag, '</a>' );
    	}
    	
    	return ( '<span id="footer-thankyou">' . $message . '</span>' );
    }

    /**
     * @since 2.1
     * @param string $content
     */
    public function wpWillShowFooterUpgradeContent( $content ) {
        $version_number = $this->plugin->version();
        $relative_url   = 'release-notes/#' . str_replace( '.', '', $version_number );
        $opening_tag    = '<a href="' . $this->plugin->pluginURI( $relative_url ) . '">';

        return sprintf( __( 'Version %1$s (%2$srelease notes%3$s)', 'sitetree' ), $version_number, $opening_tag, '</a>' );
    }

    /**
     * {@inheritdoc}
     */
    public function pageViewWillDisplayForm( $pageView ) {
        $_GET['settings-updated'] = isset( $_GET['notice'] );

        settings_errors( 'sitetree' );
    }

    /**
     * {@inheritdoc}
     */
    public function pageViewFormAction( $pageView ) {
    	$form_id = $pageView->formID();

    	if ( $this->plugin->isSitemapActive( $form_id ) && ( $this->configMode != $form_id ) ) {
            return 'deactivate';
        }

        return 'configure';
    }

    /**
     * {@inheritdoc}
     */
    public function dashboardWillRenderToolbarButtons( $dashboard, $form_id ) {
        $aux_markup = '';
        $config     = array();
        
        if ( $this->plugin->isSitemapActive( $form_id ) ) {
            if ( $form_id != 'site_tree' ) {
                $aux_markup = $this->makePingNode( $form_id );
            }

            if ( $this->configMode == $form_id ) {
                $config['submit_title'] = __( 'Save Changes', 'sitetree' );
                
                $aux_markup .= '<a href="'. $this->pageURL()
                             . '" class="sitetree-aux-tb-btn">' . __( 'Cancel', 'sitetree' ) . '</a>';
            }
            else {
                $rebuild_action_id = 'rebuild_' . $form_id;
                $aux_markup       .= '<input type="submit" '
                                   . 'class="sitetree-aux-tb-btn sitetree-disable-tb-btn sitetree-hidden-tb-btn" '
                                   . 'name="submit" value="' . __( 'Deactivate', 'sitetree' ) . '">';
 
                $config['view_url']        = $this->plugin->sitemapURL( $form_id );
                $config['config_mode_url'] = $this->pageURL( array( 'config' => $form_id ) );
                $config['settings_url']    = $this->pageURL( array(), $form_id );
            }
        }
        else {
            $config['submit_title'] = __( 'Activate', 'sitetree' );
        }

        $dashboard->configureToolbar( $config );
        
        return $aux_markup;
    }

    /**
     * @since 1.0
     *
     * @param string $form_id
     * @return string
     */
    private function makePingNode( $form_id ) {
        $can_ping             = false;
        $server_is_local      = $this->plugin->isServerLocal();
        $automatic_pinging_on = ( $this->db->getOption( 'automatic_pinging_on' ) || ( $form_id == 'newsmap' ) );

        if (! $server_is_local ) {
            $pingController = $this->plugin->pingController();
            $info           = $pingController->getPingInfo( $form_id );
            $can_ping       = $pingController->canPingOnRequest( $form_id );
        }

        if ( $server_is_local ) {
            $status_class = 'sitetree-ping-notice';
        }
        elseif ( $info['ping_failed'] ) {
            $status_class = 'sitetree-ping-failed';
        }
        elseif ( $automatic_pinging_on ) {
            $status_class = 'sitetree-automatic-pinging-on';
        }
        else {
            $status_class = 'sitetree-automatic-pinging-off';
        }

        $node = '<div class="sitetree-ping ' . $status_class;

        if ( !( $can_ping || $server_is_local ) ) {
            $node .= ' sitetree-pinging-idle';
        }
        
        $node .= '"><div class="sitetree-ping-bubble ' . $status_class . '">';
        $node .= '<p class="sitetree-automatic-pinging-status">';

        if ( $server_is_local ) {
            $node .= __( 'Pinging Disabled', 'sitetree' );
        }
        elseif ( $automatic_pinging_on ) {
            $node .= __( 'Automatic Pinging ON', 'sitetree' );
        }
        else {
            $node .= __( 'Automatic Pinging OFF', 'sitetree' );
        }

        $node .= '</p><p class="sitetree-ping-status-msg">';

        if ( $server_is_local ) {
            $node .= __( 'I cannot send pings from a local server, I am sorry.', 'sitetree' );
            $node .= '</p>';
        }
        else {
            $node .= $info['status_msg'] . '</p>';
        } 

        if ( $can_ping ) {
            $args  = array(
                'action'     => 'send_pings',
                'sitemap_id' => $form_id
            );
            $node .= '<a href="'. $this->pageURL( $args ) 
                   . '" class="sitetree-ping-btn">' . $info['ping_btn_title'] . '</a>';
        }
        elseif (! $server_is_local ) {
            if ( $form_id == 'sitemap' ) {
                $msg_format = __( 'You will be able to send new pings in %s.', 'sitetree' );
            }
            else {
                $msg_format = __( 'You will be able to send a new ping in %s.', 'sitetree' );
            }
            
            $message = sprintf( $msg_format, $pingController->getTimeToNextPingInWords( $form_id ) );

            $node .= '<p class="sitetree-time-to-next-ping">' . $message . '</p>';
        }

        $node .= '</div></div>';
        
        return $node;
    }
    
    /**
     * {@inheritdoc}
     */
    public function dashboardCanRenderStats( $dashboard, $form_id ) {
        if (
            !$this->plugin->isSitemapActive( $form_id ) ||
            ( $this->configMode == $form_id )
        ) {
            return false;
        }

        $items_count_stat = (int) $this->db->getNonAutoloadOption( 'stats', 0, 'num_items', $form_id );

        switch ( $form_id ) {
            case 'sitemap':
                $permalinks_count_tooltip = '';

                if ( $items_count_stat == 10000 ) {
                    $items_count_stat  = '<div class="sitetree-stat-limit">' . $items_count_stat 
                                       . '<div class="sitetree-stat-limit-msg">';
                    $items_count_stat .= __( 'Remarkable! Your Sitemap has as many links as each neuron in your brain has! '
                                          . 'Unfortunately I am not as much complex at the time being, '
                                          . 'thus I cannot add more URLs, I am sorry.', 'sitetree' );
                    $items_count_stat .= '</div></div>';
                }
                else {
                    $excluded_permalinks_count = (int) $this->db->getNonAutoloadOption( 'stats', 0, 
                                                                                        'excluded_permalinks_count', $form_id );

                    if ( $excluded_permalinks_count > 0 ) {
                        $tooltip_text = _n( '1 permalink has been excluded from the Sitemap.', 
                                            '%d permalinks have been excluded from the Sitemap.', 
                                            $excluded_permalinks_count, 'sitetree' );

                        $permalinks_count_tooltip = sprintf( $tooltip_text , $excluded_permalinks_count );
                    }
                }
                
                
                $dashboard->registerStat( __( 'Permalinks', 'sitetree' ), $items_count_stat, $permalinks_count_tooltip );
                $dashboard->registerStat( __( 'Images', 'sitetree' ), 
                                              (int) $this->db->getNonAutoloadOption( 'stats', 0, 'num_images', $form_id ) );
                break;

            case 'newsmap':
                $news_count_tooltip  = '';
                $excluded_news_count = (int) $this->db->getNonAutoloadOption( 'stats', 0, 'excluded_news_count', $form_id );

                if ( $excluded_news_count > 0 ) {
                    $tooltip_text = _n( '1 news has been excluded from the Sitemap.', 
                                        '%d news have been excluded from the Sitemap.', 
                                        $excluded_news_count, 'sitetree' );
                    
                    $news_count_tooltip = sprintf( $tooltip_text , $excluded_news_count );
                }

                $dashboard->registerStat( __( 'News', 'sitetree' ), $items_count_stat, $news_count_tooltip );
                break;

            default:
                $dashboard->registerStat( __( 'Items', 'sitetree' ), $items_count_stat );
                break;
        }

        $queries_stat = (int) $this->db->getNonAutoloadOption( 'stats', 0, 'num_queries', $form_id );
        $runtime_stat = (float) $this->db->getNonAutoloadOption( 'stats', 0, 'runtime', $form_id ) . 's';
        
        $dashboard->registerStat( __( 'Queries', 'sitetree' ), $queries_stat );
        $dashboard->registerStat( __( 'Runtime', 'sitetree' ), $runtime_stat );

        $stats_computed_on = sitetree_fn\time_since( $this->db->getNonAutoloadOption( 'stats', 0, 'stats_computed_on', $form_id ) );
        
        $dashboard->setStatsFreshnessMessage( sprintf( __( 'Last update: %s', 'sitetree' ), $stats_computed_on ) );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function dashboardDidDisplayForms() {
    	$sidebar = '<aside id="sitetree-sidebar"><h3>' 
    			 . __( 'The Project', 'sitetree' )
				 . '</h3><ul><li><a href="' . $this->plugin->pluginURI() . '">'
	    		 . __( 'Website', 'sitetree' )
	    		 . '</a></li><li><a href="https://translate.wordpress.org/projects/wp-plugins/sitetree/">'
				 . __( 'SiteTree on Glotpress', 'sitetree' )
				 . '</a></li><li><a href="https://github.com/LuigiCavalieri/sitetree">'
				 . __( 'Git Repository', 'sitetree' )
				 . '</a></li><li><a href="' . $this->plugin->pluginURI( 'go-pro/' ) 
				 . '">SiteTree Pro</a></li></ul><h3>' 
				 . __( 'Need Help?', 'sitetree' )
				 . '</h3><p><a href="' . $this->plugin->pluginURI( 'help/' ) . '">'
				 . __( 'Start from here!', 'sitetree' ) . '</a></p></aside>';

    	return $sidebar;
    }
}
?>