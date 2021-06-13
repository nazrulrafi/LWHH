<?php 
/*
**************************************************************************

Plugin Name:  option demo two
Description:  word count for one or more of your image uploads. Useful when changing their sizes or your theme.
Plugin URI:   https://alex.blog/wordpress-plugins/regenerate-thumbnails/
Version:      1.0
Author:       Nazrul Rafi
Author URI:   https://nazrulrafi.com/
Text Domain:  option-demo
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html

**************************************************************************
*/
require_once plugin_dir_path(__FILE__)."/option_demo_extra.php";

class OptionDemo_settings_page{
    function __construct(){
        add_action("admin_menu",array($this,"optionDemo_create_settings"));
        add_action("admin_init",array($this,"optionDemo_setup_sections"));
        add_action("admin_init",array($this,"optionDemo_setup_fields"));
        add_action("plugins_loaded",array($this,"optionDemo_bootstrapping"));
        add_action("plugin_action_links_".plugin_basename(__FILE__),array($this,"optionDemo_setting_links"));
        add_action("admin_enqueue_scripts",array($this,"optiondemo_assets_management"));
    }
    public function optiondemo_assets_management($screen){
        if("toplevel_page_optionsdemopage"==$screen){
            wp_enqueue_style("bootsrap","//cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css");
            wp_enqueue_style("optiondemo-main-style",plugin_dir_url(__FILE__)."/assets/css/style.css",null,time());
        }
      
    }
    public function optionDemo_setting_links($links){
        $newLinks=sprintf('<a href="%s">%s</a>','options-general.php?page=option-demo-two','Settings');
        $links[]=$newLinks;
        return $links;
    }
    public function optionDemo_bootstrapping(){
        load_plugin_textdomain("optionDemo",false,dirname(__FILE__)."languages");
    }
    public function optionDemo_create_settings(){
        $page_title=__("Options Demo Two","optionDemo");
        $menu_title=__("Options Demo Two","optionDemo");
        $capability="manage_options";
        $slug="optionsdemo";
        $callback=array($this,"optionDemo_create_admin_page");
        add_options_page($page_title,$menu_title,$capability,$slug,$callback);
    }
    public function optionDemo_create_admin_page(){
        ?>
        	<div class="wrap">
			<h2>Option demo two</h2>
			<p>This is option demo page settings</p>
          
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields('optionsdemo');
					do_settings_sections('optionsdemo');
					submit_button();
				?>
			</form>
		</div>
        <?php
    }
    public function optionDemo_setup_sections(){
        add_settings_section(
			'optiondemo_section', 
			'Demonstration of Settings Section page', 
			array( $this, 'option_demo_section_info' ), 
			'optionsdemo'
		);
    }
    public function optionDemo_setup_fields(){
        $fields=array(
            array(
                'label'     =>__("Latitude","optionDemo"),
                'id'        =>'optiondemon_latitude',
                'type'      =>'text',
                'section'   =>'optiondemo_section',
                'placeholder'=>'Latitude'
            ),
            array(
                'label'     =>__("Longtitude","optionDemo"),
                'id'        =>'optiondemon_longtitude',
                'type'      =>'text',
                'section'   =>'optiondemo_section',
                'placeholder'=>'Longtitude'
            ), 
            array(
                'label'     =>__("API key","optionDemo"),
                'id'        =>'optiondemon_api',
                'type'      =>'text',
                'section'   =>'optiondemo_section',
                'placeholder'=>'API'
            ),
            array(
                'label'     =>__("Enternal CSS","optionDemo"),
                'id'        =>'optiondemon_external_css',
                'type'      =>'textarea',
                'section'   =>'optiondemo_section',
                'placeholder'=>'External CSS'
            ),
            array(
                'label'     =>__("Expire Date","optionDemo"),
                'id'        =>'optiondemon_expire_date',
                'type'      =>'date',
                'section'   =>'optiondemo_section',
            ),
        );
        foreach($fields as $field){
            add_settings_field($field["id"],
                $field["label"],
                array($this,"optiondemo_field_callback"),
                "optionsdemo",$field["section"],$field
            );
            register_setting("optionsdemo",$field["id"]);
        }

    }
    public function optiondemo_field_callback($field){
        $value=get_option($field["id"]);
        switch($field["type"]){
            case "textarea":
                    printf('<textarea name="%1$s" id="%1$s" placeholder="%2$s" rwo="5" col="20">%3$s</textarea>',
                    $field["id"],
                    isset($field["placeholder"])?$field["placeholder"]:"",
                    $value);
                break;
            default:    
                printf('<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s">',
                    $field["id"],
                    $field["type"],
                    isset($field["placeholder"])?$field["placeholder"]:"",
                    $value
                );
        }
        if(isset($field["desc"])){
            if($desc=$field["desc"]){
                printf('<p class="description">%s</p>',$desc);
            }
        }
    }
    public function option_demo_section_info(){
        echo "Hi this is rafi";
    }
}
new OptionDemo_settings_page();