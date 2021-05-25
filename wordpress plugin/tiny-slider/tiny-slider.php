<?php
/**
 * Plugin Name:       Tiny Slider
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tiny-slider
 * Domain Path:       /languages
 */
function plugin_textdomain_loading(){
    load_plugin_textdomain("tiny-slider",false,plugin_dir_url(__FILE__)."/languages");
}
add_action("plugins_loaded","plugin_textdomain_loading");
function tiny_slider_assets_loading(){
    wp_enqueue_style("tiny-slider-style","//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css",null,time());
    wp_enqueue_script("tiny-slider-js","//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js",null,"1.0",true);
    wp_enqueue_script("tiny-slider-main-js",plugin_dir_url(__FILE__)."assets/js/main.js",array("jquery"),time(),true);
}
add_action("wp_enqueue_scripts","tiny_slider_assets_loading");
function tiny_shortcode_slider($attr,$content){
    $default=array(
        "id"    =>"slider-wrap",
        "width" =>800,
        "height"=>600
    );
    $attributes=shortcode_atts($default,$attr);
    $content=do_shortcode($content);
    $shortcode_output=<<<EOD
    <div id="{$attributes['id']}" style="width:{$attributes['width']}px;height:{$attributes['height']}px">
        <div class="slider">
            {$content}
        </div>
    </div>
EOD;
    return $shortcode_output;
}
add_shortcode("tslider","tiny_shortcode_slider");
function tiny_shortcode_slide($attr){
    $default=array(
        "id"        =>"",
        "caption"   =>"",
        "size"      =>"large"
    );
    $attributes=shortcode_atts($default,$attr);
    $img_src=wp_get_attachment_image_src($attributes["id"],$attributes["size"]);
    $shortcode_output=<<<EOD
    <div class="slide">
        <p><img src="{$img_src[0]}"></p>
        <p>{$attributes["caption"]}</p>
    </div>
EOD;
return $shortcode_output;
}
add_shortcode("tslide","tiny_shortcode_slide");




