<?php
/*
Plugin Name: Query Query
Plugin URI: http://www.zamartz.com/Examples/queryquery
Description: Ability to make WP Queries within Posts and Pages through shortcode [QueryQuery]
Version: 1.0.0
Author: Zachary A. Martz
Author URI: http://www.zamartz.com
License: GPLv2 or later
Donate Link: http://bt.zamartz.com/RpKg9V
*/
// ==================================
// Start Admin Page
// ==================================
	add_action('admin_menu', 'att_add_queryquery');
	//Admin scripts
	if (is_admin()){
	add_action('admin_enqueue_scripts', 'my_QueryQuery_admin_theme');
	}
	//Uninstall script
	register_uninstall_hook('uninstall.php',"");
	//Front end scrips
	if (!is_admin()){
	add_action('wp_enqueue_scripts', 'my_QueryQuery_front_theme');
	}
	//Make our function to call the WordPress function to add to the correct menu.
	function att_add_queryquery() {
		add_menu_page('Query Query', 'Query Query', 'administrator', 'menu-QueryQuery','add_queryquery_php',"div");
	}
	function my_QueryQuery_admin_theme() {
		wp_enqueue_style('my-QueryQuery-admin-theme', plugins_url('QueryQuery.css', __FILE__));
	}
	function my_QueryQuery_front_theme() {
		wp_enqueue_style('my-QueryQuery-front-defaut', plugins_url('QueryQuery_default.css', __FILE__));
	}
	function add_queryquery_php(){
		require_once dirname( __FILE__ ) . '/QueryQuery_admin.php';
	}
// ======================================
// Start Shortcodes
// ======================================
	//check if admin
	if (!is_admin()){ 
	//check for active products
	include_once dirname( __FILE__ ) . '/shortcodes.php';
	}//end shortcodes
?>