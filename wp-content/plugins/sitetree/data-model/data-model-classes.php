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
class SiteTreePage {
	/**
	 * @since 1.4
	 * @var string
	 */
	protected $id;
	
	/**
	 * @since 2.0
	 * @var string
	 */
	protected $menuId;
	
	/**
	 * @since 1.4
	 * @var string
	 */
	protected $title;
	
	/**
	 * @since 2.0
	 * @var string
	 */
	protected $menuTitle;
	
	/**
	 * @since 2.0
	 * @var string
	 */
	protected $viewClass;
    
    /**
     * @since 2.0
     * @var string
     */
    protected $controllerClass;

    /**
     * @since 2.0
     * @var object
     */
    protected $helpPanel;
	
	/**
	 * @since 1.4
     *
     * @param string $id
     * @param string $menu_id
     * @param string $title
     * @param string $menu_title
     * @param string $view_class      
     * @param string $controller_class
	 */
	public function __construct( $id, $menu_id, $title, 
                                 $menu_title, $view_class, $controller_class )
    {
        $this->id              = $id;
		$this->menuId	       = $menu_id;
		$this->title	       = $title;
		$this->menuTitle       = $menu_title;
        $this->viewClass       = $view_class;
        $this->controllerClass = $controller_class;
	}
	
    /**
     * @since 2.0
     * @return string
     */
    public function id() {
    	return $this->id; 
    }

    /**
     * @since 2.0
     * @return string
     */
    public function menuId() {
    	return $this->menuId; 
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
    public function menuTitle() {
    	return $this->menuTitle; 
    }

    /**
     * @since 2.0
     * @return string
     */
    public function viewClass() {
    	return $this->viewClass; 
    }

    /**
     * @since 2.0
     * @return string
     */
    public function controllerClass() {
    	return $this->controllerClass; 
    }

    /**
     * @since 2.0
     * @return object
     */
    public function helpPanel() {
    	return $this->helpPanel; 
    }

    /**
     * @since 2.0
     * @param SiteTreeHelpPanel $helpPanel
     */
    public function setHelpPanel( SiteTreeHelpPanel $helpPanel ) {
        $this->helpPanel = $helpPanel;
    }

    /**
     * @since 2.0
     * @return bool
     */
    public function hasHelpPanel() {
    	return $this->helpPanel != null; 
    }
}


/**
 * @since 2.0
 */
class SiteTreeHelpPanel {
    /**
     * @since 2.0
     * @var array
     */
    protected $tabs = array();
    
    /**
     * @since 2.0
     * @var string
     */
    protected $sidebar;

    /**
     * @since 2.0
     * @return array
     */
    public function tabs() {
    	return $this->tabs; 
    }

    /**
     * @since 2.0
     *
     * @param string $id
     * @param string $title
     * @param string $content
     */
    public function addTab( $id, $title, $content ) {
        $this->tabs[] = array(
            'id'      => $id,
            'title'   => $title,
            'content' => $content
        );
    }

    /**
     * @since 2.0
     * @return array
     */
    public function sidebar() {
    	return $this->sidebar; 
    }

    /**
     * @since 2.0
     * @param string $sidebar
     */
    public function setSidebar( $sidebar ) { $this->sidebar = $sidebar; }
}


/**
 * @since 1.3
 */
class SiteTreeSection {
	/**
	 * @since 1.3
	 * @var string
	 */
	protected $id;
	
	/**
	 * @since 1.3
	 * @var string
	 */
	protected $title;
	
	/**
	 * @since 1.3
	 * @var array
	 */
	protected $fields;
	
	/**
	 * @since 1.3
     *
     * @param string $title 
     * @param string $id    
     * @param array  $fields
	 */
	public function __construct( $title = '', $id = '', $fields = array() ) {
		$this->id	  = $id;
		$this->title  = $title;
		$this->fields = $fields;
	}

    /**
     * @since 2.0
     * @return string
     */
    public function id() {
    	return $this->id; 
    }

    /**
     * @since 3.0
     * @param string $id
     */
    public function setID( $id ) {
        $this->id = $id;
    }

    /**
     * @since 2.0
     * @return string
     */
    public function title() {
    	return $this->title; 
    }

