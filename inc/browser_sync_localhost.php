<?php
/**
 * Plugin Name: Browser Sync on localhost
 * Description: If <code>LOCALIP</code> is defined in <code>wp-config.php</code> and has a valid IP address then The Browser Sync JavaScript snippet will be added to <code>wp_footer</code> and WordPress URLs will be filtered to replace <code>localhost</code> with the IP address defined in <code>LOCALIP</code>
 */

 /*
  * Wrap everything in a class for namespacing
  */
class browser_sync_localhost {
    
    //fire up variables
    private static $url = '';
    private static $dir = '';
    
    /*
     * define variables and call setup method from init
     */
    public static function init() {
	//these are filtered so that plugins can optionally be moved into themes
        self::$url = apply_filters( __CLASS__.'_url', plugins_url('/', __FILE__), __FILE__ );
        self::$dir = apply_filters( __CLASS__.'_dir', plugin_dir_path(__FILE__), __FILE__ );
	
	//run plugin setup after plugins/themes are loaded
        add_action('after_setup_theme', array(__CLASS__, 'setup'));
	
	//Set Time Zone
	date_default_timezone_set('America/Chicago');
	
    }//end init method
    
    /*
     * actions/hooks in setup, after plugins/themes are loaded
     */
    public static function setup() {
	
	//add Browser Sync JS to footer if on localhost
	if( self::is_localhost() ){
	    add_action( 'wp_footer', array(__CLASS__, 'browser_sync_js'), 9999 );
	    add_filter('option_home', array(__CLASS__, 'url_filter'), 99, 1); 
            add_filter('option_siteurl', array(__CLASS__, 'url_filter'), 99, 1); 
            add_filter('stylesheet_directory_uri', array(__CLASS__, 'url_filter'), 99, 1); 
            add_filter('template_directory_uri', array(__CLASS__, 'url_filter'), 99, 1);
	}
    }//end setup method

    /**
    * Are we on localhost?
    * @return string	$local_IP 	LOCALIP if defined and valid, otherwise returns false.
    */
   private static function is_localhost(){
	//check for LOCALHOST from wp-config.php and make sure it is a valid IP
	if( defined('LOCALIP') && preg_match('/[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/',LOCALIP) === 1 ){
	    return LOCALIP;
	} else{
	    //if not return false
	    return false;
	}
    }//end is_localhost method
    
    /**
    * Add browser sync JS to footer
    */
    public static function browser_sync_js() {
	echo "<script type='text/javascript'>//<![CDATA[
	document.write(\"<script async src='//HOST:3000/browser-sync-client.1.3.6.js'><\/script>\".replace(/HOST/g, 	location.hostname));
	//]]></script>";
    }//end browser_sync_js method
    
    /**
    * Filter URL, replacing localhost w/ IP
    * @return	$url 	with filtered value if LOCALIP is defined and valid
    */
    public static function url_filter($url){
        //get current URL
        $current_url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $current_url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $current_url .= $_SERVER["REQUEST_URI"];
        
        //get local IP
        $local_IP = self::is_localhost();
        
        //if local IP is valid and in the current URL
        if( $local_IP !== false && stripos($current_url, $local_IP) !== false ){
            $url = str_replace('localhost', $local_IP, $url );
        }
        
        return $url;
    }//end url_filter
    
}//end browser_sync_localhost

//run init
browser_sync_localhost::init();