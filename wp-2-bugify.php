<?php
/*
Plugin Name: Wordpress to Bugify
Version: 0.1
Plugin URI: http://www.iamparagon.com/
Description: Allow visitors to your site to submit bugify issues
Author: Mike Garde
Author URI: http://philipjoyner.com/
Updated: 2013-06-19
License: MIT
*/

class bugify {
	private $opt_name = 'wp-2-bugify';
	public  $version  = 0.1;
	private $options  = null;
	private $plugin_url = null;

	/*                                                           
		   d888888o.   8 8888888888 8888888 8888888888 8 8888      88 8 888888888o   
		 .`8888:' `88. 8 8888             8 8888       8 8888      88 8 8888    `88. 
		 8.`8888.   Y8 8 8888             8 8888       8 8888      88 8 8888     `88 
		 `8.`8888.     8 8888             8 8888       8 8888      88 8 8888     ,88 
		  `8.`8888.    8 888888888888     8 8888       8 8888      88 8 8888.   ,88' 
		   `8.`8888.   8 8888             8 8888       8 8888      88 8 888888888P'  
		    `8.`8888.  8 8888             8 8888       8 8888      88 8 8888         
		8b   `8.`8888. 8 8888             8 8888       ` 8888     ,8P 8 8888         
		`8b.  ;8.`8888 8 8888             8 8888         8888   ,d8P  8 8888         
		 `Y8888P ,88P' 8 888888888888     8 8888          `Y88888P'   8 8888         
	 */
	function __construct() {
		add_action('admin_init', array(&$this, 'settings_init'));
		add_action('admin_menu', array(&$this, 'bugify_admin_menu'));
		register_activation_hook( __FILE__, array($this, 'activate') );
		
		$this->options = get_option($this->opt_name);
		$this->plugin_url = plugin_dir_url( __FILE__ );
		add_action('admin_enqueue_scripts', array(&$this, 'register_style') );
	}
	function activate() {
		$default_options = array('url' => 'http://demo.bugify.com/api',
								 'key' => 'LSGjeU4yP1X493ud1hNniA==' );
		add_option( $this->opt_name, $default_options, null, 'no' );
	}
    public function register_style() {
        wp_register_style( 'bugify-css', $this->plugin_url . 'css/bugify.css', array(), (string)$this->version );
        wp_enqueue_style(  'bugify-css' );
    }
	public function bugify_admin_menu() {
		add_menu_page(		'Submit a Bug',
							'Bugify',
							'manage_options',
							'bugify',
							array($this, 'bugify_view_submit'),
							$this->plugin_url . 'img/bugify-logo-small.png',
							110 );

		add_submenu_page(	'bugify',
							'Submit to Bugify',
							'Submit to Bugify',
							'manage_options',
							'bugify',
							array($this, 'bugify_view_submit') );

		add_submenu_page(	'bugify',
							'Bugify Options',
							'Options',
							'manage_options',
							'bugify-options',
							array($this, 'bugify_view_options') );
	}
	/*
		`8.`888b           ,8'  8 8888 8 8888888888 `8.`888b                 ,8' d888888o.   
		 `8.`888b         ,8'   8 8888 8 8888        `8.`888b               ,8'.`8888:' `88. 
		  `8.`888b       ,8'    8 8888 8 8888         `8.`888b             ,8' 8.`8888.   Y8 
		   `8.`888b     ,8'     8 8888 8 8888          `8.`888b     .b    ,8'  `8.`8888.     
		    `8.`888b   ,8'      8 8888 8 888888888888   `8.`888b    88b  ,8'    `8.`8888.    
		     `8.`888b ,8'       8 8888 8 8888            `8.`888b .`888b,8'      `8.`8888.   
		      `8.`888b8'        8 8888 8 8888             `8.`888b8.`8888'        `8.`8888.  
		       `8.`888'         8 8888 8 8888              `8.`888`8.`88'     8b   `8.`8888. 
		        `8.`8'          8 8888 8 8888               `8.`8' `8,`'      `8b.  ;8.`8888 
		         `8.`           8 8888 8 888888888888        `8.`   `8'        `Y8888P ,88P' 
	*/

	function bugify_view_submit() {
		require_once('views/submit.php');
	}
	function bugify_view_options() {
		require_once('views/options.php');
	}

