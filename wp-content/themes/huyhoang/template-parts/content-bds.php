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
<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
<div class="row newsmag-article-post <?php echo ( ! $breadcrumbs_enabled && ! $image_in_content ) ? 'newsmag-margin-top' : '' ?>">
  <div class="col-sm-12 col-md-7">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="entry-content">
          <?php 
          $images = acf_photo_gallery('gallery', get_the_ID());
          if( $images ): ?>
              <div id="slider" class="flexslider">
                  <ul class="slides">
                      <?php foreach( $images as $image ): ?>
                          <li>
                              <img src="<?php echo $image['full_image_url']; ?>" alt="<?php echo $image['alt']; ?>" />
                          </li>
                      <?php endforeach; ?>
                  </ul>
              </div>
              <div id="carousel" class="flexslider">
                  <ul class="slides">
                      <?php foreach( $images as $image ): ?>
                          <li>
                              <img src="<?php echo $image['thumbnail_image_url']; ?>" alt="<?php echo $image['alt']; ?>" />
                          </li>
                      <?php endforeach; ?>
                  </ul>
              </div>
          <?php endif; ?>
      </div>
    </article><!-- #post-## -->
    <!-- dac diem bds -->
    <div class="bds-detail">
    <div class="maso"><span class="label-text">Đặc Điểm Bất Động Sản</span><span class="value pull-right"><strong>Mã số:</strong><?php echo get_field('code'); ?></span></div>

    <div class="position"><span class="label-text">Vị Trí:</span><span class="value"><?php echo get_field('position'); ?></span></div>

    <div class="subject"><span class="label-text">Diện tích đất:</span><span class="value"><?php echo get_field('subject'); ?></span></div>

    <div class="use-subject"><span class="label-text">Diện tích sử dụng:</span><span class="value"><?php echo get_field('use_area'); ?></span></div>

    <div class="num-floor"><span class="label-text">Số Tầng:</span><span class="value"><?php echo get_field('num_floor'); ?></span></div>

    <div class="num-bedroom"><span class="label-text">Số phòng ngủ:</span><span class="value"><?php echo get_field('bed_room'); ?></span></div>

    <div class="direction"><span class="label-text">Hướng:</span><span class="value"><?php echo get_field('direction'); ?></span></div>

    <div class="sell-price"><span class="label-text">Giá:</span><span class="value"><?php echo get_field('price'); ?></span></div>

    <div class="description"><span class="label-text">Mô tả thêm:</span><span class="value"><?php echo get_post_field('post_content') ?></span></div>

    </div>
    <!-- google map -->
    <?php 
      $location = '';
      if (!empty(get_field('position'))) {
        $location = get_field('position');
      }
    ?>
    <div class="google-map">
      <span class="google-text">Bản đồ google</span>
      <div class="google-location"><span><?php echo $location; ?></span>
      <iframe width="100%" height="250" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDD20ddO-cLRet-CQjanV1ZMUBHuhaeOtQ&q=<?php echo $location; ?>" allowfullscreen>
    </iframe>
    </div>
    </div>
    
    <!-- Bds noi bat -->
    <!-- bds can ban noi bat -->
    <div class="bds-ban-noi-bat">
        <h3 class="block-title">Bất động sản nổi bật</h3>
        <span class="line-break"></span>
        <div class='row'>
        <?php 
          $featured_bds = list_bds('bat_dong_san', array(), array('is_featured' => 'yes'));
          foreach ($featured_bds as $bds) : 
             print huyhoang_bds_item($bds, 2);
           endforeach;
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-5 col-sm-12">
    <div class="contact-section-detail">
      <div class="contact-info">
        <div class="author-avatar">
          <img src="/wp-content/themes/huyhoang/images/avatar.png">
        </div>
        <div class="author-info">
          <span class="intro">Giam doc</span>
          <span class="name-founder">Minh toan</span>
          <span class="phone-founder"><a href="tel:0905014500">0905 014 500</a></span>
        </div>
      </div>
      <div class="social-info">
        <span>Hoặc thông qua:</span>
         <a class="zalo-contact" rel="nofollow" href="skype:tocno?chat" title="Chat với Minh Toan" style="text-decoration: none;"><img src="/wp-content/themes/huyhoang/images/zalo.png">
          </a>
         <a class="skype-contact" rel="nofollow" href="skype:tocno?chat" title="Chat với Minh Toan" style="text-decoration: none;"><img src="/wp-content/themes/huyhoang/images/skype.svg">
         <a class="viber-contact" rel="nofollow" href="viber://0905014500" title="Chat với Minh Toan" style="text-decoration: none;"><img src="/wp-content/themes/huyhoang/images/viber.svg">
          </a>
          </a>
        </div>
      <div class="contact-form">
      <?php
      $shortcode = '[contact-form-7 id="1844" title="Liên hệ"]';
      echo do_shortcode( $shortcode );
      ?>
      </div>
      <div class="contact-sharing">
        <span>Chia sẻ qua mạng xã hội</span>
        <div class="sharing-icons">
          <a class="fb-large-sharing" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank">&nbsp</a>
          <a class="gplus-sharing" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>" target="_blank">&nbsp</a>
          <a class="gmail-sharing" href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&body=<?php echo get_permalink();?>" target="_blank">&nbsp</a>
        </div>
      </div>
    </div>
  </div>
</div>


