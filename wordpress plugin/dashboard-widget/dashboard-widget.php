<?php 
/*
**************************************************************************
Plugin Name:  dashboardWidget
Description:  word count for one or more of your image uploads. Useful when changing their sizes or your theme.
Plugin URI:   https://alex.blog/wordpress-plugins/regenerate-thumbnails/
Version:      1.0
Author:       Nazrul Rafi
Author URI:   https://nazrulrafi.com/
Text Domain:  dashboard-widget
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
**************************************************************************
*/
function dashboard_widget_laod_textdomain(){
    load_plugin_textdomain("dashboard-widget",false,dirname(__FILE__)."languages");
}
add_action("plugins_loaded","dashboard_widget_laod_textdomain");

function ddw_dashboard_widget(){
    if(current_user_can("edit_dashboard")){
        wp_add_dashboard_widget(
            "dashboardWidget",
            "Dashboard Widget",
            "ddw_dashboard_widget_output",
            "ddw_dashboard_widget_configure"
        );
    }else{
        wp_add_dashboard_widget(
            "dashboardWidget",
            "Dashboard Widget",
            "ddw_dashboard_widget_output",
        );
    }
    
}
add_action("wp_dashboard_setup","ddw_dashboard_widget");

function ddw_dashboard_widget_output(){
    $number_of_posts=get_option("dashboardWidget_nop",5);
    $feeds=array(
        array(
           'url'            =>'https://wptavern.com/feed',
           'items'          =>$number_of_posts,
           'show_summery'   =>false,
           'show_author'    =>false,
           'show_date'      =>false
       )
       );
       wp_dashboard_primary_output("dashboardwidget",$feeds);
}

function ddw_dashboard_widget_configure(){
    $number_of_posts=get_option("dashboardWidget_nop",5);
    
    if(isset($_POST["dashboard-widget-nonce"]) && wp_verify_nonce($_POST["dashboard-widget-nonce"],"edit-dashboard-widget_dashboardWidget")){
        if(isset($_POST["ddw_nop"]) && $_POST["ddw_nop"] >0){
            $number_of_posts=sanitize_text_field($_POST["ddw_nop"]);
            update_option("dashboardWidget_nop",$number_of_posts);
        }
    }
   
?>
<p>
    <label>Number of Posts</label>
    <input type="text" class="widefat" name="ddw_nop" id="ddw_nop" value="<?php echo $number_of_posts?>">
</p>

<?php
}