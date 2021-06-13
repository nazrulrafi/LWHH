<?php 
/*
**************************************************************************
Plugin Name:  Quick Tags Demo
Description:  word count for one or more of your image uploads. Useful when changing their sizes or your theme.
Plugin URI:   https://alex.blog/wordpress-plugins/regenerate-thumbnails/
Version:      1.0
Author:       Nazrul Rafi
Author URI:   https://nazrulrafi.com/
Text Domain:  quicktags-demo
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html

**************************************************************************
*/

function qtds_assets_management($screen){
    if("post.php"==$screen){
        wp_enqueue_script("qtds-main-js",plugin_dir_url(__FILE__)."assets/js/main.js",array("quicktags","thickbox"),time(),true);
        wp_localize_script("qtds-main-js","qtds",array("preview"=>plugin_dir_url(__FILE__)."inc/fap.php"));
    }
}
add_action("admin_enqueue_scripts","qtds_assets_management");