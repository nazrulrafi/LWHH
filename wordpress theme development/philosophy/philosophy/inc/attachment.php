<?php 
define( 'ATTACHMENTS_SETTINGS_SCREEN', false );
add_filter( 'attachments_default_instance', '__return_false' );
function my_attachments( $attachments )
{
    $post_id=null;
    if(isset($_REQUEST['post']) || isset($_REQUEST['post_ID'])){
        $post_id=empty($_REQUEST['post_ID'])?$_REQUEST['post']:$_REQUEST['post_ID'];
    }
    if(!$post_id || get_post_format($post_id) !="gallery"){
        return;
    }
  $fields         = array(
    array(
      'name'      => 'title',                         
      'type'      => 'text',                         
      'label'     => __( 'Caption', 'philosophy02' ),  
    ),
  );

  $args = array(

    'label'         => 'Post Gallery',
    'post_type'     => array( 'post' ),
    'position'      => 'normal',
    'priority'      => 'high',
    'filetype'      => null,  // no filetype limit
    'note'          => '',
    'append'        => true,
    'button_text'   => __( 'Attach Gallery', 'philosophy02' ),
    'modal_text'    => __( 'Attach Gallery', 'philosophy02' ),
	  'post_parent'   => false,
    'fields'        => $fields,

  );

  $attachments->register( 'gallery', $args ); // unique instance name
}

add_action( 'attachments_register', 'my_attachments' );