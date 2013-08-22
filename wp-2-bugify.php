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

	function __construct() {
		add_action('admin_menu', array(&$this, 'bugify_admin_menu'));
		register_activation_hook( __FILE__, array($this, 'activate') );
		
		$this->options = get_option($this->opt_name);
		$this->plugin_url = plugin_dir_url( __FILE__ );
		add_action('admin_enqueue_scripts', array(&$this, 'register_style') );
	}
	function activate() {
		$default_options = array('url' => null,
								 'key' => null );
		add_option( $this->opt_name, $default_options, null, 'no' );
	}
    public function register_style() {
        wp_register_style( 'bugify-css', $this->plugin_url . 'css/bugify.css', array(), (string)$this->version );
        wp_enqueue_style(  'bugify-css' );
    }
	function bugify_admin_menu() {
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
	function bugify_view_submit() {
		require_once('views/submit.php');
	}
	function bugify_view_options() {
		require_once('views/options.php');
	}
}
$bugify = new bugify;