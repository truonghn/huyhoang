<?php
/*
Plugin Name: STM Post Type
Plugin URI: http://stylemixthemes.com/
Description: STM Post Type
Author: Stylemix Themes
Author URI: http://stylemixthemes.com/
Text Domain: stm_post_type
Version: 2.1
*/

define( 'STM_POST_TYPE', 'stm_post_type' );
global $stm_option;
$plugin_path = dirname(__FILE__);

require_once $plugin_path . '/post_type.class.php';

$options = get_option('stm_post_types_options');

$defaultPostTypesOptions = array(
	'projects' => array(
		'title' => __( 'Project', STM_POST_TYPE ),
		'plural_title' => __( 'Projects', STM_POST_TYPE ),
		'rewrite' => 'project'
	),
	'services' => array(
		'title' => __( 'Service', STM_POST_TYPE ),
		'plural_title' => __( 'Services', STM_POST_TYPE ),
		'rewrite' => 'service'
	),
	'testimonials' => array(
		'title' => __( 'Testimonial', STM_POST_TYPE ),
		'plural_title' => __( 'Testimonials', STM_POST_TYPE ),
		'rewrite' => 'testimonial'
	),
	'sidebars' => array(
		'title' => __( 'Sidebar', STM_POST_TYPE ),
		'plural_title' => __( 'Sidebars', STM_POST_TYPE ),
		'rewrite' => 'sidebar'
	),
	'vacancies' => array(
		'title' => __( 'Vacancy', STM_POST_TYPE ),
		'plural_title' => __( 'Vacancies', STM_POST_TYPE ),
		'rewrite' => 'vacancy'
	)
);

$stm_post_types_options = wp_parse_args( $options, $defaultPostTypesOptions );

