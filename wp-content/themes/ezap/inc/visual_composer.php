<?php
if ( function_exists( 'vc_map' ) ) {
	add_action( 'init', 'lanhtv_vc_stm_elements' );
}

function lanhtv_vc_stm_elements(){
	$testimonial_categories_array = get_terms( 'testimonial_category' );
	$testimonial_categories = array(
		__( 'All', 'bestbuild' ) => 'all'
	);
	if( $testimonial_categories_array && ! is_wp_error( $testimonial_categories_array )  ){
		foreach( $testimonial_categories_array as $cat ){
			$testimonial_categories[$cat->name] = $cat->slug;
		}
	}

	$chuongtrinh_categories_array = get_terms( 'loai-chuong-trinh' );
	$chuongtrinh_categories = array(
		__( 'All', 'bestbuild' ) => 'all'
	);
	if( $chuongtrinh_categories_array && ! is_wp_error( $chuongtrinh_categories_array )  ){
		foreach( $chuongtrinh_categories_array as $cat ){
			$chuongtrinh_categories[$cat->name] = $cat->slug;
		}
	}

	vc_map( array(
		'name'        => __( 'Nhận xét học viên', 'ezap' ),
		'base'        => 'stm_danhgia',
		'icon'        => 'stm_testimonials',
		'category'    => __( 'STM', 'ezap' ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Count', 'ezap' ),
				'param_name' => 'count',
				'value' => 8
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Count Per Row', 'ezap' ),
				'param_name' => 'count_per_row',
				'value' => 4
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Category', 'ezap'),
				'param_name' => 'category',
				'value' => $testimonial_categories
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'ezap' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Slide', 'ezap' ) => 'carousel',
					__( 'Grid', 'ezap' ) => 'grid',
				)
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', 'ezap' ),
				'param_name' => 'css',
				'group' => __( 'Design options', 'ezap' )
			)
		)
	) );

	vc_map( array(
		'name'        => __( 'Chương trình Grid', 'bestbuild' ),
		'base'        => 'stm_chuongtrinh_grid',
		'category'    => __( 'STM', 'bestbuild' ),
		'params'      => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Category', 'bestbuild' ),
				'param_name' => 'category',
				'value' => $chuongtrinh_categories
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Number of post', 'ezap' ),
				'param_name' => 'number_of_post',
				'value' => 4
			),
			array(
				'type' => 'checkbox',
				'heading' => __('Full Width', 'bestbuild'),
				'param_name' => 'fullwidth',
				'value' => array(
					__( 'Yes', 'bestbuild' ) => 'yes'
				),
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', 'bestbuild' ),
				'param_name' => 'css',
				'group'      => __( 'Design options', 'bestbuild' )
			)
		)
	) );
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Stm_Danhgia extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Chuongtrinh_Grid extends WPBakeryShortCode {
	}
}