<?php
function shortcode_ui_option_advanced_example(){
    $fields = array(
        array(
            'label'       => 'place',
            'attr'        => 'place',
            'type'        => 'text',
        ),
        array(
            'label'       => 'width',
            'attr'        => 'width',
            'type'        => 'text',
        ),
        array(
            'label'       => 'height',
            'attr'        => 'height',
            'type'        => 'text',
        ),
    );
    $shortcode_ui_args = array(
        'label' => 'Google Map',
        'listItemImage' => 'dashicons-editor-quote',
        'post_type' => array( 'post' ),
        'attrs' => $fields,
    );
    shortcode_ui_register_for_shortcode( 'gmap', $shortcode_ui_args );
}
add_action( 'register_shortcode_ui', 'shortcode_ui_option_advanced_example' );
function shortcode_ui_servic_box(){
    $fields = array(
        array(
            'label'       => 'title',
            'attr'        => 'title',
            'type'        => 'text',
        ),
        array(
            'label'       => 'button link',
            'attr'        => 'link',
            'type'        => 'text',
        ),
        array(
            'label'       => esc_html__( 'Attachment', 'shortcode-ui-example', 'shortcode-ui' ),
            'attr'        => 'attachment',
            'type'        => 'attachment',
            'libraryType' => array( 'image' ),
            'addButton'   => esc_html__( 'Select Image', 'shortcode-ui-example', 'shortcode-ui' ),
        ),
    );
    $shortcode_ui_args = array(
        'label' => 'service',
        'listItemImage' => 'dashicons-welcome-write-blog',
        'post_type' => array( 'post' ),
        'inner_content' => array(
            'label'        => 'Quote',
            'description'  =>  'Include a statement from someone famous.',
        ),
        'attrs' => $fields,
    );
    shortcode_ui_register_for_shortcode( 'service', $shortcode_ui_args );
}
add_action( 'register_shortcode_ui', 'shortcode_ui_servic_box' );