    /**
     * @since 3.0
     * @param string $title
     */
    public function setTitle( $title ) {
        $this->title = $title;
    }

    /**
     * @since 2.0
     * @return array
     */
    public function fields() {
    	return $this->fields; 
    }

    /**
     * @since 2.0
     * @param object $field
     */
    public function addField( $field ) {
        $this->fields[] = $field;
    }

    /**
     * @since 3.1
     * @return bool
     */
    public function hasFields() {
        return !empty( $this->fields );
    }
}

/**
 * @since 3.0
 */
class SiteTreeFieldset extends SiteTreeSection {
	/**
	 * @since 3.0
	 * @var string
	 */
	protected $isInline;

    /**
     * @since 3.0
     *
     * @param string $title
     * @param string $id
     * @param bool $is_inline
     * @param array  $fields
     */
    public function __construct( $title = '', $id = '', $is_inline = false, $fields = array() ) {
        parent::__construct( $title, $id, $fields );

        $this->isInline = $is_inline;
    }

    /**
     * @since 3.0
     * @return bool
     */
    public function isInline() { 
        return $this->isInline;
    }
}

/**
 * @since 1.3
 */
class SiteTreeField {
	/**
	 * @since 1.4
	 * @var string
	 */
	protected $id;
	
	/**
	 * @since 2.0
	 * @var string
	 */
	protected $viewClass;
	
	/**
	 * @since 2.0
	 * @var string
	 */
	protected $dataType;
	
	/**
	 * @since 1.3
	 * @var string
	 */
	protected $title;

	/**
	 * @since 1.3
	 * @var string
	 */
	public $tooltip;
	
	/**
	 * @since 2.0
	 * @var mixed
	 */
	protected $defaultValue;
	
	/**
	 * @since 1.4
	 * @var mixed
	 */
	public $config;
	
	/**
	 * @since 1.4
	 * @var mixed
	 */
	public $conditions;
	
	/**
	 * @since 1.3
	 *
	 * @param string $id
	 * @param string $view_class
	 * @param string $data_type
	 * @param string $title
	 * @param string $tooltip
	 * @param mixed  $default_value
	 */
	public function __construct( $id, $view_class, $data_type, $title, $tooltip = '', 
                                 $default_value = false, $config = null, $conditions = null )
    {
		$this->id	        = $id;
		$this->viewClass    = $view_class;
		$this->dataType	    = $data_type;
		$this->defaultValue = $default_value;

        $this->title   = $title;
		$this->tooltip = $tooltip;
		
		$this->config  = $config;
		
		if ( $conditions === null )
			$this->conditions = &$this->config;
		else
		 	$this->conditions = $conditions;
	}

    /**
     * @since 2.0
     * @return string
     */
    public function id() { 
        return $this->id;
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
    public function viewClass() { 
        return $this->viewClass;
    }

    /**
     * @since 2.0
     * @return string
     */
    public function dataType() { 
        return $this->dataType;
    }

    /**
     * @since 2.0
     * @return mixed
     */
    public function defaultValue() { 
        return $this->defaultValue;
    }
}

/**
 * @since 1.4
 */
class SiteTreeDataController {
    /**
     * @since 2.0
     * @var object
     */
    private $plugin;

    /**
     * @since 3.0
     * @var object
     */
    private $db;

	/**
	 * @since 1.4
	 * @var array
	 */
	private $pages = array();
	
	/**
	 * @since 1.4
     * @param object $plugin
	 */
	public function __construct( $plugin ) {
        $this->plugin = $plugin;
        $this->db     = $plugin->db();
	}
	
	/**
	 * @since 1.4
     *
     * @param bool $include_non_active
     * @return array
     */
    public function pages( $include_non_active = true ) {
        if (! $this->pages ) {
            $this->pages[] = new SiteTreePage( 'dashboard', 'index.php', sprintf( __( '%s Dashboard', 'sitetree-pro' ), 'SiteTree' ),
                                               'SiteTree', 'SiteTreeDashboard', 'SiteTreeDashboardController' );

            if ( $include_non_active || $this->plugin->isSitemapActive() ) {
                $this->pages[] = new SiteTreePage( 'sitemap', 'options-general.php', 
                                                   __( 'Google Sitemap Settings', 'sitetree-pro' ), 'Google Sitemap', 
                                                   'SiteTreePageView', 'SiteTreePageController' );
            }
            
            if ( $include_non_active || $this->plugin->isSitemapActive( 'site_tree' ) ) {
                $this->pages[] = new SiteTreePage( 'site_tree', 'options-general.php', 
                                                   __( 'Site Tree Settings', 'sitetree-pro' ), 'Site Tree', 
                                                   'SiteTreePageView', 'SiteTreePageController' );
            }
        }

        return $this->pages;
    }
	
