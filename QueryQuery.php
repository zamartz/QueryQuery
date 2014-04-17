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
	//Uninstall script
	register_uninstall_hook('uninstall.php',"");
	//sets defaults on install	
		if (!get_option("QueryQuery_initialize")){ 
			// get QueryQuery Admin Options
			include_once('QueryQuery_options.php');
			add_option( "QueryQuery_initialize",1,"","yes");
			foreach ($option_list_names as $option_list_name){
				$optionname = "QueryQuery_".$option_list_name["name"]."_default";
				add_option($optionname,$option_list_name["default"],"","yes");
			}
		}
	}
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