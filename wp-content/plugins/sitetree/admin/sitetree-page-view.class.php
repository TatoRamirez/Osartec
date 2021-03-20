<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 1.4
 */
class SiteTreePageView extends SiteTreeView {
	/**
	 * @since 1.4
     * @var object
	 */
	protected $delegate;
	
	/**
	 * @since 1.4
     * @var array
	 */
	protected $sections;
	
	/**
	 * @since 1.4
     * @var object
	 */
	protected $section;
	
	/**
	 * @since 1.4
     * @var object
	 */
	protected $field;

    /**
     * @since 2.0
     * @var object
     */
    protected $fieldView;

    /**
     * @since 2.0
     * @param array $sections
     */
    public function setSections( $sections ) { $this->sections = $sections; }

    /**
     * @since 1.4
     * @param SiteTreePageViewDelegateProtocol $delegate
     */
    public function setDelegate( SiteTreePageViewDelegateProtocol $delegate ) {
        $this->delegate = $delegate;
    }
	
	/**
	 * @since 2.0
	 */
	public function display() {
		ob_start();
		
        echo '<div class="wrap">',
			 '<h1>', $this->viewData->title(), '</h1>';

		echo $this->delegate->pageViewWillDisplayForm( $this );

		$this->displayForm();

        echo '</div>';
		
		ob_end_flush();
	}
	
	/**
	 * @since 2.0
	 */
	protected function displayForm() {
        $action = $this->delegate->pageViewFormAction( $this );
        
		echo '<form method="post">';

        wp_nonce_field( $action, 'sitetree_nonce', true );
        
        echo '<input type="hidden" name="action" value="', $action, '">',
             '<input type="hidden" name="sitetree_page" value="', $this->viewData->id(), '">';

		$this->displayFormContent();
		
		echo '</form>';
	}
	
	/**
	 * @since 2.0
	 */
	protected function displayFormContent() {
        foreach ( $this->sections as $this->section )
            $this->displaySection();

        submit_button();
    }

    /**
     * @since 2.0
     */
    protected function displaySection() {
        $fields        = $this->section->fields();
        $section_title = $this->section->title();
        $section_id    = $this->section->id();

        if ( $section_title ) {
            echo '<h2 class="title">', $section_title, '</h2>';
        }
            
        echo '<table class="form-table"><tbody>';
        
        foreach ( $fields as $this->field ) {
            echo '<tr valign="top"><th scope="row">';
            echo $this->field->title(), '</th><td>';
            
            if ( $this->field instanceof SiteTreeFieldset ) {
            	$fieldset       = $this->field;
            	$grouped_fields = $fieldset->fields();
            	$line_ending    = ( $fieldset->isInline() ? "\n" : '<br>' );
				$fieldset_id    = ( $fieldset->id() ? $fieldset->id() : $section_id );
            	
            	echo '<fieldset>';

            	foreach ( $grouped_fields as $this->field ) {
            		$this->loadFieldView( $fieldset_id );
			        $this->fieldView->display();

			        echo $line_ending;
            	}

            	echo '</fieldset>';
            }
            else {
            	$this->loadFieldView( $section_id );
		        $this->fieldView->display();
            }

            echo '</td></tr>';
        }
        
        echo '</tbody></table>';
	}

	/**
	 * @since 2.0
	 */
	protected function loadFieldView( $section_id ) {
		$value = $this->delegate->pageViewFieldValue( $this->field, $section_id );
		
        $this->fieldView = SiteTreeFieldView::makeView( $this->field );
		$this->fieldView->init( $value, $section_id );
	}
}


/**
 * @since 1.4
 */
final class SiteTreeDashboard extends SiteTreePageView {
	/**
	 * @since 1.4
	 * @var array
	 */
	private $stats = array();
	
    /**
     * @since 4.0
     * @var int
     */
    private $numOfStats = 0;

	/**
     * @since 4.0
     * @var array
     */
    private $toolbarConfig = array(
        'view_url'        => '',
        'config_mode_url' => '',
        'settings_url'    => '',
        'submit_title'    => ''
    );

    /**
     * @since 4.0
     * @var bool
     */
    private $canDisplayStatsValues = true;

    /**
     * @since 4.0
     * @var string
     */
    private $statsFreshnessMsg;

    /**
     * @since 3.0
     * @param string $msg
     */
    public function setStatsFreshnessMessage( $msg ) {
        $this->statsFreshnessMsg = $msg;
    }
	
