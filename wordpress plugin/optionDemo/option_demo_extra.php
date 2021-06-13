<?php 
class OptionDemoExtra{
    public function __construct(){
        add_action("admin_menu",array($this,"optionDemo_create_settings_page"));
        add_action("admin_menu",array($this,"optionDemo_create_settings_submenu_page"));
        add_action("admin_post_optiondemo_admin_page",array($this,"optionDemo_save_page"));
    }
    public function optionDemo_create_settings_page(){
        $page_title=__("Options Admin Page","optionDemo");
        $menu_title=__("Options Admin Page","optionDemo");
        $capability="manage_options";
        $slug="optionsdemopage";
        $callback=array($this,"optionDemo_page_content");
        add_menu_page($page_title,$menu_title,$capability,$slug,$callback);
    }
    public function optionDemo_create_settings_submenu_page(){
        add_submenu_page( 
            'optionsdemopage', 
            'Submenu Page One', 
            'Submenu Page One',
            'manage_options', 
            'optiondemo-page-one',
            function(){
                echo "Title";
            }
        );
    }
    public function optionDemo_page_content(){
       require_once plugin_dir_path(__FILE__)."/option-page-form.php";
    }
    public function optionDemo_save_page(){
        check_admin_referer("optiondemo");
        if(isset($_POST["optiondemo_latitude02"])){
            update_option("optiondemo_latitude02",sanitize_text_field($_POST["optiondemo_latitude02"]));
        } 
        if(isset($_POST["optiondemo_lontitude02"])){
            update_option("optiondemo_lontitude02",sanitize_text_field($_POST["optiondemo_lontitude02"]));
        }
        wp_redirect("admin.php?page=optionsdemopage");
        
    }
}
new OptionDemoExtra();