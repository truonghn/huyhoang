<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newsmag
 */
// Grab the current author
$curauth             = get_userdata( $post->post_author );
$breadcrumbs_enabled = get_theme_mod( 'newsmag_enable_post_breadcrumbs', true );
?>
<div
  class="row newsmag-article-post <?php echo ( ! $breadcrumbs_enabled && ! $image_in_content ) ? 'newsmag-margin-top' : '' ?>">
  <div
    class="<?php echo $author ? 'col-md-9' : 'col-md-12'; ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="entry-content">
        <div class="newsmag-post-meta">
           <span
            class="date-post">Đăng ngày </span> <?php newsmag_posted_on( 'date' ); ?>
            <span
            class="social-sharing">Chia sẻ thông tin: </span> 
            <a class="facebook-sharing" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank">&nbsp</a>
            <a class="google-sharing" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>" target="_blank">&nbsp</a>
        </div><!-- .entry-meta -->
        <div class="newsmag-post-meta">
          <span class="bds-location"><?php echo get_field('position'); ?></span>  
        </div>
        <?php if ( is_single() ) {
          the_content();
        } else {
          $excerpt = get_the_excerpt();
          $length  = (int) get_theme_mod( 'newsmag_excerpt_length', 25 );
          ?>
          <p>
            <?php echo wp_kses_post( wp_trim_words( $excerpt, $length ) ); ?>
          </p>
        <?php } ?>
      </div>
    </article><!-- #post-## -->
  </div>
</div>


