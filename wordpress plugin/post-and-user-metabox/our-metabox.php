<?php
/**
 * Plugin Name:       Our Metaboxes
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       our-metaboxes
 * Domain Path:       /languages
 */

class OurMetabox{
    function __construct(){
        add_action("plugins_loaded",array($this,"omb_load_textdomain"));
        add_action("admin_menu",array($this,"omb_add_metabox"));
        add_action("save_post",array($this,"omb_save_location"));
        add_action("save_post",array($this,"omb_save_image"));
        add_action("admin_enqueue_scripts",array($this,"omb_assets_loading"));
        add_filter("user_contactmethods",array($this,"omb_user_contact_method"));
    }
    function omb_load_textdomain(){
        load_plugin_textdomain("post-and-user-metabox",plugin_dir_url(__FILE__)."/languages");
    }
    function omb_assets_loading(){
        wp_enqueue_style("omb_jquery_ui","//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css");
        wp_enqueue_style("omb-main-style",plugin_dir_url(__FILE__)."admin/css/style.css",null,time());
        wp_enqueue_script("omb-main-script",plugin_dir_url(__FILE__)."admin/js/main.js",array("jquery","jquery-ui-datepicker"),time(),true);
    }
    function is_secure($nonce_field,$action,$post_id){
        $nonce=$_POST[$nonce_field]??"";
        if($nonce==""){
            return false;
        };
        if(!wp_verify_nonce($nonce,$action)){
            return false;
        };
        if(!current_user_can("edit_post",$post_id)){
            return false;
        };
        if(wp_is_post_autosave($post_id)){
            return false;
        };
        if (wp_is_post_revision($post_id)){
            return false;
        }
        return true;
    }
    function omb_add_metabox(){
        add_meta_box("omb_post_location","Extra Metabox",array($this,"omb_display_location_info"),"post","normal");
        add_meta_box("omb_image_metabox","Image and gallery metabox",array($this,"omb_display_image_metabox"),"post","normal");
    }
    function  omb_save_location($post_id){
        if(!$this->is_secure("omb_metabox_field","omb_metabox",$post_id)){
            return  $post_id;
        }
        $location=$_POST["omb_location"]??"";
        $profession=$_POST["omb_profession"]??"";
        $is_fav=$_POST["omb_is_fav"]??"";
        $colors=$_POST["omb_color"]??array();
        $language=$_POST["omb_language"]??"";
        $birthday=$_POST["omb_birthday"]??"";
        $country=$_POST["omb_country"]??"";

        if($location =="" || $profession==""){
            return $post_id;
        };
        $location=sanitize_text_field($location);
        $profession=sanitize_text_field($profession);

        update_post_meta($post_id,"omb_location",$location);
        update_post_meta($post_id,"omb_profession",$profession);
        update_post_meta($post_id,"omb_is_fav",$is_fav);
        update_post_meta($post_id,"omb_colors",$colors);
        update_post_meta($post_id,"omb_language",$language);
        update_post_meta($post_id,"omb_birthday",$birthday);
        update_post_meta($post_id,"omb_country",$country);
    }
    function omb_save_image($post_id){
        if(!$this->is_secure("omb_image_field","omb_image_action",$post_id)){
            return $post_id;
        }
        $img_id=$_POST["omb_image_id"]??"";
        $img_url=$_POST["omb_image_url"]??"";
        $img_ids=$_POST["omb_gallery_ids"]??"";
        $img_urls=$_POST["omb_gallery_urls"]??"";

        if($img_id=="" || $img_url==""){
            return  $post_id;
        }
        update_post_meta($post_id,"omb_image_id",$img_id);
        update_post_meta($post_id,"omb_image_url",$img_url);
        update_post_meta($post_id,"omb_gallery_ids",$img_ids);
        update_post_meta($post_id,"omb_gallery_urls",$img_urls);
    }
    function omb_user_contact_method($methods){
        $methods["facebook"]="Facebook";
        $methods["twitter"]="Twitter";
        $methods["linkedin"]="Linkedin";
        $methods["bdjobs"]="BDjobs";
        return $methods;
    }
    function omb_display_location_info($post){
        $label01="Location Info";
        $label02="Professsion";
        $label03="IS Favourite";
        $label04="What is your favourite color?";
        $label05="What is your favourite language?";
        $label06="Select BirthDay";
        $label07="Select Your Country";

        $location=get_post_meta($post->ID,"omb_location",true);
        $profession=get_post_meta($post->ID,"omb_profession",true);
        $is_fav=get_post_meta($post->ID,"omb_is_fav",true);
        $checked=$is_fav?"checked":"";
        $save_clr=get_post_meta($post->ID,"omb_colors",true);
        $save_language=get_post_meta($post->ID,"omb_language",true);
        $birthday=get_post_meta($post->ID,"omb_birthday",true);
        $selected_country=get_post_meta($post->ID,"omb_country",true);


        $colors=array("Green","Blue","Yellow","Megenta","Black","White","Red");
        $languages=array("Java","Javascript","Ruby","Python","PHP","C++","Go","Rust");
        $countries=["Bangladesh","India","Pakisthan","Bhuthan","America","Canada","Brazil","UAE","Dubai"];
        sort($countries);
       
        $dropdown_country="<option value='0'>Select Your Country</option>";
        $select="";
        foreach ($countries as $country){
            $select=($country==$selected_country)?"selected":"";
            $dropdown_country.=sprintf("<option value='%s' %s>%s</option>",$country,$select,$country);
        }
        wp_nonce_field("omb_metabox","omb_metabox_field");
        $metabox_html=<<<EOD
 <table class="metabox-table">
        <tr>
            <td><label for="omb_location">{$label01}</label></td>
            <td><input type="text" name="omb_location" id="omb_location" value="{$location}"/></td>
        </tr>
        <tr>
            <td><label for="omb_profession">{$label02}</label></td>
            <td><input type="text" name="omb_profession" id="omb_profession" value="{$profession}"/></td>
        </tr>
        <tr>
            <td><label for="omb_is_fav">{$label03}</label></td>
            <td><input type="checkbox" name="omb_is_fav" id="omb_is_fav" value="1" {$checked}/></td>
        </tr>
        <tr>
            <td><label>{$label04}</label></td>
            <td>
 EOD;
        foreach ($colors as $color){
            $checked=in_array($color,$save_clr)?"checked":"";
            $metabox_html.=<<<EOD
            
                <input type="checkbox" name="omb_color[]" id="omb_color_{$color}" value="{$color}" {$checked}>
                <label for="omb_color_{$color}">$color</label>
EOD;
        }
        $metabox_html.=<<<POD
            </td>
        </tr>
        <tr>
            <td> <label>{$label05}</label></td>
            <td>
POD;

        foreach ($languages as $language){
            $check=($language==$save_language)?"checked=checked":"";
            $metabox_html.=<<<EOD
          
                <input type="radio" name="omb_language" id="omb_{$language}" value="{$language}" {$check}/>
                <label for="omb_{$language}">{$language}</label>
EOD;

        }
        $metabox_html.=<<<POD
                </td>
            </tr>
            <tr>
                <td><label for="omb_birthday">{$label06}</label></td>
                <td><input type="text" id="datepicker" name="omb_birthday" value="{$birthday}"></td>
            </tr>
             <tr>
                <td><label for="omb_birthday">{$label07}</label></td>
                <td>
                    <select name="omb_country" id="omb_country">
                        {$dropdown_country}
                    </select>
                </td>
            </tr>
        </table>
POD;
;

    echo $metabox_html;
    }
    function omb_display_image_metabox($post){
        $img_id=get_post_meta($post->ID,"omb_image_id",true);
        $img_url=get_post_meta($post->ID,"omb_image_url",true);
        $img_ids=get_post_meta($post->ID,"omb_gallery_ids",true);
        $img_urls=get_post_meta($post->ID,"omb_gallery_urls",true);


        wp_nonce_field("omb_image_action","omb_image_field");
        $metabox_html=<<<POD
    <table class="image_metabox_table">
        <tr>
            <td><label>Upload Your Image</label></td>
            <td>
                <button class="button" id="upload-image">Upload Image</button>
                <input type="hidden" name="omb_image_id" id="omb_image_id" value="{$img_id}">
                <input type="hidden" name="omb_image_url" id="omb_image_url" value="{$img_url}">
                <div id="image_container"></div>
            </td>
        </tr>  
        <tr>
            <td><label>Upload Your Gallery Image</label></td>
            <td>
                <button class="button" id="upload-gallery">Upload Gallery</button>
                <input type="hidden" name="omb_gallery_ids" id="omb_gallery_ids" value="{$img_ids}">
                <input type="hidden" name="omb_gallery_urls" id="omb_gallery_urls" value="{$img_urls}">
                <div id="gallery_container"></div>
            </td>
        </tr>      
    </table>
POD;
    echo  $metabox_html;
    }
}
new OurMetabox();