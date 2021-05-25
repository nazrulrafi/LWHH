<?php
/**
 * Plugin Name:       Qr code generator
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       qr-code
 * Domain Path:       /languages
 */
$qr_languges=["PHP", "java","javascript","python","kotlin","dart","flutter","typescript","C++"];
$qr_countries=["Bangladesh","India","Vhutan","Nepal","dubai","America","Canada"];
function qr_countries_add(){
    global $qr_countries;
    $qr_countries=apply_filters("add_new_country",$qr_countries);
}
add_action("init","qr_countries_add");
add_action("plugin_loaded",function (){
    load_plugin_textdomain("qr-code",false,plugin_dir_url(__FILE__)."/languages");
});
function qr_code_generator($content){
    $post_id=get_the_ID();
    $post_title=get_the_title();
    $post_link=get_the_permalink($post_id);
    $post_type=get_post_type($post_id);
    $post_format=get_post_format($post_id);

    $excluded_post=apply_filters("excluded_post_type",array());
    $excluded_post_format=apply_filters("excluded_post_format",array());
    if(in_array($post_type,$excluded_post)){
        return  $content;
    }
    if (in_array($post_format,$excluded_post_format)){
        return  $content;
    }
    $height=get_option("qr-height")??"100";
    $width=get_option("qr-weight")??"100";
    $size=apply_filters("qr_code_size","{$height}x{$width}");
    $qr_src_link=sprintf("https://api.qrserver.com/v1/create-qr-code/?data=%s&size=%s&margin=0",$post_link,$size);
    $content.=sprintf("<div class='qr-code'><img src='%s' alt='%s'></div>",$qr_src_link,$post_title);

    return $content;
}
add_filter("the_content","qr_code_generator");

add_filter("excluded_post_type",function ($type){
    $type[]="page";
    return $type;
});

add_filter("excluded_post_format",function ($pf){
    $pf=["link","video","audio"];
    return $pf;
});

function qr_setting_fields(){
    add_settings_section("qe-section","QR Code Setting","qr_section_display","general");
    add_settings_field("qr_height",__("QR Height","qr-code"),"qr_height_display","general","qe-section");
    add_settings_field("qr_width",__("QR Width","qr-code"),"qr_width_display","general","qe-section");
    add_settings_field("qr_select",__("Select Country","qr-code"),"qr_select_display","general","qe-section");
    add_settings_field("qr_checkbox",__("Select Languages","qr-code"),"qr_checkbox_display","general","qe-section");
    add_settings_field("qr_toggle_btn",__("Toggle Field","qr-code"),"qr_toggle_display","general","qe-section");

    register_setting("general","qr-height",array("sanitize_callback"=>"esc_attr"));
    register_setting("general","qr-weight",array("sanitize_callback"=>"esc_attr"));
    register_setting("general","qr-select",array("sanitize_callback"=>"esc_attr"));
    register_setting("general","qr-checkbox");
    register_setting("general","qr-toggle");

}
function qr_toggle_display(){
    $val=get_option("qr-toggle");
    echo '<div class="toggle"></div>';
    echo "<input type='hidden' name='qr-toggle' id='qr-toggle' value='{$val}'/>";
}
function qr_checkbox_display(){
    global $qr_languges;
    $qr_languges=apply_filters("qr_languages_extra",$qr_languges);
    $get_lan=get_option("qr-checkbox");
    foreach ($qr_languges as $language){
        $selected="";
        if(is_array($get_lan) && in_array($language,$get_lan)){
            $selected="checked";
        };
        printf("<input type='checkbox' name='qr-checkbox[]' value='%s' %s>%s <br>",$language,$selected,$language);
    }
}
function qr_select_display(){
    global $qr_countries;
    $get_country=get_option("qr-select");
    printf("<select name='%s' id='%s'>","qr-select","qr-select");
    foreach ($qr_countries as $country){
        $selected="";
        if ($get_country ==$country) $selected="selected";
            printf("<option value='%s' %s>%s</option>",$country,$selected,$country);

    }
    printf("</select>");
}
function qr_section_display(){

}
function qr_height_display(){
    $height=get_option("qr-height");
    printf("<input type='text' id='%s' name='%s' value='%s'/>","qr-height","qr-height",$height);
}

function qr_width_display(){
    $weight=get_option("qr-weight");
    printf("<input type='text' id='%s' name='%s' value='%s'/>","qr-weight","qr-weight",$weight);
}

add_action("admin_init","qr_setting_fields");


add_filter("qr_languages_extra",function ($languages){
    array_push($languages,"Go","C#","Ruby");
    $languages=array_diff($languages,array("dart"));
    return $languages;
});

function pqrc_assets($screen){
    if("options-general.php"==$screen){
        wp_enqueue_style("toggle-style",plugin_dir_url(__FILE__)."/assets/css/minitoggle.css");
        wp_enqueue_style("main-style",plugin_dir_url(__FILE__)."/assets/css/style.css");
        wp_enqueue_script("old-jquery","//code.jquery.com/jquery-3.2.1.slim.min.js",null,time(),true);
        wp_enqueue_script("toggle-js",plugin_dir_url(__FILE__)."/assets/js/minitoggle.js",array("old-jquery"),time(),true);
        wp_enqueue_script("main-js",plugin_dir_url(__FILE__)."/assets/js/main.js",array("jquery"),time(),true);
    }
}
add_action("admin_enqueue_scripts","pqrc_assets");

add_filter("add_new_country",function ($countries){
    array_push($countries,"japan","russia","qatar","UAE");
    return $countries;
});