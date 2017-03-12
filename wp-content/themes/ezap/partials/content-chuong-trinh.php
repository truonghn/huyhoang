<?php $vc_status = get_post_meta( get_the_ID() , '_wpb_vc_js_status', true); ?>
<?php $category_detail = get_the_terms(get_the_ID(),'loai-chuong-trinh' );  ?>
<?php if( $vc_status != 'false' && $vc_status == true ){ ?>
	<div class="content-area">
		<?php get_template_part( 'partials/title_box' ); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
		    <div class="entry-content">
		        <?php the_content(); ?>
		        <?php
		        wp_link_pages( array(
		            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bestbuild' ) . '</span>',
		            'after'       => '</div>',
		            'link_before' => '<span>',
		            'link_after'  => '</span>',
		            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'bestbuild' ) . ' </span>%',
		            'separator'   => '<span class="screen-reader-text">, </span>',
		        ) );
		        ?>
		    </div>
		
		</article>
	</div>
<?php }else{ ?>
	<?php 
		$blog_sidebar_position = stm_option( 'blog_sidebar_position', 'none' );
		$content_before = $content_after =  $sidebar_before = $sidebar_after = '';

		if( $blog_sidebar_position == 'right' ) {
			$content_before .= '<div class="row">';
			$content_before .= '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">';
			$content_before .= '<div class="col_in __padd-right __three-cols">';

			$content_after .= '</div>'; // col_in
			$content_after .= '</div>'; // col
			$sidebar_before .= '<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">';
			// .sidebar-area
			$sidebar_after .= '</div>'; // col
			$sidebar_after .= '</div>'; // row
		}

		if( $blog_sidebar_position == 'left' ) {
			$content_before .= '<div class="row">';
			$content_before .= '<div class="col-lg-9 col-lg-push-3 col-md-9 col-md-push-3 col-sm-12 col-xs-12">';
			$content_before .= '<div class="col_in __padd-left __three-cols">';

			$content_after .= '</div>'; // col_in
			$content_after .= '</div>'; // col
			$sidebar_before .= '<div class="col-lg-3 col-lg-pull-9 col-md-3 col-md-pull-9 hidden-sm hidden-xs">';
			// .sidebar-area
			$sidebar_after .= '</div>'; // col
			$sidebar_after .= '</div>'; // row
		}		
	?>
	<div class="content-area">
		<div class="entry-header clearfix" >
	        <div class="entry-title-left">
	            <div class="entry-title">
	                <h1 class="h2" style="color: #fff;">Chương trình học</h1>
	            </div>
	        </div>
	    </div>
		<?php echo $content_before; ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			    <div class="entry-content">
					<?php
			    	$images = explode(',', get_field('gallery'));
			    	?>
			    	<?php if( $images ): ?>
				    	<div class="col-sm-6">
						    <div id="slider" class="flexslider">
						        <ul class="slides">
						            <?php foreach( $images as $image_id ): ?>
						            	<?php 
						            	$image_attributes = wp_get_attachment_image_src( $image_id, array('600', '600') ); 
						            	?>
						                <li data-thumb="<?php echo $image_attributes[0]; ?>">
									      	<img src="<?php echo $image_attributes[0]; ?>" class="img-responsive">
									    </li>
						            <?php endforeach; ?>
						        </ul>
						    </div>
						</div>
					<?php else : ?>
						<?php if( has_post_thumbnail() ){ ?>
			    			<div class="col-sm-6">
								<div class="post_thumbnail">
									<?php the_post_thumbnail('large', ['class' => 'img-responsive responsive--full']); ?>
								</div>
							</div>
						<?php } ?>
					<?php endif; ?>
		    		<div class="col-sm-6">
		    			<div class="stm_post_info">
							<h1 class="h2"><?php the_title(); ?></h1>
							<?php if( get_the_content() ){ ?>
								<div class="text_block clearfix">
									<?php the_content(); ?>
								</div>
							<?php } ?>
							<div class="ezap-chuong-trinh-chi-tiet clearfix">
								<?php if ( get_post_meta( get_the_ID(), '_thoi_gian', true ) != '' ) {  ?>
									<p><strong><i class="fa fa-clock-o" aria-hidden="true"></i> Khóa học kéo dài: </strong><?php echo get_post_meta( get_the_ID(), '_thoi_gian', true ); ?></p>
								<?php } ?>
								<?php if ( get_post_meta( get_the_ID(), '_hoc_vien', true ) != '' ) {  ?>
									<p><strong><i class="fa fa-users" aria-hidden="true"></i> Số học viên: </strong><?php echo get_post_meta( get_the_ID(), '_hoc_vien', true ); ?></p>
								<?php } ?>
								<?php if ( get_post_meta( get_the_ID(), '_hoc_phi', true ) != '' ) {  ?>
									<p><strong><i class="fa fa-usd" aria-hidden="true"></i> Học phí: </strong><?php echo get_post_meta( get_the_ID(), '_hoc_phi', true ); ?></p>
								<?php } ?>
								<p>* Cam kết đầu ra khi đi học và làm bài tập đầy đủ 100%</p>
								<p>* Kiểm tra đầu vào miễn phí 100%. <a href="#">Kiểm tra ngay.</a></p>
								<a class="button" href="#" data-toggle="modal" data-target="#dang-ky-luyen-am">ĐĂNG KÝ HỌC NGAY</a>
							</div>
						</div>
		    		</div>
		    		<div class="clearfix"></div>
		    		<div class="col-sm-6">
		    			<div class="noi-dung-hoc">
		    				<h3>Nội dung học</h2>
		    				<?php echo htmlspecialchars_decode(get_post_meta( get_the_ID(), '_noi_dung_hoc', true )); ?>
		    			</div>
		    		</div>
		    		<div class="col-sm-6">
		    			<?php
							$args1 = array(
									'post_type' => 'testimonial',
									'posts_per_page' => 2, 
								);
							if( !empty($category_detail) ){
								$args1['loai-chuong-trinh'] = $category_detail[0]->slug;
							}
							$testimonials = new WP_Query($args1);
						?>
						<?php if( $testimonials->have_posts() ){ ?>
							<div class="hocvien-danhgia">
								<h3>Học viên khóa học nói gì?</h3>
								<?php while ( $testimonials->have_posts() ) { $testimonials->the_post(); ?>
									<div class="danhgia">
										<blockquote>
											<i class="fa fa-quote-left" aria-hidden="true"></i>
											<?php the_excerpt(); ?>
											<h4><?php the_title(); ?></h4>
										</blockquote>
									</div>
								<?php } wp_reset_query(); ?>
							</div>
						<?php } ?>
		    		</div>
					<?php
				        wp_link_pages( array(
				            'before'      => '<div class="page-links"><label>' . __( 'Pages:', 'bestbuild' ) . '</label>',
				            'after'       => '</div>',
				            'link_before' => '<span>',
				            'link_after'  => '</span>',
				            'pagelink'    => '%',
				            'separator'   => '',
				        ) );
			        ?>
					<div class="stm_post_tags">
						<?php if( $tags = wp_get_post_tags( get_the_ID() ) ){ ?>
							<?php foreach( $tags as $tag ){ ?>
								<a href="<?php echo get_tag_link( $tag ); ?>"><?php echo balanceTags( $tag->name, true ); ?></a>
							<?php } ?>
						<?php } ?>
					</div>
			        <?php if ( comments_open() || get_comments_number() ) { ?>
						<div class="stm_post_comments">
							<?php comments_template(); ?>
						</div>
					<?php } ?>
			    </div>
			
			</article>
		<?php echo $content_after; ?>
		<?php echo $sidebar_before; ?>
			<?php if( $blog_sidebar_position != 'none' ) { ?>
				<div class="sidebar-area">
					<?php get_sidebar(); ?>
				</div>
			<?php } ?>
		<?php echo $sidebar_after; ?>
	</div>
<?php } ?>
<?php
	$args = array(
			'post_type' => 'chuong_trinh',
			'posts_per_page' => 2, 
		);
	if( !empty($category_detail) ){
		$args['loai-chuong-trinh'] = $category_detail[0]->slug;
	}
	$relateds = new WP_Query($args);
?>
<?php if( $relateds->have_posts() ){ ?>
	<div class="chuongtrinh-lien-quan chuongtrinh_grid clearfix">
		<div class="col-sm-12"><h2>Chương trình học liên quan</h2></div>
		<?php while ( $relateds->have_posts() ) { $relateds->the_post(); ?>
			<div class="col-sm-6 chuongtrinh all">
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
		<?php } wp_reset_query(); ?>
	</div>
<?php } ?>