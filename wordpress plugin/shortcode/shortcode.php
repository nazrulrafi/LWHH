<?php
/**
 * Plugin Name:       shortcode builder
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       shortcode-builder
 * Domain Path:       /languages
 */

require "shortcode-ui-fields.php";
add_action("plugin_loaded",function (){
    load_plugin_textdomain("shortcode-builder",false,plugin_dir_path(__FILE__)."\languages");
});
function service_box_display($attr,$content){
    $default=array(
            "title" =>"This is default title",
            "link"  =>"https://developer.wordpress.org/"
    );
    $box_attr=shortcode_atts($default,$attr);
    ?>
    <div class="wrapper">
        <?php echo wp_kses_post( wp_get_attachment_image( $attr['attachment'], array( 200, 200 ) ) ); ?>
        <h2><?php echo $box_attr["title"]?></h2>
        <p><?php echo $content?></p>
        <a href="<?php echo $box_attr['link']?>"><button class="service-btn">Click Here</button></a>
    </div>
    <?php
}
add_shortcode("service","service_box_display");
function header_adding_css(){
    ?>
  <style>
    .wrapper{
        padding: 25px 15px;
        border: 3px solid red;
        text-align: center;
        border-radius: 20px;
    }
    .wrapper h2{
        font-size: 18px;
    }
    .wrapper p{
        font-size: 16px;
    }
    .gmap_canvas {
        overflow: hidden;
        background: none !important;
        height: 500px;
        width: 600px;
    }
  </style>
    <?php
}
add_action("wp_head","header_adding_css");
function display_gmap($attr){
    ?>
    <div class="mapouter">
        <div class="gmap_canvas">
            <iframe width="<?php echo $attr['width']?>" height="<?php echo $attr['height']?>" id="gmap_canvas"
                    src="https://maps.google.com/maps?q=<?php echo $attr['place']?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
                    scrolling="no" marginheight="0" marginwidth="0">
            </iframe>
        </div>
    </div>
    <?php
}
add_shortcode("gmap","display_gmap");