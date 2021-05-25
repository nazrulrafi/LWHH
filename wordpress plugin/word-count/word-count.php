<?php
/**
 * Plugin Name:       Words Count
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nazrul Rafi
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       words-count
 * Domain Path:       /languages
 */
// function wordcount_activation_hook(){

// }
// register_activation_hook(__FILE__,"wordcount_activation_hook");
// function wordcount_deactivation_hook(){

// }
// register_deactivation_hook(__FILE__,"wordcount_deactivation_hook");

function wordcount_text_domain_load(){
    load_plugin_textdomain("words-count",false,plugin_dir_url(__FILE__)."/languages");
}
add_action("plugins_loaded","wordcount_text_domain_load");

function wordcount_word_count($content){
    $striped_tags=strip_tags($content);
    $count=str_word_count($striped_tags);
    $label=__("Total Words in this article is","words-count");
    $label=apply_filters("word_count_label",$label);
    $tags=apply_filters("wordcount_tags","h2");
    $content.=sprintf("<%s>%s %s</%s>",$tags,$label,$count,$tags);
    return $content;
}
add_filter("the_content","wordcount_word_count");
function words_reading_time($content){
    $striped_tags=strip_tags($content);
    $words=str_word_count($striped_tags);
    $min=floor($words/200);
    //$sec=floor($words%200 /(200/60));
    $mul=$words%200;
    $sec=floor(($mul*60)/200);
    $visisble=apply_filters("time_visiblr",1);
    if($visisble){
        $label=sprintf("<h3>Total reading time is %s minutes and %s seconds</h3>",$min,$sec);
        $content.=$label;
    }
    return $content;
}
add_filter("the_content","words_reading_time");