	/**
	 * @since 1.5
	 *
     * @param string $title
     * @param int|string $value
     * @param string $tooltip
     */
    public function registerStat( $title, $value, $tooltip = '' ) {
        $this->stats[]     = array(
            'title'       => $title,
            'value'       => $value,
            'tooltip'     => $tooltip
        );

        if ( $this->canDisplayStatsValues && ( $this->numOfStats > 0 ) && is_int( $value ) ) {
            $prev_index = $this->numOfStats - 1;

            $this->canDisplayStatsValues = !( ( $this->stats[$prev_index]['value'] == $value ) && ( $value === 0 ) );
        }

        $this->numOfStats += 1;
    }

    /**
     * @since 4.0
     */
    private function resetStats() {
        $this->stats                 = array();
        $this->numOfStats            = 0;
        $this->canDisplayStatsValues = true;
    }
	
	/**
     * @since 1.4
     * @param array $config
     */
    public function configureToolbar( $config ) {
        $this->toolbarConfig = array_merge( $this->toolbarConfig, $config );
    }

	/**
	 * @since 3.0
	 */
	public function formID() {
		return $this->section->id();
	}
	
	/**
     * @see parent::displayForm()
	 * @since 2.0
	 */
	protected function displayForm() {
		echo '<div id="sitetree-dashboard-wrapper" class="sitetree-self-clear">', 
		     '<div id="sitetree-dashboard">';
		
		foreach ( $this->sections as $this->section ) {
			parent::displayForm();
		}
		
		echo '</div>';

		echo $this->delegate->dashboardDidDisplayForms();

		echo '</div>';
	}
	
	/**
     * @see parent::displayFormContent()
	 * @since 2.0
	 */
	protected function displayFormContent() {
		$form_id = $this->formID();
        
        echo '<input type="hidden" name="sitetree_form_id" value="', $form_id, '">',
             '<div class="sitetree-toolbar"><span>', $this->section->title(), '</span>';

        echo $this->delegate->dashboardWillRenderToolbarButtons( $this, $form_id );

        if ( $this->delegate->dashboardCanRenderStats( $this, $form_id ) ) {
            $last_stat_index = $this->numOfStats - 1;
            
            if ( $this->toolbarConfig['settings_url'] ) {
                echo '<a href="', $this->toolbarConfig['settings_url'], '" class="sitetree-tb-btn sitetree-corner-tb-btn">', 
                     __( 'Settings', 'sitetree-pro' ), '</a>';
            }
            
            echo '<a href="', $this->toolbarConfig['config_mode_url'], '" class="sitetree-tb-btn';

            if (! $this->toolbarConfig['settings_url'] ) {
                echo ' sitetree-corner-tb-btn';  
            }
            
            echo '">', __( 'Configure', 'sitetree-pro' ), '</a>',
                 '<a href="', $this->toolbarConfig['view_url'], '" class="sitetree-tb-btn" target="sitetree_', $form_id, '">',
                 __( 'View', 'sitetree-pro' ), '</a>',
                 '</div><div class="sitetree-stats"><ul class="sitetree-stats-list sitetree-self-clear';
            
            if ( $this->numOfStats != 4 ) {
                echo ' sitetree-', $this->numOfStats, '-stats';
            }
                
            echo '">';
            
            for ( $i = 0; $i < $this->numOfStats; $i++ ) {
                $stat_container_classes = 'sitetree-stat';

                if ( $this->canDisplayStatsValues ) {
                    $stat_value = $this->stats[$i]['value'];

                    if ( $this->stats[$i]['tooltip'] ) {
                        $stat_container_classes .= ' sitetree-stat-with-tooltip-container';
                        $stat_value = '<span class="sitetree-stat-with-tooltip" title="' . $this->stats[$i]['tooltip']
                                    . '">' . $stat_value . '</span>';
                    }
                }
                else {
                    $stat_value = '-';
                }

                echo '<li><div class="sitetree-stat-container';
                
                if ( $i == $last_stat_index ) {
                    echo ' sitetree-last-stat';
                }
                
                echo '">', $this->stats[$i]['title'], '<div class="', $stat_container_classes, 
                     '">', $stat_value, '</div></div></li>';
            }
            
            echo '</ul>';

            if ( $this->canDisplayStatsValues ) {
                echo '<p class="sitetree-stats-freshness">', $this->statsFreshnessMsg, '</p>';
            }

            echo '</div>';
            
            $this->resetStats();
        }
        else {
            echo '<input type="submit" id="sitetree-primary-', $form_id, 
                 '-form-btn" class="sitetree-tb-btn sitetree-corner-tb-btn sitetree-primary-tb-btn" name="submit" value="',
                 $this->toolbarConfig['submit_title'], '"></div>';

            $this->section->setID( '' );
            $this->section->setTitle( '' );
            
            $this->displaySection();
        }
	}
}
?>