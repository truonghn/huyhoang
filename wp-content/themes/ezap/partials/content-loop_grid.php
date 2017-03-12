<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="thuvien-summary">
		<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<?php the_excerpt(); ?>
	</div>
</li>