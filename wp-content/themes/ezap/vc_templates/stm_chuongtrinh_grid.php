<?php
extract( shortcode_atts( array(
	'css' => '',
	'number_of_post' => 4,
	'category' => 'all',
	'fullwidth' => ''
), $atts ) );
wp_enqueue_script( 'isotope' );

$id = rand();

$project_categories_array = get_terms( 'loai-chuong-trinh' );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$class = 'chuongtrinh_grid_wrapper';
if( $fullwidth ){ 
	$class .= ' container'; 
}else{  
	$class .= ' compact'; 
}


?>
<div class="<?php echo esc_attr( $class . $css_class ); ?>">
	<?php
		$args = array(
				'post_type' => 'chuong_trinh',
				'posts_per_page' => $number_of_post
			);
		if( $category != 'all' ){
			$args['loai-chuong-trinh'] = $category;
		}
		$projects = new WP_Query($args);
		$index = 0;
	?>
	<?php if( $projects->have_posts() ){ ?>
		<div id="chuongtrinh_grid_<?php echo esc_attr( $id ); ?>" class="chuongtrinh_grid clearfix">
			<?php while ( $projects->have_posts() ) { $projects->the_post(); ?>
				<?php
					$index++;
					$project_class = '';
					$term_list = wp_get_post_terms( get_the_ID(), 'loai-chuong-trinh' );
					if( $term_list ){
						foreach ( $term_list as $term ) {
							$project_class .= ' ' . $term->slug;
						}
					}
				?>
				<div class="col-sm-6 chuongtrinh all<?php echo esc_attr( $project_class ); ?>">
					<div class="chuongtrinh_wr">
						<div class="featured-image col-xs-5 col-sm-12 col-md-5 col-lg-5">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(270, 270), ['class' => 'img-responsive responsive--full'] ); ?></a>
						</div>
						<div class="chuongtrinh-summary col-xs-7 col-sm-12 col-md-7 col-lg-7">
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<?php the_excerpt(); ?>
							<?php if ( get_post_meta( get_the_ID(), '_thoi_gian', true ) != '' ) {  ?>
								<p><strong><i class="fa fa-clock-o" aria-hidden="true"></i> </strong><?php echo get_post_meta( get_the_ID(), '_thoi_gian', true ); ?></p>
							<?php } ?>
							<?php if ( get_post_meta( get_the_ID(), '_hoc_vien', true ) != '' ) {  ?>
								<p><strong><i class="fa fa-users" aria-hidden="true"></i> </strong><?php echo get_post_meta( get_the_ID(), '_hoc_vien', true ); ?></p>
							<?php } ?>
							<a href="<?php the_permalink(); ?>" class="button view_more"><?php _e( 'Chi tiết', 'bestbuild' ); ?></a>
						</div>
					</div>
				</div>
				<?php if($index%2 == 0) : ?>
					<div class="clearfix"></div>
				<?php endif; ?>
			<?php } wp_reset_query(); ?>
		</div>
	<?php } ?>
</div>