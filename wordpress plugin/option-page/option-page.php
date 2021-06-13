<?php
/**
 * Plugin Name:       Option Page
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            nazrul rafi
 * Author URI:        https://nazrulrafi.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       option-page
 * Domain Path:       /languages
 */


class Option_settings_page{
    function  __construct(){
        add_action("plugins_loaded",array($this,"loading_textdomain"));
        add_action("admin_menu",array($this,"option_create_setting_page"));
        add_action("admin_enqueue_scripts",array($this,"option_assets_loading"));
        add_action("admin_post_optiondemo_admit_page",array($this,"option_setting_save_page"));
    }
    function loading_textdomain(){
        load_plugin_textdomain("option-page",false,plugin_dir_url(__FILE__)."/languages");
    }
    function  option_assets_loading(){
        wp_enqueue_style("bootsrap-style","//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css");
    }
    function option_create_setting_page(){
        $title="Option Page";
        $menu_title="Menu Title";
        $capability="manage_options";
        $slug="option_menu_page";
        $callback="option_page_content";
        add_menu_page($title,$menu_title,$capability,$slug,array($this,$callback));
    }
    function  option_setting_save_page(){
        check_admin_referer("option_page");
       if ($_POST["option_page_name"]){
           update_option("option_page_name",sanitize_text_field($_POST["option_page_name"]));
       }
       if ($_POST["option_page_latitude"]){
           update_option("option_page_latitude",sanitize_text_field($_POST["option_page_latitude"]));
       }if ($_POST["option_page_longtitude"]){
           update_option("option_page_longtitude",sanitize_text_field($_POST["option_page_longtitude"]));
       }
        wp_redirect("admin.php?page=option_menu_page");
    }
    function  option_page_content(){
        require_once plugin_dir_path(__FILE__)."option_page_form.php";
    }
}
new Option_settings_page();