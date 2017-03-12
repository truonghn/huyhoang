<?php
define( 'EZAP_INC_DIR', get_stylesheet_directory() . '/inc' );
require_once( EZAP_INC_DIR . '/visual_composer.php' );
require_once( EZAP_INC_DIR . '/functions/custom-events.php' );

add_action( 'wp_enqueue_scripts', 'stm_enqueue_parent_styles' );

function stm_enqueue_parent_styles() {

	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array( 'normalize.css', 'bootstrap.min.css' ) );

}
// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');

function add_theme_scripts() {
    wp_enqueue_style( 'flexslider', get_stylesheet_directory_uri() . '/css/flexslider.css');
    wp_register_script( 'flexslider', get_stylesheet_directory_uri() . '/js/jquery.flexslider.js' );
    wp_register_script( 'ezap-script', get_stylesheet_directory_uri() . '/js/ezap.js' );

    wp_enqueue_script( 'flexslider' );
    wp_enqueue_script( 'ezap-script' );
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// Thêm data-toggle cho menu đăng ký luyện âm
function add_menuclass($ulclass) {
return preg_replace('/<a href="#dang-ky-luyen-am"/', '<a href="#dang-ky-luyen-am" data-toggle="modal" data-target="#dang-ky-luyen-am"', $ulclass, 1);
}
add_filter('wp_nav_menu','add_menuclass');

// Thêm post type chuong-trinh
function lanhtv_chuong_trinh_post_type()
{
    $label = array(
        'name' => 'Chương trình học', 
        'singular_name' => 'Chương trình học'
    );
 
    $args = array(
        'labels' => $label,
        'description' => 'Post type chương trình học', 
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
        'rewrite' => array('slug' => 'chuong-trinh')
    );
 
    register_post_type('chuong_trinh', $args);
 
}
add_action('init', 'lanhtv_chuong_trinh_post_type');

/*
 * register loại thư viện
 */
function lanhtv_loai_chuong_trinh_taxonomy() {
    $labels = array(
        'name' => 'Loại chương trình',
        'singular' => 'Loại chương trình',
        'menu_name' => 'Loại chương trình'
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy('loai-chuong-trinh', array('chuong_trinh', 'testimonial'), $args);
 
}
 
// Hook into the 'init' action
add_action( 'init', 'lanhtv_loai_chuong_trinh_taxonomy', 0 );

//Thay dổi ... sang chọn khóa học
function luyenam_wpcf7_form_elements($html) {
    if (!function_exists('lanhtv_replace_include_blank')) {
        function lanhtv_replace_include_blank($name, $text, $remove, &$html) {
            $matches = false;
            preg_match('/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $html, $matches);
            if ($matches) {
                if ($remove) {
                    $select = str_replace('<option value="">---</option>', '', $matches[0]);
                } else {
                    $select = str_replace('<option value="">---</option>', '<option value="">' . $text . '</option>', $matches[0]);
                }
                $html = preg_replace('/<select name="' . $name . '"[^>]*>(.*)<\/select>/iU', $select, $html);
            }
        }
    }
    lanhtv_replace_include_blank('thoi_gian', '', true, $html);
    lanhtv_replace_include_blank('khoa_hoc', 'Chọn khóa học', false, $html);
    // $text = 'Chọn khóa học';
    // $html = str_replace('---', '' . $text . '', $html);
    return $html;
}
add_filter('wpcf7_form_elements', 'luyenam_wpcf7_form_elements');

