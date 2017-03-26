<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Newsmag
 */

get_header();
$image            = get_custom_header();
$img              = $image->url;
$image_in_content = get_theme_mod( 'newsmag_featured_image_in_content', true );
if ( ! $image_in_content ) {
  while ( have_posts() ) : the_post();
    $img = get_the_post_thumbnail_url();
  endwhile;

  if ( empty( $img ) ) {
    $img = get_custom_header();
    $img = $img->url;
  }
}
$title = get_the_title( get_the_ID() );
?>
<?php
$breadcrumbs_enabled = get_theme_mod( 'newsmag_enable_post_breadcrumbs', true );
if ( $breadcrumbs_enabled ) { ?>
  <div class="container newsmag-breadcrumbs-container">
    <div class="row breadcrumbs-row ">
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

      <div id="primary" class="content-area col-xs-12 newsmag-sidebar">
        <h3><?php echo esc_html( $title ) ?></h3>
        <main id="main" class="site-main" role="main">
          <?php
          while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/content', 'bds' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
              comments_template();
            endif;

          endwhile; // End of the loop.
          ?>

        </main><!-- #main -->
      </div><!-- #primary -->
      <?php if ( $layout === 'right-sidebar' ): ?>
        <?php get_sidebar( 'sidebar' ); ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
get_footer();