	/**
	 * @since 1.4
     *
     * @param string $id
     * @return object|bool
	 */
	public function page( $id ) {
        $pages = $this->pages();
        
        foreach ( $pages as $page ) {
            if ( $page->id() == $id )
                return $page;
        }

        return false;
	}
	
	/**
	 * @since 1.4
     * @param string $page_id
     */
	public function loadPageSections( $page_id ) {
        $sections = array();
        $page     = $this->page( $page_id );

        if ( $page ) {
            $data_file_name = $page_id . '-page-data.php';
        
            if ( WP_DEBUG ) {
                include( $data_file_name );
            }
            else {
                @include( $data_file_name );
            } 
        }

        return $sections;
    }

    /**
     * @since 2.0
     *
     * @param array $options
     * @param object $page
     * @param string $form_id
     * @return array
     */
    public function &sanitiseOptions( &$options, $page, $form_id = '' ) {
        $output   = array();
        $context  = $page->id();
        $sections = $this->loadPageSections( $page->id() );

        foreach ( $sections as $section ) {
        	$section_id = $section->id();

            if ( !$section_id || ( $section_id == $form_id ) ) {
            	$output += $this->sanitisationCallback( $section, $options );
            }
            elseif ( !$form_id ) {
				$section_data  = isset( $options[$section_id] ) ? $options[$section_id] : array();
                $output[$context][$section_id] = $this->sanitisationCallback( $section, $section_data );
            }
        }

        return $output;
    }

    /**
     * @since 2.0
     *
     * @param object $section
     * @param array $options
     */
    private function &sanitisationCallback( $section, &$options ) {
        $output = array();
        $fields = $section->fields();

        foreach ( $fields as $field ) {
        	$field_id = $field->id();

            if ( $field instanceof SiteTreeFieldset ) {
            	$fieldset    = $field;
            	$fieldset_id = $field_id;

            	if ( $fieldset_id ) {
	                $fieldset_data        = isset( $options[$fieldset_id] ) ? $options[$fieldset_id] : array();
	                $output[$fieldset_id] = $this->sanitisationCallback( $fieldset, $fieldset_data );
	            }
	            else {
	                $output += $this->sanitisationCallback( $fieldset, $options );
	            }
            	
            	continue;
            }
            
            if ( isset( $options[$field_id] ) ) {
                $filter            = new SiteTreeOptionsFilter( $options[$field_id], $field );
                $output[$field_id] = $filter->filterOption();
            }
            else {
            	$output[$field_id] = false;
            }
        }

        return $output;
    }

    /**
     * @since 2.0
     *
     * @param string $page_id
     * @return array
     */
    public function &defaultsForPage( $page_id ) {
        $defaults = array();
        $sections = $this->loadPageSections( $page_id );

        foreach ( $sections as $section ) {
            $fields     = $section->fields();
            $section_id = $section->id();
            
            if ( $section_id ) {
            	$defaults[$page_id][$section_id] = $this->defaultsCallback( $fields );
            }
            else {
                $defaults += $this->defaultsCallback( $fields );
            }
        }

        return $defaults;
    }

    /**
     * @since 2.0
     *
     * @param array $fields
     * @return array
     */
    private function defaultsCallback( $fields ) {
        $defaults = array();

        foreach ( $fields as $field ) {
            if ( $field instanceof SiteTreeFieldset ) {
                $defaults += $this->defaultsCallback( $field->fields() );
            }
            else {
                $defaults[$field->id()] = $field->defaultValue(); 
            }
        }

        return $defaults;
    }
}

/**
 * @since 2.0
 */
class SiteTreeOptionsFilter {
    /**
     * @since 2.0
     * @var mixed
     */
    protected $value;

