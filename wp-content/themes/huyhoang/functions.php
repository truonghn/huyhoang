<?php

/**
 * Register custom sidebar
 */
if ( function_exists( 'register_sidebar' ) ) {
    if ( ! function_exists( 'huyhoang_register_sidebars' ) ) {
        function huyhoang_register_sidebars() {
            register_sidebar( array(
                'id'            => 'contact-sidebar',
                'name'          => __( 'Contact Sidebar', 'huyhoang' ),
                'description'   => __( 'This is the sidebar for contact info', 'huyhoang' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3>',
                'after_title'   => '</h3>',
            ) );
        } // function newsmag_register_sidebars end
        add_action( 'widgets_init', 'huyhoang_register_sidebars' );
    }
}

/**
 * Add custom css to the theme
 */
function huyhoang_custom_css() {
    $base = get_stylesheet_directory_uri();
    wp_enqueue_style( 'custom-style', $base.'/custom.css' );
}
add_action('wp_enqueue_scripts', 'huyhoang_custom_css', 11 );

/**
 * Add custom post type
 */
function huyhoang_bds_post_type() {
    $label = array(
        'name' => 'Bất động sản', 
        'singular_name' => 'Bất động sản'
    );
 
    $args = array(
        'labels' => $label,
        'description' => 'Bất động sản', 
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
        ),
        'taxonomies' => array( 'post_tag', 'category' ),
        'hierarchical' => false, 
        'public' => true,
        'show_ui' => true, 
        'show_in_menu' => true,
        'show_in_nav_menus' => true, 
        'show_in_admin_bar' => true, 
        'menu_position' => 4,
        'can_export' => true,
        'has_archive' => true, 
        'exclude_from_search' => false, 
        'publicly_queryable' => true, 
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'bat-dong-san')
    );
    register_post_type('bat_dong_san', $args);
    $label_duan = array(
        'name' => 'Dự án', 
        'singular_name' => 'Dự án'
    );
 
    $args_duan = array(
        'labels' => $label_duan,
        'description' => 'Dự án', 
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
        ),
        'taxonomies' => array( 'post_tag', 'category' ),
        'hierarchical' => false, 
        'public' => true,
        'show_ui' => true, 
        'show_in_menu' => true,
        'show_in_nav_menus' => true, 
        'show_in_admin_bar' => true, 
        'menu_position' => 4,
        'can_export' => true,
        'has_archive' => true, 
        'exclude_from_search' => false, 
        'publicly_queryable' => true, 
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'du_an')
    );
    register_post_type('du_an', $args_duan);
}
add_action('init', 'huyhoang_bds_post_type');
function list_bds($post_type, $categories = array(), $condition= array(), $limit = 10, $paged = 1, $pagination = FALSE) {
    $post = array();
    $arr_query = array(
        'post_type'=> $post_type,
        'posts_per_page'=> $limit,
        'paged' => $paged
    );
    if (!empty($categories)) {
        $arr_query['cat'] = $categories;
    }
    if (!empty($condition)) {
      foreach ($condition as $key => $value) {
          $arr_query['meta_key'] = $key;
          $arr_query['meta_value'] = $value;
      }
    }
    $bds_query = new WP_Query( 
        $arr_query
    );
    if ( $bds_query->have_posts() ) : 
        while ($bds_query->have_posts()) : $bds_query->the_post();
        $post[] = get_the_ID();
        endwhile; 
        if ($pagination) {
            $post['max_num_pages'] = $bds_query->max_num_pages;
        }
    endif;
    return $post;

}

function huyhoang_parse_price($price, $currency, $type) {
  if ($price <= 999) {
    $unit = $price.' Triệu '.$currency;
  } else {
    $unit = ($price/1000) . ' Tỉ '. $currency;
  }
  if ($type == 'thue') {
    $unit.='/Ngày';
  }
  return $unit;
}

