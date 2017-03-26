<?php
/**
 * The template for displaying Front page.
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
get_header(); ?>
<!-- background homepage -->
<div class="main-bg">
  <span class="company-name">Toàn Huy Hoàng</span>
  <span class="company-slogan">Niềm Tin Vượt Thời Gian</span>
  <div class="search-bds-form">
    <!-- search form -->
    <form action="/search" method="get" name="seach-bds-form">
    <div class="filter-loai-bds filter-bds">
      <select name="bds_type">
        <option value=''>Loại Bất Động Sản</option>
        <option value='102'>Bất Động Sản Bán</option>
        <option value='103'>Bất Động Sản Cho Thuê</option>
      </select>
    </div>  
    <div class="filter-huyen filter-bds">
      <select name="bds_quan">
        <option value=''>Quận/Huyện</option>
        <?php foreach (huyhoang_load_quan() as $key => $value): ?>
        <option value='<?php echo $key; ?>'><?php echo $value; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="filter-phuong filter-bds">
      <select name="bds_phuong">
        <option value=''>Phường/Xã</option>
        <?php foreach (huyhoang_load_phuong() as $key => $value): ?>
        <option value='<?php echo $key; ?>'><?php echo $value; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
      <input class="btn-search" type="submit" value="&nbsp" />
    </form>
  </div>
</div>

<!-- bds can ban noi bat -->
<div class="bds-ban-noi-bat">
  <div class='container'>
    <h3 class="block-title">Nhà đất bán nổi bật</h3>
    <span class="line-break"></span>
    <div class='row'>
    <?php 
      $featured_bds = list_bds('bat_dong_san', array('102'), array(), 6);
      foreach ($featured_bds as $bds) : 
         print huyhoang_bds_item($bds);
       endforeach;
    ?>
    </div>
  </div>
</div>

<!-- quang cao -->
<div class="bds-quangcao">
  <div class="container">
    <h3>Coco river Garden</h3>
    <h4>Đẳng cấp nghỉ dưỡng bờ biển</h4>
    <a class="view-more" href="#">Xem Them</a>
  </div>
</div>

<!-- bds cho thue noi bat -->
<div class="bds-ban-noi-bat">
  <div class='container'>
    <h3 class="block-title">Nhà đất cho thuê nổi bật</h3>
    <span class="line-break"></span>
    <div class='row'>
    <?php 
      $featured_bds = list_bds('bat_dong_san', array('103'), array(), 6);
      foreach ($featured_bds as $bds) : 
         print huyhoang_bds_item($bds);
       endforeach;
    ?>
    </div>
  </div>
</div>
<!-- background image -->
<?php get_footer();?>