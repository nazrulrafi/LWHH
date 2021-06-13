<?php
/**
 * Plugin Name:       column demo
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nazrul Rafi
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       column-demo
 * Domain Path:       /languages
 */
function column_textdomain_loaded(){
    load_plugin_textdomain("column-demo",false,plugin_dir_url(__FILE__)."languages");
}
add_action("plugins_loaded","column_textdomain_loaded");
function coldemo_post_column($columns){
    unset($columns["tags"]);
    unset($columns["categories"]);
    unset($columns["comments"]);
    unset($columns["date"]);
    $columns["post_id"]="Post Id";
    $columns["thumbnail"]="Thumbnail";
    $columns["word_count"]="Words";
    return $columns;
}
add_filter("manage_posts_columns","coldemo_post_column");
function data_populate_post_column($column,$post_id){
    if($column=="post_id"){
        echo $post_id;
    }elseif ($column=="thumbnail"){
        $thumbnail=get_the_post_thumbnail($post_id,array(50,50));
        echo  $thumbnail;
    }elseif ($column=="word_count"){
//        $post=get_post($post_id);
//        $content=$post->post_content;
//        $content=strip_tags($content);
//        $count=str_word_count($content);
//        echo  $count;
        $wordn=get_post_meta($post_id,"wordn",true);
        echo $wordn;
    }
}
add_action("manage_posts_custom_column","data_populate_post_column",10,2);
function coldemo_sortable_column($columns){
    $columns["word_count"]="wordn";
    return $columns;
}
add_filter("manage_edit-post_sortable_columns","coldemo_sortable_column");

//function coldemo_set_word_count(){
//    $_posts=get_posts(array(
//        "posts_per_page"    =>-1,
//        "post_type"         =>"post",
//        "post_status"       =>"any"
//    ));
//    foreach ($_posts as $p){
//        $content=$p->post_content;
//        $content=strip_tags($content);
//        $count=str_word_count($content);
//        update_post_meta($p->ID,"wordn",$count);
//    }
//}
//add_action("init","coldemo_set_word_count");

function coldemo_sort_column_data($wpquery){
    if(!is_admin()){
        return;
    }
    $orderby=$wpquery->get("orderby");
    if("wordn"==$orderby){
        $wpquery->set("meta_key","wordn");
        $wpquery->set("orderby","meta_value_num");
    }
}
add_action("pre_get_posts","coldemo_sort_column_data");
function coldemo_update_wordn($post_id){
        $post=get_post($post_id);
        $content=$post->post_content;
        $content=strip_tags($content);
        $count=str_word_count($content);
        update_post_meta($post->ID,"wordn",$count);
}
add_action("save_post","coldemo_update_wordn");

//Add filter option in post
function coldemo_post_filter(){
    if(isset( $_GET["post_type"]) && $_GET["post_type"]!="post"){
        return;
    };
    $filter_val=isset($_GET["demofilter"])?$_GET["demofilter"]:"";
    $values=array(
        "0" =>"Select Status",
        "1" =>"Select Some Post",
        "2" => "Select Some Post++"
    );
    ?>
    <select name="demofilter">
        <?php
          foreach ($values as $key=>$val){
              printf("<option value='%s'  %s>%s</option>",$key,$key==$filter_val?"selected=selected":"",$val);
          }
        ?>
    </select>

    <?php
}
add_action("restrict_manage_posts","coldemo_post_filter");


function displaying_post_filter_data($wpquery){
    if(!is_admin()){
        return;
    }
    $filter_val=isset($_GET["demofilter"])?$_GET["demofilter"]:"";
    if($filter_val=="1"){
        $wpquery->set("post__in",array(1,7,74));
    }elseif ($filter_val=="2"){
        $wpquery->set("post__in",array(37,18,32,25));
    }
}
add_action("pre_get_posts","displaying_post_filter_data");

//Add Thumbnail option in post
function coldemo_post_thumbnail_filter(){
    if(isset( $_GET["post_type"]) && $_GET["post_type"]!="post"){
        return;
    };
    $filter_val=isset($_GET["demothumb"])?$_GET["demothumb"]:"";
    $values=array(
        "0" =>"Select Status",
        "1" =>"Has Thumbnail",
        "2" =>"No Thumbnail"
    );
    ?>
    <select name="demothumb">
        <?php
        foreach ($values as $key=>$val){
            printf("<option value='%s'  %s>%s</option>",$key,$key==$filter_val?"selected=selected":"",$val);
        }
        ?>
    </select>

    <?php
}
add_action("restrict_manage_posts","coldemo_post_thumbnail_filter");

function displaying_post_thumb_filter_data($wpquery){
    if(!is_admin()){
        return;
    }
    $filter_val=isset($_GET["demothumb"])?$_GET["demothumb"]:"";
    if($filter_val=="1"){
        $wpquery->set("meta_query",array(
               array(
                   "key"       =>"_thumbnail_id",
                   "compare"   =>"EXISTS"
               )
        ));
    }elseif ($filter_val=="2"){
        $wpquery->set("meta_query",array(
            array(
                "key"       =>"_thumbnail_id",
                "compare"   =>"EXISTS"
            )
        ));
    }
}
add_action("pre_get_posts","displaying_post_thumb_filter_data");

//Specific Word count number filter
function coldemo_post_wordn_filter(){
    if(isset( $_GET["post_type"]) && $_GET["post_type"]!="post"){
        return;
    };
    $filter_val=isset($_GET["demowordn"])?$_GET["demowordn"]:"";
    $values=array(
        "0" =>"Word Count",
        "1" =>"Above 600",
        "2" =>"Between 200 to 600",
        "3" =>"Below 200"
    );
    ?>
    <select name="demowordn">
        <?php
        foreach ($values as $key=>$val){
            printf("<option value='%s'  %s>%s</option>",$key,$key==$filter_val?"selected=selected":"",$val);
        }
        ?>
    </select>

    <?php
}
add_action("restrict_manage_posts","coldemo_post_wordn_filter");

function displaying_post_wordn_filter_data($wpquery){
    if(!is_admin()){
        return;
    }
    $filter_val=isset($_GET["demowordn"])?$_GET["demowordn"]:"";
    if($filter_val=="1"){
        $wpquery->set("meta_query",array(
            array(
                "key"       =>"wordn",
                "compare"   =>">=",
                "value"     =>600,
                "type"      =>"NUMERIC"
            )
        ));
    }elseif ($filter_val=="2"){
        $wpquery->set("meta_query",array(
            array(
                "key"       =>"wordn",
                "compare"   =>"BETWEEN",
                "value"     =>array(200,600),
                "type"      =>"NUMERIC"
            )
        ));
    }elseif ($filter_val=="3"){
        $wpquery->set("meta_query",array(
            array(
                "key"       =>"wordn",
                "compare"   =>"<=",
                "value"     =>200,
                "type"      =>"NUMERIC"
            )
        ));
    }
}
add_action("pre_get_posts","displaying_post_wordn_filter_data");