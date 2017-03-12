<?php

/**
 * Register custom sidebar
 */
if ( function_exists( 'register_sidebar' ) ) {
    if ( ! function_exists( 'huyhoang_register_sidebars' ) ) {
        function huyhoang_register_sidebars() {
            register_sidebar( array(
                'id'            => 'contact-sidebar',
                'name'          => __( 'Contact Sidebar', 'huyhoang' ),
                'description'   => __( 'This is the sidebar for contact info', 'huyhoang' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3>',
                'after_title'   => '</h3>',
            ) );
        } // function newsmag_register_sidebars end
        add_action( 'widgets_init', 'huyhoang_register_sidebars' );
    }
}

/**
 * Add custom css to the theme
 */
function huyhoang_custom_css() {
    $base = get_stylesheet_directory_uri();
    wp_enqueue_style( 'custom-style', $base.'/custom.css' );
}
add_action('wp_enqueue_scripts', 'huyhoang_custom_css', 11 );

/**
 * Add custom post type
 */
function huyhoang_bds_post_type() {
    $label = array(
        'name' => 'Bất động sản', 
        'singular_name' => 'Bất động sản'
    );
 
    $args = array(
        'labels' => $label,
        'description' => 'Bất động sản', 
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
        ),
        'taxonomies' => array( 'post_tag' ),
        'hierarchical' => false, 
        'public' => true,
        'show_ui' => true, 
        'show_in_menu' => true,
        'show_in_nav_menus' => true, 
        'show_in_admin_bar' => true, 
        'menu_position' => 4,
        'can_export' => true,
        'has_archive' => true, 
        'exclude_from_search' => false, 
        'publicly_queryable' => true, 
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'bat-dong-san')
    );
    register_post_type('bat_dong_san', $args);
}
add_action('init', 'huyhoang_bds_post_type');