    /**
     * @since 2.0
     * @var object
     */
    protected $field;
    
    /**
     * @since 2.0
     *
     * @param mixed $value
     * @param object $field
     */
    public function __construct( $value, $field ) {
        $this->value = $value;
        $this->field = $field;
    }
    
    /**
     * @since 2.0.1
     * @return mixed
     */
    public function filterOption() {
        $method_name = 'filter' . ucwords( $this->field->dataType(), '_' );
        $method_name = str_replace( '_', '', $method_name );

        if ( method_exists( $this, $method_name ) && $this->{$method_name}() ) {
            return $this->value;
        }

        return $this->field->defaultValue();
    }
    
    /**
     * Validates a limited positive number.
     *
     * @since 2.0.1
     * @return bool
     */
    private function filterPositiveNumber() {
        if ( $this->value <= 0 ) {
            return false;
        }
        
        if ( isset( $this->field->conditions['min_value'] ) ) {
            return ( $this->value >= $this->field->conditions['min_value'] );
        }
        
        if ( isset( $this->field->conditions['max_value'] ) ) {
            return ( $this->value <= $this->field->conditions['max_value'] );
        }
    }
    
    /**
     * Validates an option of a Select field by checking whether or not the 
     * received value exists in the list of choices.
     *
     * @since 2.0.1
     * @return bool
     */
    private function filterChoice() {
        return isset( $this->field->conditions[$this->value] );
    }
    
    /**
     * Validates a boolean value.
     *
     * @since 2.0.1
     * @return bool
     */
    private function filterBool() {
        if ( 
            is_bool( $this->value ) || 
            ( $this->value === '1' ) || 
            ( $this->value === '0' ) || 
            ( $this->value === '' )
        ) {
            $this->value = (bool) $this->value;

            return true;
        }

        return false;
    }
    
    /**
     * Filters a comma-separated list of numeric ids.
     *
     * @since 2.0.1
     * @return bool
     */
    private function filterListOfIds() {
        if (! $this->value ) {
            return true;
        }

        $_nums   = array();
        $numbers = explode( ',', $this->value );
        
        if (! $numbers ) {
            return false;
        }
            
        foreach ( $numbers as $number ) {
            if ( 
                is_numeric( $number ) && 
                ( $number > 0 ) && 
                !isset( $_nums[$number] ) 
            ) {
                $number         = (int) $number;
                $_nums[$number] = $number;
            }
        }

        if (! $_nums ) {
            return false;
        }

        sort( $_nums, SORT_NUMERIC );
        
        $this->value = implode( ', ', $_nums );

        return true;
    }

    /**
     * Filters a comma-separated list of nicknames.
     *
     * @since 3.0.2
     * @return bool
     */
    private function filterListOfNicknames() {
        if (! $this->value ) {
            return true;
        }

        $valid_nicknames = array();
        $nicknames       = explode( ',', $this->value );
        
        if (! $nicknames ) {
            return false;
        }
            
        foreach ( $nicknames as $nickname ) {
            $nickname = trim( $nickname );

            if ( 
                ( preg_match( '/[^0-9a-zA-Z_-]/', $nickname ) === 0 ) && 
                !isset( $valid_nicknames[$nickname] ) 
            ) {
                $valid_nicknames[$nickname] = $nickname;
            }
        }

        if (! $valid_nicknames ) {
            return false;
        }

        $this->value = implode( ', ', $valid_nicknames );

        return true;
    }

    /**
     * @since 2.0.1
     * @return bool
     */
    private function filterInlineHtml() {
        $allowed_html = array(
            'a'       => array(
                'href'  => array(),
                'title' => array()
            ),
            'span'    => array(
                'id'    => array(),
                'class' => array()
            ),
            'em'      => array(),
            'strong'  => array(),
            'small'   => array(),
            'abbr'    => array(),
            'acronym' => array(),
            'code'    => array(),
            'sub'     => array(),
            'sup'     => array()
        );

        $this->value = wp_kses( $this->value, $allowed_html );

        return true;
    }

    /**
     * @since 2.0.1
     * @return bool
     */
    private function filterPlainText() {
        $this->value = sanitize_text_field( $this->value );

        return true;
    }
}
?>