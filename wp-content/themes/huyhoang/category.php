<?php
/**
 * The template for displaying archive pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 * @package Newsmag
 */

get_header();
$breadcrumbs_enabled = get_theme_mod( 'newsmag_enable_post_breadcrumbs', true );
if ( $breadcrumbs_enabled ) { ?>
<div class="container newsmag-breadcrumbs-container">
  <div class="row breadcrumbs-row">
    <div class="col-xs-12">
      <?php newsmag_breadcrumbs(); ?>
    </div>
  </div>
</div>
<?php } ?>
<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <?php
      $layout = get_theme_mod( 'newsmag_blog_layout', 'right-sidebar' ); ?>

      <?php if ( $layout === 'left-sidebar' ): ?>
        <?php get_sidebar( 'sidebar' ); ?>
      <?php endif; ?>

      <div id="primary"
           class="newsmag-content newsmag-archive-page col-xs-12">
        <main id="main" class="site-main" role="main">
          <div class="row">
          <?php

          if ( have_posts() ) :

            /* Start the Loop */
            while ( have_posts() ) : the_post();
              /*
               * Include the Post-Format-specific template for the content.
               * If you want to override this in a child theme, then include a file
               * called content-___.php (where ___ is the Post Format name) and that will be used instead.
               */
              print huyhoang_bds_item(get_the_id());
              //get_template_part( 'template-parts/content', get_post_format() );

            endwhile;
            ?>
          </div>
          <?php
          else :
            echo '<div class="row">';
            get_template_part( 'template-parts/content', 'none' );
            echo '</div>';
          endif;
          ?>
        </main><!-- #main -->
        <?php the_posts_pagination( array( 'prev_text' => 'prev', 'next_text' => 'next' ) ); ?>
      </div><!-- #primary -->
      <?php if ( $layout === 'right-sidebar' ): ?>
        <?php get_sidebar( 'sidebar' ); ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php get_footer();
