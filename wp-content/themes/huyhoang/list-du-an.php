<?php /* Template Name: list-du-an */ ?>
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newsmag
 */

get_header();
$image = get_custom_header();
$title = '';
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
while ( have_posts() ) : the_post();
  $img   = get_the_post_thumbnail_url();
  $title = get_the_title();
endwhile;

if ( empty( $img ) ) {
  $img = get_custom_header();
  $img = $img->url;
}

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
    <div id="primary" class="content-area">

      <main id="main" class="site-main row" role="main">
        <div class="col-md-9">
        <div class="list-duan">
        <h3>Dự án</h3>
        <span class="line-break"></span>
        <?php
        $list_duan = list_bds('du_an', array(), array(), 10, $paged, TRUE);
        $max_num_pages = $list_duan['max_num_pages'];
        unset($featured_duan['max_num_pages']);
        foreach ($list_duan as $du_an) : 
           print huyhoang_du_an_item($du_an);
        endforeach;
        ?>
        <?php huyhoang_pagination($max_num_pages, 5, $paged); ?>
        </div>
        </div>
        <div class="col-md-3">
          <div class="featured-duan">
          <h3>Dự án nổi bật</h3>
          <span class="line-break"></span>
          <?php
          $featured_duan = list_bds('du_an', array(), array('is_featured' => 'yes'));
          foreach ($featured_duan as $du_an_featured) : 
           print huyhoang_du_an_featured($du_an_featured);
          endforeach;
          ?>
          </div>
          
        </div>

      </main><!-- #main -->
    </div><!-- #primary -->
  </div>
</div>
<?php
get_footer();
?>

<div class=""></div>