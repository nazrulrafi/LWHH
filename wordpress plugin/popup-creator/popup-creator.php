<?php 
/*
**************************************************************************

Plugin Name:  popup creator
Description:  word count for one or more of your image uploads. Useful when changing their sizes or your theme.
Plugin URI:   https://alex.blog/wordpress-plugins/regenerate-thumbnails/
Version:      1.0
Author:       Nazrul Rafi
Author URI:   https://nazrulrafi.com/
Text Domain:  popup-creator
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Plugin type:  Piklist  
**************************************************************************
*/
class PopupCreator{
    public function __construct(){
        add_action("plugins_loaded",array($this,"pc_load_textDmain"));
        add_action("init",array($this,"register_cpt_popup"));
        add_action( 'init', array( $this, 'register_popup_size'));
        add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ));
        add_action( 'wp_footer', array( $this, 'print_modal_markup' ));
    }
    public function pc_load_textDmain(){
        load_plugin_textdomain("popup-crator",false,plugin_dir_url(__FILE__)."languages");
    }
    function register_popup_size() {
		add_image_size( 'popup-landscape', '800', '600', true );
		add_image_size( 'popup-square', '500', '500', true );
	}
    public function load_assets(){
        wp_enqueue_style("popup-creator-css",plugin_dir_url(__FILE__)."assets/public/css/popup-creator.css",null,time());
        wp_enqueue_script( 'plain-modal', plugin_dir_url( __FILE__ ) . "assets/public/js/plainmodal.min.js", array('jquery',),null,true );
        wp_enqueue_script( 'popupcreator-main', plugin_dir_url( __FILE__ ) . "assets/public/js/popupcreator-main.js", array(
			'jquery',
            'plain-modal'
		),time(),true );
    }
    public function register_cpt_popup(){
        $labels = [
            "name" => __( "popups", "popup-crator" ),
            "singular_name" => __( "popup", "popup-crator" ),
            "menu_name" => __( "Popups", "popup-crator" ),
            "featured_image" =>__("Popup Image","popup-crator" ),
            "set_featured_image" =>__("Set Popup Image","popup-crator" ),
        ];
    
        $args = [
            "label" => __( "popups", "popup-crator" ),
            "labels" => $labels,
            "description" => "",
            "public" => false,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => false,
            "delete_with_user" => false,
            "exclude_from_search" => true,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => [ "slug" => "popup", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "thumbnail" ],
        ];
        register_post_type( "popup", $args );
    }
    public function print_modal_markup(){
        $args=array(
            "post_type" =>"popup",
            "status"    =>"publish",
            "meta_key"  =>"popupcreator_active",
            "meta_value"=>1
        );
        $query=new WP_Query($args);
        while($query->have_posts()){
            $query->the_post();
            $size=get_post_meta(get_the_ID(),"popupcreator_popup_size",true);
            $image=get_the_post_thumbnail_url(get_the_ID(),$size);
            $exit=get_post_meta(get_the_ID(),"popupcreator_on_exit",true);
            $delay=get_post_meta(get_the_ID(),"popupcreator_display_after",true);
            if($delay >0){
                $delay*=1000;
            }else{
                $delay=0;
            }
?>
<div class="modal-content" data-modal-id="<?php the_ID()?>" data-exit="<?php echo $exit?>" data-delay="<?php echo $delay?>">
    <div>
        <img class="close-button" width="30" src="<?php echo plugin_dir_url(__FILE__)."assets/img/x.png"?>" alt="">
    </div>
    <img src="<?php echo esc_url($image)?>" alt="popup">
</div>
<?php
        }
        wp_reset_query();
    }
}
new PopupCreator();