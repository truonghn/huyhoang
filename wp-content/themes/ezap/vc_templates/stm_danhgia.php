<?php
extract( shortcode_atts( array(
	'css'         => '',
	'style'		  => '',
	'count'       => 8,
	'count_per_row' => 4,
	'category'    => 'all'
), $atts ) );

wp_enqueue_script( 'slick.min.js' );
wp_enqueue_style( 'slick.css' );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$args = array( 
	'post_type' => 'testimonial',
	'posts_per_page' => $count
);
if( $category != 'all' ){
	$args['testimonial_category'] = $category;
}
$testimonials = new WP_Query( $args );
?>

<?php
if( $testimonials->have_posts() ){ ?>
	<?php if ($style != 'grid') : ?>
		<?php $id = time();?>
			<div id="testimonials_carousel-<?php echo esc_attr($id) ?>" class="testimonials_module testimonials_carousel">
			<?php while( $testimonials->have_posts() ) {
				$testimonials->the_post();?>
				<div class="testimonials_module<?php echo esc_attr( $css_class ); ?>">
					<div class="testimonial-info clearfix">
						<div class="testimonial-image"><?php echo get_the_post_thumbnail( get_the_ID(), 'thumb-100x100' ); ?></div>
						<div class="testimonial-text">
							<div class="testimonial"><?php the_excerpt(); ?></div>
							<div class="name"><?php the_title(); ?></div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				"use strict";
				var slick_<?php echo esc_attr( $id ) ?> = $("#testimonials_carousel-<?php echo esc_attr( $id ) ?>");
				slick_<?php echo esc_attr( $id ) ?>.slick({
					dots: true,
					infinite: true,
					arrows: false,
					autoplaySpeed: 5000,
					autoplay: true,
					slidesToShow: <?php echo $count_per_row; ?>,
					cssEase: "cubic-bezier(0.455, 0.030, 0.515, 0.955)",
					responsive: [
					  { 
				        breakpoint: 991,
				        settings: {
				            dots: true,
				            arrows: false,
				            infinite: true,
				            slidesToShow: 3,
				            slidesToScroll: 3
				        } 
				      },
					  { 
				        breakpoint: 767,
				        settings: {
				            dots: true,
				            arrows: false,
				            infinite: true,
				            slidesToShow: 2,
				            slidesToScroll: 2
				        } 
				      },
				      { 
				        breakpoint: 500,
				        settings: {
				            dots: true,
				            arrows: false,
				            infinite: true,
				            slidesToShow: 1,
				            slidesToScroll: 1
				        } 
				      }
				    ]
				});
			});
		</script>
	<?php else : ?>
		<?php
		$col_class = "col-md-3 col-sm-4";
		if ($count_per_row == 3) {
			$col_class = "col-sm-4";
		} elseif ($count_per_row == 2) {
			$col_class = "col-sm-6";
		}
		$i = 1
		?>
		<div class="<?php echo esc_attr( 'testimonials_grid_wrapper' . $css_class ); ?>">
			<div class="testimonials_grid clearfix">
				<?php while ( $testimonials->have_posts() ) { $testimonials->the_post(); ?>
					<?php
						$project_class = '';
						$term_list = wp_get_post_terms( get_the_ID(), 'project_category' );
						if( $term_list ){
							foreach ( $term_list as $term ) {
								$project_class .= ' ' . $term->slug;
							}
						}
					?>
					<div class="<?php echo $col_class; ?>">
						<div class="testimonial-info clearfix">
							<div class="testimonial-image"><?php echo get_the_post_thumbnail( get_the_ID(), 'thumb-100x100' ); ?></div>
							<div class="testimonial-text">
								<div class="testimonial"><?php the_excerpt(); ?></div>
								<div class="name"><?php the_title(); ?></div>
							</div>
						</div>
					</div>
					<?php if ($i%4 == 0) { ?>
					<div class="clearfix hidden-sm"></div>
					<?php } ?>
					<?php if ($i%3 == 0) { ?>
					<div class="clearfix hidden-md hidden-lg"></div>
					<?php } ?>
					<?php $i++; ?>
				<?php } ?>
			</div>
		</div>
	<?php endif; ?>
	<?php wp_reset_query(); ?>
<?php } ?>
