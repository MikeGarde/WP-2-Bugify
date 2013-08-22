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
	function __construct() {
		add_action('admin_menu', array(&$this, 'bugify_admin_menu'));
	}
	function bugify_admin_menu() {
		add_menu_page(		'Submit to Bugify',
							'Bugify',
							'manage_options',
							'bugify',
							array($this, 'bugify_view_submit'),
							plugins_url( 'WP-2-Bugify/img/bugify-logo-medium.png' ),
							110 );

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