<?php /* Template Name: search-bds */ ?>
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

while ( have_posts() ) : the_post();
  $img   = get_the_post_thumbnail_url();
  $title = get_the_title();
endwhile;

if ( empty( $img ) ) {
  $img = get_custom_header();
  $img = $img->url;
}
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
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
        <div class="container search-box">
          <h3 class="search-title"><?php echo esc_html( $title ) ?></h3>
          <form action="/search" method="get" name="seach_bds_form">
              <div class="filter-loai-bds filter-bds">
              <?php echo huyhoang_generate_select_fields('bds_type', array(array('value'=> '102', 'name' => 'Cần Bán'),array('value' => '103', 'name' => 'Cho Thuê'))); ?>
              </div>
              <div class="filter-bds">
              <?php 
                $cats = array(
                  array(
                    'value' => '',
                    'name'  => 'Loại BĐS',
                  ),
                  array(
                    'value' => '159',
                    'name'  => 'Căn hộ cao cấp',
                  ),
                  array(
                    'value' => '155',
                    'name'  => 'Đất nền',
                  ),
                  array(
                    'value' => '157',
                    'name'  => 'Nhà Riêng',
                  ),

                );
                echo huyhoang_generate_select_fields('bds_cat', $cats);
              ?>
              </div>
              <div class="filter-bds">
              <?php 
                $quan = array(
                  array(
                    'value' => '',
                    'name'  => 'Khu Vực',
                  ),
                  array(
                    'value' => 'Hoà Vang',
                    'name'  => 'Hoà Vang',
                  ),
                  array(
                    'value' => 'Hải Châu',
                    'name'  => 'Hải Châu',
                  ),
                  array(
                    'value' => 'Cẩm Lệ',
                    'name'  => 'Cẩm Lệ',
                  ),
                  array(
                    'value' => 'Liên Chiểu',
                    'name'  => 'Liên Chiểu',
                  ),
                );
                echo huyhoang_generate_select_fields('bds_quan', $quan);
              ?>
              </div>  
              <div class="filter-bds">
                <?php 
                  $subjects = array(
                    array(
                      'value' => '',
                      'name'  => 'Diện Tích'
                    ),
                    array(
                      'value' => '1',
                      'name'  => '50 - 100'
                    ),
                    array(
                      'value' => '2',
                      'name'  => '100 - 200'
                    ),
                    array(
                      'value' => '3',
                      'name'  => '200 - 3003'
                    ),
                    array(
                      'value' => '4',
                      'name'  => '300 - 400'
                    ),array(
                      'value' => '5',
                      'name'  => '>500'
                    ),
                  );
                  print huyhoang_generate_select_fields('bds_subject', $subjects);
                ?>
              </div>  
              <div class="filter-bds price">
                <?php 
                  $prices = array(
                    array(
                      'value' => '',
                      'name'  => 'Mức giá'
                    ),
                    array(
                      'value' => '1',
                      'name'  => '< 500'
                    ),
                    array(
                      'value' => '2',
                      'name'  => '500 - 700'
                    ),
                    array(
                      'value' => '3',
                      'name'  => '700 - 1 tỉ'
                    ),
                    array(
                      'value' => '4',
                      'name'  => '1 ti - 3 tỉ'
                    ),array(
                      'value' => '5',
                      'name'  => '>3 tỉ'
                    ),
                  );
                  print huyhoang_generate_select_fields('bds_price', $prices);
                ?>
              </div> 
              <div class="filter-bds rent-price">
                <?php 
                  $rent_prices = array(
                    array(
                      'value' => '',
                      'name'  => 'Mức giá'
                    ),
                    array(
                      'value' => '1',
                      'name'  => '< 1 trieu'
                    ),
                    array(
                      'value' => '2',
                      'name'  => '1 trieu - 2 trieu'
                    ),
                    array(
                      'value' => '3',
                      'name'  => '2 trieu - 3 trieu'
                    ),
                    array(
                      'value' => '4',
                      'name'  => '3 trieu - 4 trieu'
                    ),array(
                      'value' => '5',
                      'name'  => '>4 trieu'
                    ),
                  );
                  print huyhoang_generate_select_fields('bds_rent_price', $rent_prices);
                ?>
              </div>  
              <div class="filter-bds">
                <?php 
                  $bds_room = array(
                    array(
                      'value' => '',
                      'name'  => 'Số Phòng Ngủ'
                    ),
                    array(
                      'value' => '1',
                      'name'  => '1'
                    ),
                    array(
                      'value' => '2',
                      'name'  => '2'
                    ),
                    array(
                      'value' => '3',
                      'name'  => '3'
                    ),
                  );
                  print huyhoang_generate_select_fields('bds_bedroom', $bds_room);
                ?>
              </div> 
              <div class="filter-bds">
                <?php 
                  $bds_direction = array(
                    array(
                      'value' => '',
                      'name'  => 'Hướng nhà'
                    ),
                    array(
                      'value' => 'Tây Bắc',
                      'name'  => 'Tây Bắc'
                    ),
                    array(
                      'value' => 'Đông Nam',
                      'name'  => 'Đông Nam'
                    ),
                  );
                  print huyhoang_generate_select_fields('bds_direction', $bds_direction);
                ?>
              </div>  
              <div class="filter-bds hidden">
                <?php 
                  $bds_sort = array(
                    array(
                      'value' => '1',
                      'name'  => 'Mới Nhất'
                    ),
                    array(
                      'value' => '2',
                      'name'  => 'Giá từ thấp đến cao'
                    ),
                    array(
                      'value' => '3',
                      'name'  => 'Giá từ cao đến thấp'
                    ),
                    array(
                      'value' => '4',
                      'name'  => 'Diện tích lớn nhất'
                    ),
                    array(
                      'value' => '5',
                      'name'  => 'Diện tích nhỏ nhất'
                    ),
                  );
                  print huyhoang_generate_select_fields('bds_sort', $bds_sort);
                ?>
              </div>  
              <input class="btn-search" type="submit" value="Tìm kiếm" />
          </form>
        </div>
        
        <!-- search result -->
        <?php
          $bds_searched = search_bds($_GET, 12, $paged);
          $max_num_pages = $bds_searched['max_num_pages'];
          $total = $bds_searched['total'];
          unset($bds_searched['max_num_pages'], $bds_searched['total']);
        ?>
        <div class="bds-ban-noi-bat">
          <div class='container'>
            <div class="results">
              <div class="pull-left"><h3 class="num-result">có <?php echo $total; ?> kết quả</h3></div>
              <div class="sort-order pull-right">
                <span>Sắp xếp theo:</span>
                <?php print huyhoang_generate_select_fields('sort_result', $bds_sort); ?>
              </div>
            </div>
            <div class='row'>
            <?php 
              
              foreach ($bds_searched as $bds) : 
                 print huyhoang_bds_item($bds);
               endforeach;
            ?>
            </div>
            <?php huyhoang_pagination($max_num_pages, 5, $paged); ?>
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