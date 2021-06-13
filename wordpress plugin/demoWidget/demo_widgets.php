<?php 
/*
**************************************************************************
Plugin Name:  Demo Widget
Description:  word count for one or more of your image uploads. Useful when changing their sizes or your theme.
Plugin URI:   https://alex.blog/wordpress-plugins/regenerate-thumbnails/
Version:      1.0
Author:       Nazrul Rafi
Author URI:   https://nazrulrafi.com/
Text Domain:  demowidget
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
**************************************************************************
*/

require_once plugin_dir_path(__FILE__)."/widgets/class.demoWidget.php";
require_once plugin_dir_path(__FILE__)."/widgets/class.demowidgetui.php";
require_once plugin_dir_path(__FILE__)."/widgets/class.advertisementwidget.php";

function demowidget_bootstrapping(){
    load_plugin_textdomain("demowidget",false,dirname(__FILE__)."languages");
}
add_action("plugins_loaded","demowidget_bootstrapping");


function demowidget_register(){
	register_widget('DemoWidget');
	register_widget('AdvertisementWidget');
	register_widget('DemoWidgetUI');
}
add_action('widgets_init','demowidget_register');

function demowidget_admin_enqueue_scripts($screen){
	if($screen=="widgets.php") {
		wp_enqueue_media();
		wp_enqueue_script("advertisement-widget-js", plugin_dir_url(__FILE__)."assets/js/media-gallery.js", array("jquery"), time(), 1);
		wp_enqueue_style("demowidget-admin-ui-css",plugin_dir_url(__FILE__)."assets/css/widget.css");
	}
}

add_action("admin_enqueue_scripts","demowidget_admin_enqueue_scripts");