<?php
/*
Title: Quick Edit
Capability: manage_options
*/

$arg=array(
    'meta_key'   => 'quick_edit',
    'meta_value' => 1,
    'post_type'  => array('post','page'),
    'posts_per_page'=>-1
);
$posts=new WP_Query($arg);
echo "<ul>";
    while($posts->have_posts()){
        $posts->the_post();
        printf("<li><a href='%s'>%s</a></li>",get_edit_post_link($posts->ID),get_the_title());
    }
echo "</ul>";
wp_reset_query();