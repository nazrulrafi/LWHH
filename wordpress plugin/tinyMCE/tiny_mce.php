<?php 
/*
**************************************************************************
Plugin Name:  TinyMCE Demo
Description:  word count for one or more of your image uploads. Useful when changing their sizes or your theme.
Plugin URI:   https://alex.blog/wordpress-plugins/regenerate-thumbnails/
Version:      1.0
Author:       Nazrul Rafi
Author URI:   https://nazrulrafi.com/
Text Domain:  tinymce-demo
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
**************************************************************************
*/
function tmcd_mce_external_plugins($plugins){
    $plugins["tmcd_plugin"]=plugin_dir_url(__FILE__)."assets/js/tinymce.js";
    return $plugins;
}
function tmcd_mce_buttons($buttons){
    $buttons[]="tmcd_button_one";
    $buttons[]="tmcd_listbox_one";
    $buttons[]="tmcd_menu_one";
    $buttons[]="tmcd_form_button";
    return $buttons;
}
function tmcd_admin_assets(){
    add_filter("mce_external_plugins","tmcd_mce_external_plugins");
    add_filter("mce_buttons","tmcd_mce_buttons");
}
add_action("admin_init","tmcd_admin_assets");