STM_PostType::registerPostType( 'project', $stm_post_types_options['projects']['title'], array( 'pluralTitle' => $stm_post_types_options['projects']['plural_title'], 'menu_icon' => 'dashicons-building', 'rewrite' => array( 'slug' => $stm_post_types_options['projects']['rewrite'] ), 'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ) ) );
STM_PostType::addTaxonomy( 'project_category', __( 'Categories', STM_POST_TYPE ), 'project' );
STM_PostType::registerPostType( 'service', $stm_post_types_options['services']['title'], array( 'pluralTitle' => $stm_post_types_options['services']['plural_title'], 'menu_icon' => 'dashicons-lightbulb', 'rewrite' => array( 'slug' => $stm_post_types_options['services']['rewrite'] ), 'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ) ) );
STM_PostType::registerPostType( 'testimonial', $stm_post_types_options['testimonials']['title'], array( 'pluralTitle' => $stm_post_types_options['testimonials']['plural_title'], 'menu_icon' => 'dashicons-testimonial', 'rewrite' => array( 'slug' => $stm_post_types_options['testimonials']['rewrite'] ), 'supports' => array( 'title', 'thumbnail', 'excerpt' ), 'exclude_from_search' => true, 'publicly_queryable' => false ) );
STM_PostType::addTaxonomy( 'testimonial_category', __( 'Categories', STM_POST_TYPE ), 'testimonial' );
STM_PostType::registerPostType( 'sidebar', $stm_post_types_options['sidebars']['title'], array( 'pluralTitle' => $stm_post_types_options['sidebars']['plural_title'], 'menu_icon' => 'dashicons-schedule', 'rewrite' => array( 'slug' => $stm_post_types_options['sidebars']['rewrite'] ), 'supports' => array( 'title', 'editor' ), 'exclude_from_search' => true, 'publicly_queryable' => false ) );
STM_PostType::registerPostType( 'vacancy', $stm_post_types_options['vacancies']['title'], array( 'pluralTitle' => $stm_post_types_options['vacancies']['plural_title'], 'menu_icon' => 'dashicons-id', 'rewrite' => array( 'slug' => $stm_post_types_options['vacancies']['rewrite'] ), 'supports' => array( 'title', 'editor' ) ) );

function stm_plugin_styles() {
    $plugin_url =  plugins_url('', __FILE__);

    wp_enqueue_style( 'admin-styles', $plugin_url . '/assets/css/admin.css', null, null, 'all' );

    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');

    wp_enqueue_style( 'stmcss-datetimepicker', $plugin_url . '/assets/css/jquery.stmdatetimepicker.css', null, null, 'all' );
    wp_enqueue_script( 'stmjs-datetimepicker', $plugin_url . '/assets/js/jquery.stmdatetimepicker.js', array( 'jquery' ), null, true );

    wp_enqueue_media();
}

add_action( 'admin_enqueue_scripts', 'stm_plugin_styles' );

add_action('plugins_loaded', 'stm_plugin_setup');

function stm_plugin_setup(){

    $plugin_url =  plugins_url('', __FILE__);

    load_plugin_textdomain( 'stm_post_type', false, $plugin_url . '/languages' );

}

add_action( 'admin_menu', 'stm_register_post_types_options_menu' );

if( ! function_exists( 'stm_register_post_types_options_menu' ) ){
	function stm_register_post_types_options_menu(){
		add_submenu_page( 'tools.php', __('STM Post Types', STM_POST_TYPE), __('STM Post Types', STM_POST_TYPE), 'manage_options', 'stm_post_types', 'stm_post_types_options' );
	}
}

if( ! function_exists( 'stm_post_types_options' ) ){
	function stm_post_types_options(){

		if ( ! empty( $_POST['stm_post_types_options'] ) ) {
			update_option( 'stm_post_types_options', $_POST['stm_post_types_options'] );
		}

		$options = get_option('stm_post_types_options');

		$defaultPostTypesOptions = array(
			'projects' => array(
				'title' => __( 'Project', STM_POST_TYPE ),
				'plural_title' => __( 'Projects', STM_POST_TYPE ),
				'rewrite' => 'project'
			),
			'services' => array(
				'title' => __( 'Service', STM_POST_TYPE ),
				'plural_title' => __( 'Services', STM_POST_TYPE ),
				'rewrite' => 'service'
			),
			'testimonials' => array(
				'title' => __( 'Testimonial', STM_POST_TYPE ),
				'plural_title' => __( 'Testimonials', STM_POST_TYPE ),
				'rewrite' => 'testimonial'
			),
			'sidebars' => array(
				'title' => __( 'Sidebar', STM_POST_TYPE ),
				'plural_title' => __( 'Sidebars', STM_POST_TYPE ),
				'rewrite' => 'sidebar'
			),
			'vacancies' => array(
				'title' => __( 'Vacancy', STM_POST_TYPE ),
				'plural_title' => __( 'Vacancies', STM_POST_TYPE ),
				'rewrite' => 'vacancy'
			)
		);

		$options = wp_parse_args( $options, $defaultPostTypesOptions );

		echo '
			<div class="wrap">
		        <h2>' . __( 'Custom Post Type Renaming Settings', STM_POST_TYPE ) . '</h2>

		        <form method="POST" action="">
		            <table class="form-table">
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="projects_title">' . __( '"Projects" title (admin panel tab name)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="projects_title" name="stm_post_types_options[projects][title]" value="' . $options['projects']['title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="projects_plural_title">' . __( '"Projects" plural title', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="projects_plural_title" name="stm_post_types_options[projects][plural_title]" value="' . $options['projects']['plural_title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="projects_rewrite">' . __( '"Projects" rewrite (URL text)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="projects_rewrite" name="stm_post_types_options[projects][rewrite]" value="' . $options['projects']['rewrite'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top"><th scope="row"></th></tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="services_title">' . __( '"Services" title (admin panel tab name)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="services_title" name="stm_post_types_options[services][title]" value="' . $options['services']['title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="services_plural_title">' . __( '"Services" plural title', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="services_plural_title" name="stm_post_types_options[services][plural_title]" value="' . $options['services']['plural_title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="services_rewrite">' . __( '"Services" rewrite (URL text)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="services_rewrite" name="stm_post_types_options[services][rewrite]" value="' . $options['services']['rewrite'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top"><th scope="row"></th></tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="testimonials_title">' . __( '"Testimonials" title (admin panel tab name)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="testimonials_title" name="stm_post_types_options[testimonials][title]" value="' . $options['testimonials']['title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="testimonials_plural_title">' . __( '"Testimonials" plural title', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="testimonials_plural_title" name="stm_post_types_options[testimonials][plural_title]" value="' . $options['testimonials']['plural_title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="testimonials_rewrite">' . __( '"Testimonials" rewrite (URL text)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="testimonials_rewrite" name="stm_post_types_options[testimonials][rewrite]" value="' . $options['testimonials']['rewrite'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top"><th scope="row"></th></tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="sidebars_title">' . __( '"Sidebars" title (admin panel tab name)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="sidebars_title" name="stm_post_types_options[sidebars][title]" value="' . $options['sidebars']['title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="sidebars_plural_title">' . __( '"Sidebars" plural title', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="sidebars_plural_title" name="stm_post_types_options[sidebars][plural_title]" value="' . $options['sidebars']['plural_title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="sidebars_rewrite">' . __( '"Sidebars" rewrite (URL text)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="sidebars_rewrite" name="stm_post_types_options[sidebars][rewrite]" value="' . $options['sidebars']['rewrite'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top"><th scope="row"></th></tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="vacancies_title">' . __( '"Vacancies" title (admin panel tab name)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="vacancies_title" name="stm_post_types_options[vacancies][title]" value="' . $options['vacancies']['title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="vacancies_plural_title">' . __( '"Vacancies" plural title', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="vacancies_plural_title" name="stm_post_types_options[vacancies][plural_title]" value="' . $options['vacancies']['plural_title'] . '"  size="25" />
		                    </td>
		                </tr>
		                <tr valign="top">
		                    <th scope="row">
		                        <label for="vacancies_rewrite">' . __( '"Vacancies" rewrite (URL text)', STM_POST_TYPE ) . '</label>
		                    </th>
		                    <td>
		                        <input type="text" id="vacancies_rewrite" name="stm_post_types_options[vacancies][rewrite]" value="' . $options['vacancies']['rewrite'] . '"  size="25" />
		                    </td>
		                </tr>
		            </table>
		            <p>' . __( "NOTE: After you change the rewrite field values, you'll need to refresh permalinks under Settings -> Permalinks", STM_POST_TYPE ) . '</p>
		            <br/>
		            <p>
						<input type="submit" value="' . __( 'Save settings', STM_POST_TYPE ) . '" class="button-primary"/>
					</p>
		        </form>
		    </div>
		';
	}
}