function huyhoang_bds_item($post_id) {
    $bds = get_post_custom($post_id);
    $price = 0;
    if (has_category(102, $post_id)) {
        $cat_div = '<div class="ban">cần bán</div>';
        if (!empty($bds['price'][0])) {
            $price = huyhoang_parse_price($bds['price'][0], 'VND', 'ban');
        }
        
    } elseif (has_category(103, $post_id)) {
        $cat_div = '<div class="mua">cho thuê</div>';
        if ($bds['rent_price'][0]) {
            $price = huyhoang_parse_price($bds['rent_price'][0], 'VND', 'thue');
        }  
    } else {
        $cat_div = '<div class="nghiduong">nghỉ dưỡng</div>';
        $cat_div = '<div class="mua">cho thuê</div>';
        if ($bds['rent_price'][0]) {
            $price = huyhoang_parse_price($bds['rent_price'][0], 'VND', 'thue');
        }  
    }
    $output = '<div class="col-md-4 col-sm-6"><div class="bds-item">';
    $output.= $cat_div;
    $feature_image = '<div class="featured-image"><a href= "'.get_post_permalink($post_id).'">'. get_the_post_thumbnail($post_id).'</a></div>';
    $output.= $feature_image;
    $output.= '<div class="bds-fields">';
    $title = '<div class="bds-title"><h4><a href= "'.get_post_permalink($post_id).'">'.get_the_title($post_id).'</a></h4></div>';
    $output.=$title;
    if (!empty($bds['position'][0])) {
        $location = '<div class="bds-location bds-field">'.$bds['position'][0].'</div>';
        $output.= $location;
    }
    
    $des = '<div class="bds-des bds-field"><span>'.get_the_excerpt($post_id).'</span></div>';
    $output.= $des;
    if (!empty($price)) {
        $price = '<div class="bds-price bds-field">'.$price.'</div>';
        $output.= $price;
    }
    $output.='<div class="meta-bds"><div class="row">';
    if (!empty($bds['subject'][0])) {
        $price = '<div class="col-xs-4 bds-subject"><span>'.$bds['subject'][0].'</span></div>';
        $output.= $price;
    }
    if (!empty($bds['bed_room'][0])) {
        $bedroom = '<div class="col-xs-4 bds-bed-room"><span>'.$bds['bed_room'][0].'</span></div>';
        $output.= $bedroom;
    }
    if (!empty($bds['num_of_toilet'][0])) {
        $toilet = '<div class="col-xs-4 bds-toilet"><span>'.$bds['num_of_toilet'][0].'</span></div>';
        $output.= $toilet;
    }
    $output.='</div></div></div>';
    $output.= '</div></div>';
    return $output;
}

function huyhoang_du_an_item($post_id) {
    $du_an = get_post_custom($post_id);
    $output .='<div class="row"><div class="du-an-item">';
    $output.= '<div class="col-xs-12 col-sm-5">';
    $feature_image = '<div class="featured-image"><a href= "'.get_post_permalink($post_id).'">'. get_the_post_thumbnail($post_id).'</a></div>';
    $output.= $feature_image;
    $output.='</div>';
    $output.= '<div class="col-xs-12 col-sm-7"><div class="meta">';
    $title = '<div class="bds-title"><h4><a href= "'.get_post_permalink($post_id).'">'.get_the_title($post_id).'</a></h4></div>';
    $output.=$title;
    if (!empty(get_field('position', $post_id))) {
        $location = '<div class="bds-location bds-field">'.get_field('position', $post_id).'</div>';
        $output.= $location;
    }
    $des = '<div class="bds-des bds-field"><span>'.get_the_excerpt($post_id).'</span></div>';
    $output.= $des;
    $output.='</div></div>';
    $output .='</div></div>';
    return $output;
}

function huyhoang_du_an_featured($post_id) {
    $du_an = get_post_custom($post_id);
    $output .='<div class="row"><div class="col-xs-12"><div class="du-an-featured">';
    $feature_image = '<div class="featured-image"><a href= "'.get_post_permalink($post_id).'">'. get_the_post_thumbnail($post_id).'</a></div>';
    $output.= $feature_image;
    $output.= '<div class="meta">';
    $title = '<div class="bds-title"><h4><a href= "'.get_post_permalink($post_id).'">'.get_the_title($post_id).'</a></h4></div>';
    $output.=$title;
    if (!empty(get_field('position', $post_id))) {
        $location = '<div class="bds-location bds-field">'.get_field('position', $post_id).'</div>';
        $output.= $location;
    };
    $output.='</div>';
    $output .='</div></div></div>';
    return $output;
}
/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function huyhoang_custom_excerpt_length( $length ) {
    return 15;
}
add_filter( 'excerpt_length', 'huyhoang_custom_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function huyhoang_custom_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'huyhoang_custom_excerpt_more' );

//custom pagination
function huyhoang_pagination($numpages = '', $pagerange = '', $paged='') {

  if (empty($pagerange)) {
    $pagerange = 5;
  }

  /**
   * This first part of our function is a fallback
   * for custom pagination inside a regular loop that
   * uses the global $paged and global $wp_query variables.
   * 
   * It's good because we can now override default pagination
   * in our theme, and use this function in default quries
   * and custom queries.
   */
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }

  /** 
   * We construct the pagination arguments to enter into our paginate_links
   * function. 
   */
  $pagination_args = array(
    'base'            => get_pagenum_link(1) . '%_%',
    'format'          => 'page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('&laquo;'),
    'next_text'       => __('&raquo;'),
    'type'            => 'plain',
    'add_args'        => false,
    'add_fragment'    => ''
  );
  
  $paginate_links = paginate_links($pagination_args);
  if ($paginate_links) {
    echo "<nav class='huyhoang-pagination'>";
      echo $paginate_links;
    echo "</nav>";
  }

}
