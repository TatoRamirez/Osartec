<?php
namespace sitetree;

/**
 * @package LC Plugin
 * @version 1.3.2
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * A base class upon which can be built the plugin's main class.
 */
abstract class Plugin {
    /**
     * @since 1.0
     */
    const MIN_WP_VERSION = '5.2';

    /**
     * @since 1.0
     * @var object
     */
    protected static $plugin;
    
    /**
     * @since 1.3.1
     * @var string
     */
    protected $name;

    /**
     * @since 1.3
     * @var string
     */
    protected $version;

    /**
     * Path of the main file (plugin-name.php).
     *
     * @since 1.0
     * @var string
     */
    protected $loaderPath;

    /**
     * @since 1.3.1
     * @var string
     */
    protected $basename;

    /**
     * @since 1.3
     * @var string
     */
    protected $pluginURI;

    /**
     * @since 1.3.2
     * @var string
     */
    protected $authorURI;

    /**
     * Name of the plugin's directory.
     *
     * @since 1.0
     * @var string
     */
    protected $dirName;
    
    /**
     * @since 1.0
     * @var string
     */
    protected $dirPath;

    /**
     * URL of the plugin's directory.
     *
     * @since 1.0
     * @var string
     */
    protected $dirURL;

    /**
     * @see registerAdminNoticeActionWithMessage()
     * @since 1.0
     *
     * @var string
     */
    protected $compatibilityErrorMessage;

   /**
     * @since 1.0
     *
     * @param string $loader_path
     * @return bool
     */
    public static function launch( $loader_path ) {
        global $pagenow;

        if ( self::$plugin ) {
            return false;
        }

        self::$plugin             = new static();
        self::$plugin->loaderPath = $loader_path;
        self::$plugin->dirPath    = dirname( $loader_path ) . '/';
        self::$plugin->dirName    = basename( self::$plugin->dirPath );

        if ( is_admin() ) {
            self::$plugin->basename = plugin_basename( $loader_path );
        }

        $plugin_info = get_file_data( $loader_path, array(
            'name'       => 'Plugin Name',
            'version'    => 'Version',
            'uri'        => 'Plugin URI',
            'author_uri' => 'Author URI'
        ));

        if ( 
            !$plugin_info['version'] || 
            ( preg_match( '/[^0-9\.]/', $plugin_info['version'] ) === 1 )
        ) {
            self::$plugin->registerAdminNoticeActionWithMessage( "Unable to retrieve plugin's version." );

            return false;
        }

        self::$plugin->name      = $plugin_info['name'];
        self::$plugin->version   = $plugin_info['version'];
        self::$plugin->pluginURI = $plugin_info['uri'];
        self::$plugin->authorURI = $plugin_info['author_uri'];

        return self::$plugin->verifyWordPressCompatibility();
    }

    /**
     * Returns a reference to the plugin object.
     *
     * @since 1.0
     * @return object
     */
    public static function invoke() {
        return self::$plugin;
    }

    /**
     * @since 1.0
     */
    private function __construct() {}
    
    /**
     * @since 1.0
     * @return int Error code.
     */
    public function __clone() { return -1; }

    /**
     * @since 1.0
     * @return int Error code.
     */
    public function __wakeup() { return -1; }

    /**
     * @since 1.0
     *
     * @param string $relative_path
     * @return object
     */
    public function load( $relative_path ) {
        include( $this->dirPath . $relative_path );
    }

    /**
     * @since 1.3.1
     * @return string
     */
    public function name() { 
        return $this->name;
    }

    /**
     * @since 1.0
     * @return string
     */
    public function textdomain() {
        return $this->dirName;
    }
    
    /**
     * @since 1.0
     * @return string
     */
    public function version() { 
        return $this->version;
    }

    /**
     * @since 1.0
     * @return string
     */
    public function loaderPath() {
        return $this->loaderPath;
    }

    /**
     * @since 1.3.1
     * @return string
     */
    public function basename() {
        return $this->basename;
    }

    /**
     * @since 1.3
     *
     * @param string $relative_URL
     * @return string
     */
    public function pluginURI( $relative_URL = '' ) { 
        return ( $this->pluginURI . $relative_URL );
    }

    /**
     * @since 1.3.2
     *
     * @param string $relative_URL
     * @return string
     */
    public function authorURI( $relative_URL = '' ) { 
        return ( $this->authorURI . $relative_URL );
    }

    /**
     * @since 1.0
     * @return string
     */
    public function dirPath() {
        return $this->dirPath;
    }

    /**
     * @since 1.0
     * @return string
     */
    public function dirName() {
        return $this->dirName;
    }

    /**
     * @since 1.0
     *
     * @param string $path Optional.
     * @return string
     */
    public function dirURL( $path = '' ) {
        if (! $this->dirURL ) {
            $this->dirURL = plugins_url( $this->dirName() . '/' );
        }

        return $this->dirURL . $path;
    }
    
    /**
     * @since 1.0
     * @return bool
     */
    private function verifyWordPressCompatibility() {
        global $wp_version;
        
        if ( version_compare( $wp_version, static::MIN_WP_VERSION, '>=' ) ) {
            return true;
        }

        $this->registerAdminNoticeActionWithMessage(
            'To use ' . $this->name . ' ' . $this->version
          . ' you need at least WordPress ' . static::MIN_WP_VERSION
          . '. Please, update your WordPress installation to '
          . '<a href="https://wordpress.org/download/">the latest version available</a>.'
        );

        return false;
    }

    /**
     * @since 1.0
     */
    public function loadTextdomain() {
        $languages_folder_path = $this->dirName() . '/languages/';

        load_plugin_textdomain( $this->textdomain(), false, $languages_folder_path );
    }
    
    /**
     * @since 1.0
     * @param string $message
     */
    public function registerAdminNoticeActionWithMessage( $message ) {
        $this->compatibilityErrorMessage = $message;

        add_action( 'admin_notices', array( $this, 'displayAdminNotice' ) );
    }
    
    /**
     * @since 1.0
     */
    public function displayAdminNotice() {
        echo '<div class="notice notice-error"><p>', $this->compatibilityErrorMessage, '</p></div>';
            
        // Hides the message "Plugin Activated" 
        // if the error is triggered during activation.
        unset( $_GET['activate'] );
    }
}
?>