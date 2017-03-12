<?php stm_get_header(); ?>

	<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'partials/content' );

		}
	?>

<?php get_footer(); ?>
<!-- Modal -->
<div id="dang-ky-luyen-am" class="modal contact-modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h2 class="modal-title text-center" id="myModalLabel">Đăng ký<br>luyện âm miễn phí</h2>
			</div>
			<div class="modal-body">
				<?php echo do_shortcode( '[contact-form-7 id="2023" title="Đăng ký luyện âm miễn phí"]' ); ?>
			</div>
		</div>
	</div>
</div>