	/*                                                              
		     ,o888888o.    8 8888888888 8888888 8888888888 d888888o.   
		    8888     `88.  8 8888             8 8888     .`8888:' `88. 
		 ,8 8888       `8. 8 8888             8 8888     8.`8888.   Y8 
		 88 8888           8 8888             8 8888     `8.`8888.     
		 88 8888           8 888888888888     8 8888      `8.`8888.    
		 88 8888           8 8888             8 8888       `8.`8888.   
		 88 8888   8888888 8 8888             8 8888        `8.`8888.  
		 `8 8888       .8' 8 8888             8 8888    8b   `8.`8888. 
		    8888     ,88'  8 8888             8 8888    `8b.  ;8.`8888 
		     `8888888P'    8 888888888888     8 8888     `Y8888P ,88P' 
	 */

	public function get_api_url($echo=true) {
		if(! is_admin())
			return false;

		if($echo == true) echo $this->options['url'];
		else return $this->options['url'];
	}
	public function get_api_key($echo=true) {
		if(! is_admin())
			return false;

		if($echo == true) echo $this->options['key'];
		else return $this->options['key'];
	}

	/*                                                                                              
		    ,o888888o.     8 888888888o 8888888 8888888888  8 8888     ,o888888o.     b.             8    d888888o.   
		 . 8888     `88.   8 8888    `88.     8 8888        8 8888  . 8888     `88.   888o.          8  .`8888:' `88. 
		,8 8888       `8b  8 8888     `88     8 8888        8 8888 ,8 8888       `8b  Y88888o.       8  8.`8888.   Y8 
		88 8888        `8b 8 8888     ,88     8 8888        8 8888 88 8888        `8b .`Y888888o.    8  `8.`8888.     
		88 8888         88 8 8888.   ,88'     8 8888        8 8888 88 8888         88 8o. `Y888888o. 8   `8.`8888.    
		88 8888         88 8 888888888P'      8 8888        8 8888 88 8888         88 8`Y8o. `Y88888o8    `8.`8888.   
		88 8888        ,8P 8 8888             8 8888        8 8888 88 8888        ,8P 8   `Y8o. `Y8888     `8.`8888.  
		`8 8888       ,8P  8 8888             8 8888        8 8888 `8 8888       ,8P  8      `Y8o. `Y8 8b   `8.`8888. 
		 ` 8888     ,88'   8 8888             8 8888        8 8888  ` 8888     ,88'   8         `Y8o.` `8b.  ;8.`8888 
		    `8888888P'     8 8888             8 8888        8 8888     `8888888P'     8            `Yo  `Y8888P ,88P' 
		                                                                                                              
		8 888888888o      .8.           ,o888888o.    8 8888888888                                                    
		8 8888    `88.   .888.         8888     `88.  8 8888                                                          
		8 8888     `88  :88888.     ,8 8888       `8. 8 8888                                                          
		8 8888     ,88 . `88888.    88 8888           8 8888                                                          
		8 8888.   ,88'.8. `88888.   88 8888           8 888888888888                                                  
		8 888888888P'.8`8. `88888.  88 8888           8 8888                                                          
		8 8888      .8' `8. `88888. 88 8888   8888888 8 8888                                                          
		8 8888     .8'   `8. `88888.`8 8888       .8' 8 8888                                                          
		8 8888    .888888888. `88888.  8888     ,88'  8 8888                                                          
		8 8888   .8'       `8. `88888.  `8888888P'    8 888888888888                                                  
	 */

	function settings_init() {
	   add_settings_section($this->opt_name,
		   'API Access',
		   array($this, 'settings_callback_api'),
		   'bugify');

	   add_settings_field('url',
		   'API URL',
		   array($this, 'setting_callback_url'),
		   'bugify',
		   $this->opt_name);

	   add_settings_field('key',
		   'API URL',
		   array($this, 'setting_callback_key'),
		   'bugify',
		   $this->opt_name);

	   register_setting('bugify','url');
	   register_setting('bugify','key');
	}

	function settings_callback_api() {
	   echo '<p>Intro text for our settings section</p>';
	}

	function setting_callback_url() {
	   echo '<input type="text" name="url" id="gv_thumbnails_insert_into_excerpt" value="'. $this->options['url'] .'" />';
   }

	function setting_callback_key() {
	   echo '<input type="text" name="key" id="gv_thumbnails_insert_into_excerpt" value="'. $this->options['key'] .'" />';
   }
}
$bugify = new bugify;

// Notes done in Broadway Font
// http://patorjk.com/software/taag/#p=display&f=Broadway&t=Setup