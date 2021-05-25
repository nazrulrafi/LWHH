<?php 
/**
 * Template Name:about page template
 */
?>
<?php the_post()?>
<?php get_header()?>
    <!-- s-content
    ================================================== -->
    <section class="s-content s-content--narrow s-content--no-padding-bottom">

        <article class="row ">

            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    <?php the_title()?>
                </h1>
            </div> <!-- end s-content__header -->
    
            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                    <?php the_post_thumbnail("large")?>
                </div>
            </div> <!-- end s-content__media -->

            <div class="col-full s-content__main">
                <?php the_content()?>
                <div class="row block-1-2 block-tab-full">
                    <?php if(is_active_sidebar("about-page")){
                        dynamic_sidebar("about-page");
                    }?>
                </div>
            </div> <!-- end s-content__main -->

        </article>

    </section> <!-- s-content -->


  <?php get_footer()?>