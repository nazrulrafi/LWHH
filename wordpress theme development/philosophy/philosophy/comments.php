<div class="comments-wrap">
    <div id="comments" class="row">
        <div class="col-full">
            <?php $philosophy_comment_num=get_comments_number()?>
            <?php if(have_comments()){?>
            <h3 class="h2">
                <?php if($philosophy_comment_num <=1){
                    echo wp_kses_post($philosophy_comment_num)." ".__("Comment","philosophy02");
                }else{
                    echo wp_kses_post($philosophy_comment_num)." ".__("Comments","philosophy02");
                }?> 
            </h3>
            <?php }?>
            <!-- commentlist -->
            
                <ol class="commentlist">
                    <?php 
                    function mytheme_comment($comment, $args, $depth) {
                        if ( 'div' === $args['style'] ) {
                            $tag       = 'div';
                            $add_below = 'comment';
                        } else {
                            $tag       = 'li';
                            $add_below = 'div-comment';
                        }?>
                        <<?php echo wp_kses_post($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>">
                        <?php 
                            if ( 'div' != $args['style'] ) { ?>
                                <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
                            } 
                        ?>
                        <div class="comment-author vcard comment__avatar"><?php 
                            if ( $args['avatar_size'] != 0 ) {
                                echo get_avatar( $comment, $args['avatar_size'] ); 
                            } 
                            ?>
                        </div>
                        <?php 
                            if ( $comment->comment_approved == '0' ) { ?>
                                <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','philosophy02' ); ?></em><br/><?php 
                            } 
                        ?>
                    <div class="comment-meta commentmetadata comment__content">
                        <div class="comment__info">
                            <cite><?php echo get_comment_author() ;?></cite> 
                            <div class="comment__meta">
                                <time class="comment__time">
                                    <?php
                                        /* translators: 1: date, 2: time */
                                        printf( 
                                            __('%1$s at %2$s'), 
                                            get_comment_date(),  
                                            get_comment_time() 
                                        ); 
                                    ?>
                                </time>
                                <?php 
                                    comment_reply_link( 
                                        array_merge( 
                                            $args, 
                                            array( 
                                                'add_below' => $add_below, 
                                                'depth'     => $depth, 
                                                'max_depth' => $args['max_depth'],
                                            ) 
                                        ) 
                                    ); 
                                ?>
                                <?php edit_comment_link( __( '(Edit)','philosophy02' ), '  ', '' ); ?>
                            </div>
                        </div>
                        <div class="comment__text">
                            <?php comment_text(); ?>
                        </div>
                    </div>
            
                    <?php 
                        if ( 'div' != $args['style'] ) : ?>
                            </div><?php 
                        endif;
                    }
                    ?>
                    <?php wp_list_comments( 'type=comment&callback=mytheme_comment' ); ?>
                </ol>

                    <?php  the_comments_pagination()?>
                <!-- respond
                ================================================== -->
                <div class="respond">

                    <h3 class="h2">Add Comment</h3>
                    <?php 
                        $arg=array(
                            'title_reply' =>"",
                            'comment_notes_before' => "",
                            'comment_notes_after' => '',
                            'class_form'        =>'contactForm',
                            'fields' => array(
                                'author' => '<div class="form-field">
                                <input name="cName" type="text" id="cName" class="full-width" placeholder="Your Name" value="">
                                </div>',
                                
                                'email' => '<div class="form-field">
                                <input name="cEmail" type="text" id="cEmail" class="full-width" placeholder="Your Email" value="">
                                </div>',
                                
                                'url' => '<div class="form-field">
                                <input name="cWebsite" type="text" id="cWebsite" class="full-width" placeholder="Website" value="">
                                </div>',
                                
                                'cookies' => '',
                            ),
                            'comment_field' =>'<div class="message form-field">
                            <textarea name="comment" id="comment" class="full-width" placeholder="Your Message"></textarea>
                            </div>',
                            'class_submit'  =>'submit btn--primary btn--large full-width',
                        );
                        comment_form($arg);
                    ?>
                </div> <!-- end respond -->

        </div> <!-- end col-full -->

    </div> <!-- end row comments -->
</div> <!-- end comments-wrap -->