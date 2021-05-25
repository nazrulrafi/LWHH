<a class="header__toggle-menu" href="#0" title="Menu"><span><?php _e("Menu","philosophy02")?></span></a>

<nav class="header__nav-wrap">

    <h2 class="header__nav-heading h6"><?php _e("Site Navigation","philosophy02")?></h2>
    <?php 
        if(has_nav_menu("mainmenu")){
            $main_menu=wp_nav_menu(array(
                "theme_location"=>"mainmenu",
                'menu_class'      => 'header__nav',
                'menu_id'         => 'mainmenu',
                "echo"            =>false
            ));
            $main_menu=str_replace("menu-item-has-children","has-children",$main_menu);
            echo wp_kses_post($main_menu);
        }
    
    ?>
    <a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu"><?php _e("Close","philosophy02")?></a>

</nav> <!-- end header__nav-wrap -->