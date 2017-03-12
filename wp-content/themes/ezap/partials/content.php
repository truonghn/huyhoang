<?php $vc_status = get_post_meta( get_the_ID() , '_wpb_vc_js_status', true); ?>
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
		<?php get_template_part( 'partials/title_box' ); ?>
		<?php echo $content_before; ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			    <div class="entry-content">
			        <div class="stm_post_info">
						<h1 class="h3"><?php the_title(); ?></h1>
						<div class="stm_post_details clearfix">
							<ul class="clearfix">
								<li class="post_date"><span>Đăng ngày: <?php echo get_the_date(); ?></span></li>
								<li>Chia sẻ bải viết qua: <a href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&title=<?php the_title(); ?>"><i class="fa fa-facebook"></i></a><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
						<?php if( has_post_thumbnail() ){ ?>
							<div class="post_thumbnail">
								<?php the_post_thumbnail(); ?>
							</div>
						<?php } ?>
					</div>
					<?php if( get_the_content() ){ ?>
						<div class="text_block clearfix">
							<?php the_content(); ?>
						</div>
					<?php } ?>
					<div class="stm_post_details clearfix">
						<ul class="clearfix">
							<li class="post_date"><span>Đăng ngày: <?php echo get_the_date(); ?></span></li>
							<li>Chia sẻ bải viết qua: <a href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&title=<?php the_title(); ?>"><i class="fa fa-facebook"></i></a><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a></li>
						</ul>
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