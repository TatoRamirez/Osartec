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
abstract class SiteTreeView {
    /**
     * @since 2.0
     * @var object
     */
    protected $viewData;

    /**
     * @since 2.0
     *
     * @param object $viewData
     * @return object
     */
    public static function makeView( $viewData ) {
        $base_class     = __CLASS__;
        $view_class     = $viewData->viewClass();
        $view           = new $view_class;
        $view->viewData = $viewData;

        if ( $view instanceof $base_class ) {
            return $view;
        }

        $message = __METHOD__ . '() cannot create objects of class ' . $view_class;
        
        trigger_error( $message, E_USER_ERROR );
    }

    /**
     * @since 2.0
     */
    private function __construct() {}

    /**
     * @since 2.0
     */
    abstract public function display();
}


/**
 * @since 1.4
 */
abstract class SiteTreeFieldView extends SiteTreeView {
	/**
	 * @since 1.4
     * @var string
	 */
	protected $id;
	
	/**
	 * @since 1.4
     * @var string
	 */
	protected $name = 'sitetree';
	
	/**
	 * @since 1.4
     * @var string
	 */
	protected $value;
	
	/**
	 * @since 2.0
     *
     * @param mixed $value
     * @param string $section_id
	 */
	public function init( $value, $section_id = '' ) {
        $raw_id = $this->viewData->id();

        $this->id    = $raw_id;
        $this->value = $value;
        
        if ( $section_id ) {
            $this->name .= '[' . $section_id . ']';
            $this->id    = $section_id . '-' . $this->id;
        }
            
        $this->name .= '[' . $raw_id . ']';
        $this->id    = str_replace( '_', '-', $this->id );
	}
	
	/**
	 * @since 2.2
	 */
	public function display() {
		$this->displayField();
		$this->displayTooltip();
	}

	/**
	 * @since 2.2
	 */
	abstract protected function displayField();

	/**
	 * @since 2.0
	 */
	protected function displayTooltip() {
        if (! $this->viewData->tooltip ) {
            return false;
        }

        echo "\n";

        if ( 
            ( $this->viewData->viewClass() != 'SiteTreeCheckbox' ) && 
            preg_match( '/^\p{Lu}/u',  $this->viewData->tooltip )
        ) {
            echo '<span class="description">', $this->viewData->tooltip, '</span>';
        }
        else {
            echo '<label for="', $this->id, '">', $this->viewData->tooltip, '</label>';
        }
    }
}


/**
 * @since 1.4
 */
class SiteTreeCheckbox extends SiteTreeFieldView {
	/**
	 * @see parent::displayField()
     * @since 2.2
	 */
	protected function displayField() {
		echo '<input type="checkbox" id="', $this->id, '" name="', $this->name, 
		     '" value="1"', checked( true, $this->value, false ), '>';
	}
}


/**
 * @since 3.1
 */
class SiteTreeMetaCheckbox extends SiteTreeCheckbox {
    /**
     * @since 3.1
     */
    public function display() {
        echo '<label>';

        $this->displayField();

        echo $this->viewData->tooltip, '</label>';
    }
}


/**
 * @since 1.4
 */
class SiteTreeDropdown extends SiteTreeFieldView {
	/**
	 * @see parent::displayField()
     * @since 2.2
	 */
	public function displayField() {
		echo '<select id="', $this->id, '" name="', $this->name, '">';
		
		foreach ( $this->viewData->config as $value => $label ) {
            echo '<option value="', esc_attr( $value ), '"', selected( $value, $this->value, false ), 
                 '>', $label, '</option>';
        }
		
		echo '</select>';
	}
}


/**
 * @since 1.4
 */
class SiteTreeTextField extends SiteTreeFieldView {
	/**
	 * @see parent::displayField()
     * @since 2.2
	 */
	public function displayField() {
		echo '<input type="text" id="', $this->id, '" name="', $this->name,
             '" value="', esc_html( $this->value ), '" class="regular-text">';
	}
}


/**
 * @since 1.4
 */
class SiteTreeTextarea extends SiteTreeFieldView {
	/**
	 * @see parent::displayField()
     * @since 2.2
	 */
	public function displayField() {
		echo '<textarea name="', $this->name, 
             '" class="code" />', esc_html( $this->value ), '</textarea><br />';
	}
}


/**
 * @since 1.4
 */
class SiteTreeNumberField extends SiteTreeFieldView {
	/**
	 * @see parent::displayField()
     * @since 2.2
	 */
	public function displayField() {
		echo '<input type="number" id="', $this->id, '" name="', $this->name, 
             '" value="', esc_attr( $this->value ), '" min="', $this->viewData->config['min_value'], 
             '" max="', $this->viewData->config['max_value'], '" class="small-text">';
	}
}
?>