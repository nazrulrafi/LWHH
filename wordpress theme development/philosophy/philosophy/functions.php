<?php 
require_once get_theme_file_path("/inc/tgm.php");
require_once get_theme_file_path("/inc/attachment.php");
require_once get_theme_file_path("/widgets/social-icons-widget.php");
if ( ! isset( $content_width ) ) $content_width = 960;

if(site_url()=="http://localhost/philosophy02/"){
    define("VERSION",time());
}else{
    define("VERSION",wp_get_theme()->get("Version"));
}

function philosophy02_setup_theme(){
    load_theme_textdomain("philosophy02");
    add_theme_support('html5',array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );
    register_nav_menu("mainmenu",__("this menu place in the top","philosophy02"));
    register_nav_menus(array(
        "footer-left"       =>  __("Footer Left Area","philosophy02"),
        "footer-middel"     =>  __("Footer Middle Area","philosophy02"),
        "footer-right"      =>  __("Footer Right Area","philosophy02"),
    ));
    add_editor_style('/assets/css/editor-style.css');
    add_image_size("philosophy-square-a",400,400,true);
}
add_action("after_setup_theme","philosophy02_setup_theme");


function philosophy02_assests(){
    wp_enqueue_style("fontawesome-css",get_theme_file_uri("/assets/css/font-awesome/css/font-awesome.min.css"),null,VERSION);
    wp_enqueue_style("fonts-css",get_theme_file_uri("/assets/css/fonts.css"),null,VERSION);
    wp_enqueue_style("base-css",get_theme_file_uri("/assets/css/base.css"),null,VERSION);
    wp_enqueue_style("vendor-css",get_theme_file_uri("/assets/css/vendor.css"),null,VERSION);
    wp_enqueue_style("main-css",get_theme_file_uri("/assets/css/main.css"),null,VERSION);
    wp_enqueue_style("stylesheet",get_stylesheet_uri(),null,VERSION);


    wp_enqueue_script("mordenizer-js",get_theme_file_uri("/assets/js/modernizr.js"),null,VERSION);
    wp_enqueue_script("pace-js",get_theme_file_uri("/assets/js/pace.min.js"),null,VERSION);
    wp_enqueue_script("jquery-js",get_theme_file_uri("/assets/js/jquery-3.2.1.min.js"),null,null,true);
    wp_enqueue_script("plugin-js",get_theme_file_uri("/assets/js/plugins.js"),array("jquery-js"),VERSION,true);
    if ( is_singular() ) {
        wp_enqueue_script( "comment-reply" );
    }
    wp_enqueue_script("main-js",get_theme_file_uri("/assets/js/main.js"),array("jquery-js"),VERSION,true);
}
add_action("wp_enqueue_scripts","philosophy02_assests");

function philosophy02_pagination(){
    global $wp_query;
    $links=paginate_links(array(
        "current"   =>max(1,get_query_var("paged")),
        "total"     =>$wp_query->max_num_pages,
        "type"      =>"list",
        "mid-size"  =>3
    ));
    $links=str_replace("page-numbers","pgn__num",$links);
    $links=str_replace("<ul class='pgn__num'>","<ul>",$links);
    $links=str_replace("next pgn__num","pgn__next",$links);
    $links=str_replace("prev pgn__num","pgn__prev",$links);
    echo wp_kses_post($links);
}

function prefix_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
 
}
add_filter( 'comment_form_fields', 'prefix_move_comment_field_to_bottom', 10, 1 );

remove_filter("term_description","wpautop");

function sidebar_and_widget_registration(){
      register_sidebar( array(
            'name'          => __( 'about page', 'philosophy02' ),
            'id'            => 'about-page',
            'description'   => __( 'Widgets in this area will be shown about page.', 'philosophy02' ),
            'before_widget' => ' <div class="col-block">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="quarter-top-margin">',
            'after_title'   => '</h3>',
        ) );
      register_sidebar( array(
            'name'          => __( 'contact map', 'philosophy02' ),
            'id'            => 'contact-map',
            'description'   => __( 'Widgets in this area will be shown contact page map.', 'philosophy02' ),
            'before_widget' => '<div id=__("%1$s","philosophy02") class=__("%2$s","philosophy02)>',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        ) );
        register_sidebar( array(
            'name'          => __( 'contact page info', 'philosophy02' ),
            'id'            => 'contact-info',
            'description'   => __( 'Widgets in this area will be shown about page.', 'philosophy02' ),
            'before_widget' => ' <div class="col-six tab-full">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="quarter-top-margin">',
            'after_title'   => '</h3>',
        ) );
        register_sidebar( array(
            'name'          => __( 'before footer', 'philosophy02' ),
            'id'            => 'before-footer',
            'description'   => __( 'Widgets in this area will be shown page footer.', 'philosophy02' ),
            'before_widget' =>  '<div id=__("%1$s","philosophy02") class=__("%2$s","philosophy02)>',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="quarter-top-margin">',
            'after_title'   => '</h3>',
        ) );
        register_sidebar( array(
            'name'          => __( 'footer right', 'philosophy02' ),
            'id'            => 'footer-right',
            'description'   => __( 'Widgets in this area will be shown page footer right.', 'philosophy02' ),
            'before_widget' => '<div id=__("%1$s","philosophy02") class=__("%2$s","philosophy02)>',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="quarter-top-margin">',
            'after_title'   => '</h4>',
        ) );
        register_sidebar( array(
            'name'          => __( 'footer bottom', 'philosophy02' ),
            'id'            => 'before-bottom',
            'description'   => __( 'Widgets in this area will be shown page footer bottom.', 'philosophy02' ),
            'before_widget' => '<div id=__("%1$s","philosophy02) class="s-footer__copyright">',
            'after_widget'  => '</div>',
            'before_title'  => '">',
            'after_title'   => '',
        ) );
        register_sidebar( array(
            'name'          => __( 'Top Header', 'philosophy02' ),
            'id'            => 'top-header',
            'description'   => __( 'Widgets in this area will be shown page top header.', 'philosophy02' ),
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h4 class="quarter-top-margin">',
            'after_title'   => '</h4>',
        ) );
}
add_action("widgets_init","sidebar_and_widget_registration");

function philosophy_search_form($form){
    $homeDir    =home_url("/");
    $label      =__("Search For","philosophy02");
    $btn_label  =__("Search","philosophy02");
    $newform=<<<FORM
<form role="search" method="get" class="header__search-form" action="{$homeDir}">
    <label>
        <span class="hide-content">{$label}</span>
        <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s" title="{$label}" autocomplete="off">
    </label>
    <input type="submit" class="search-submit" value="{$btn_label}">
</form>
FORM;
return $newform;
}
add_filter("get_search_form","philosophy_search_form");