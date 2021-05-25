<?php
/**
 * Plugin Name:       Post selection from page
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nazrul Rafi
 * Author URI:        https://nazrulrafi.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-selection
 * Domain Path:       /languages
 */
function loading_plugin_textdomain(){
    load_plugin_textdomain("post-selection",false, dirname(__FILE__) . "/languages");
}
add_action("plugins_loaded", "loading_plugin_textdomain");
function assets_management(){
    wp_enqueue_style("main-post-style",plugin_dir_url(__FILE__)."style.css",null,time());
}
add_action("admin_enqueue_scripts","assets_management");
function ptmf_is_secure($nonce_field,$action,$post_id){
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
function ptmf_add_metabox(){
    add_meta_box("ptmf_select_post_mb","Select Posts","desplay_selected_posts","page");
}
add_action("admin_menu","ptmf_add_metabox");
function ptmf_post_metabox($post_id){
    if(!ptmf_is_secure("ptmf_posts_nonce","ptmf_posts",$post_id)){
        return $post_id;
    }
    $post=$_POST["ptmf-select-post"];
    $posts=$_POST["ptmf-select-posts"];
    $terms=$_POST["ptmf-select-term"];
    update_post_meta($post_id,"ptmf-select-post",$post);
    update_post_meta($post_id,"ptmf-select-posts",$posts);
    update_post_meta($post_id,"ptmf-select-term",$terms);
}
add_action("save_post","ptmf_post_metabox");
function desplay_selected_posts($post){
    wp_nonce_field("ptmf_posts","ptmf_posts_nonce");
    $get_post=get_post_meta($post->ID,"ptmf-select-post",true);
    $get_posts=get_post_meta($post->ID,"ptmf-select-posts",true);
    $get_term=get_post_meta($post->ID,"ptmf-select-term",true);
    //single post query
    $args=array(
        "post_type"     =>"post",
        "post_per_page" =>-1
    );
    $_posts=new WP_Query($args);
    $dropdown_list="";
    while($_posts->have_posts()){
        $extra="";
        $_posts->the_post();
        if(get_the_ID()==$get_post){
            $extra="selected";
        }
        $dropdown_list.=sprintf("<option value='%s' %s>%s</option>",get_the_ID(),$extra,get_the_title());
    }
    wp_reset_query();

    //Multple posts query
    $args=array(
        "post_type"     =>"post",
        "post_per_page" =>-1
    );
    $_multiple_posts=new WP_Query($args);
    $dropdown_multiple_list="";
    while($_multiple_posts->have_posts()){
        $extra="";
        $_multiple_posts->the_post();
        if(in_array(get_the_ID(),$get_posts)){
            $extra="selected";
        }
        $dropdown_multiple_list.=sprintf("<option value='%s' %s>%s</option>",get_the_ID(),$extra,get_the_title());
    }
    wp_reset_query();

    //Term Lists
    $terms=get_terms(array(
            "taxonomy"  =>"category",
            "hide_empty"=>false
    ));
    $terms_dropdown="";

    foreach ($terms as $term){
        $extra="";
        if($term->term_id==$get_term){
            $extra="selected";
        }
        $terms_dropdown.=sprintf("<option value='%s' %s>%s</option>",$term->term_id,$extra,$term->name);
    }
    ?>
    <table class="multiple_posts_select">
        <tr>
            <td><label for="select-post">Select Single Post</label></td>
            <td>
                <select id="select-post" name="ptmf-select-post">
                    <?php echo $dropdown_list;?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="select-post">Select Multiple Posts</label></td>
            <td>
                <select id="select-posts" name="ptmf-select-posts[]" multiple>
                    <?php echo $dropdown_multiple_list;?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="select-post">Term Selection</label></td>
            <td>
                <select id="select-term" name="ptmf-select-term" >
                    <?php echo $terms_dropdown;?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

