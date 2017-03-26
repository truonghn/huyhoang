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
function huyhoang_custom_file() {
    $base = get_stylesheet_directory_uri();
    wp_enqueue_style( 'custom-style', $base.'/custom.css' );
    wp_enqueue_script( 'custom-style', $base.'/custom.js' );
    wp_enqueue_style( 'flex-slider', $base.'/flexslider/flexslider.css' );
    wp_enqueue_script( 'flex-slider', $base.'/flexslider/jquery.flexslider.js' );
}
add_action('wp_enqueue_scripts', 'huyhoang_custom_file', 11 );

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
    wp_reset_postdata();
    return $post;

}

function huyhoang_parse_price($price, $currency, $type) {
  if ($price < 1000) {
    $unit = $price.' Triệu '.$currency;
  } else {
    $unit = ($price/1000) . ' Tỉ '. $currency;
  }
  if ($type == 'thue') {
    $unit.='/Ngày';
  }
  return $unit;
}

function huyhoang_bds_item($post_id, $num_col = 3) {
    $num_col = 12/$num_col;
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
    $output = '<div class="col-md-'.$num_col.' col-sm-6"><div class="bds-item">';
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
    
    $des = '<div class="bds-des bds-field"><span>'.get_post_excerpt_by_id($post_id).'</span></div>';
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
    $des = '<div class="bds-des bds-field"><span>'.get_post_excerpt_by_id($post_id).'</span></div>';
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
    //'base'            => get_pagenum_link(1) . '%_%',
    'base' => preg_replace('/\?.*/', '', get_pagenum_link(1)) . '%_%',
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
    'add_args' => array(
    ),
    'add_fragment'    => ''
  );
  
  $paginate_links = paginate_links($pagination_args);
  if ($paginate_links) {
    echo "<nav class='huyhoang-pagination'>";
      echo $paginate_links;
    echo "</nav>";
  }
}

/**
 * Get post excerp by post id
 */
function get_post_excerpt_by_id( $post_id ) {
    global $post;
    $post = get_post( $post_id );
    setup_postdata( $post );
    $the_excerpt = get_the_excerpt();
    wp_reset_postdata();
    return $the_excerpt;
}

/**
 * load quan/huyen
 */
function huyhoang_load_quan() {
    return array(
        'Hoà Vang' => 'Hoà Vang',
        'Hải Châu' => 'Hải Châu',
        'Cẩm Lệ'   => 'Cẩm Lệ',
        'Liên Chiểu'=> 'Liên Chiểu'
    );
}

/**
 * Load Phường
 */
function huyhoang_load_phuong() {
  return array(
    'Hải Châu 1' => 'Hải Châu 1',
    'Hoà Minh'   => 'Hoà Minh',
    'Hoà Thọ'    => 'Hoà Thọ',
    'Hoà Phong'  => 'Hoà Phong',
    'Hoà Ninh'   => 'Hoà Ninh',
    'Hải Châu 2' => 'Hải Châu 2'
  );
}

/**
 * Search bất động sản
 */
function search_bds($conditions= array(), $limit = 10, $paged = 1) {
    $post = array();
    $cat = array();
    $arr_query = array(
        'post_type'=> 'bat_dong_san',
        'posts_per_page'=> $limit,
        'paged' => $paged,
        
    );
    if (!empty($conditions['bds_sort'])) {
      switch ($conditions['bds_sort']) {
          case '1':
              $query_sort = array(
                'orderby'           => 'date',
                'order'             => 'DESC',
              );
              break;
          case '2':
              $query_sort = array(
                'orderby'           => 'meta_value',
                'order'             => 'ASC',
              );
              break;
          case '3':
              $query_sort = array(
                'orderby'           => 'meta_value',
                'order'             => 'DESC',
              );
              break;
          case '4':
              $query_sort = array(
                'orderby'           => 'meta_value',
                'order'             => 'DESC',
                'meta_key'          => 'subject'
              );
              break;
          case '5':
              $query_sort = array(
                    'orderby'           => 'meta_value',
                    'order'             => 'ASC',
                    'meta_key'          => 'subject'
              );
              break;
          default: $query_sort = array();
          break;
          
      }
    }
    if (!empty($query_sort)) {
        $arr_query = array_merge($arr_query, $query_sort);
    }
    if (!empty($conditions['bds_type'])) {
        $cat[] = $conditions['bds_type'];
        if ($conditions['bds_type'] == '102') {
            if (!empty($conditions['bds_sort']) && ($conditions['bds_sort'] == 2 || $conditions['bds_sort'] == 3)) {
                $arr_query['meta_key'] = 'price';
            }
        } else {
            if (!empty($conditions['bds_sort']) && ($conditions['bds_sort'] == 2 || $conditions['bds_sort'] == 3)) {
                $arr_query['meta_key'] = 'rent_price';
            }
        }
    }
    if (!empty($conditions['bds_cat'])) {
        $cat[] = $conditions['bds_cat'];
    }
    
    if (!empty($cat)) {
        $arr_query['category__and'] = $cat;
    }

    //query by subject
    if (!empty($conditions['bds_subject'])) {
        switch ($conditions['bds_subject']) {
            case '1':
                $fields[] = array(
                    'key'       => 'subject',
                    'value'     => array(50, 100),
                    'compare'   => 'BETWEEN',
                );    
                break;
            case '2':
                $fields[] = array(
                    'key'       => 'subject',
                    'value'     => array(100, 200),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '3':
                $fields[] = array(
                    'key'       => 'subject',
                    'value'     => array(200, 300),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '4':
                $fields[] = array(
                    'key'       => 'subject',
                    'value'     => array(300, 400),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '5':
                $fields[] = array(
                    'key'       => 'subject',
                    'value'     => 500,
                    'type'      => 'NUMERIC',
                    'compare'   => '>',
                ); 
                break;
              
        }
    }
    //query by price
    if (!empty($conditions['bds_price'])) {
        
        switch ($conditions['bds_price']) {
            case '1':
                $fields[] = array(
                    'key'       => 'price',
                    'value'     => 500,
                    'type'      => 'NUMERIC',
                    'compare'   => '<',
                );    
                break;
            case '2':
                $fields[] = array(
                    'key'       => 'price',
                    'value'     => array(500, 700),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '3':
                $fields[] = array(
                    'key'       => 'price',
                    'value'     => array(700, 1000),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '4':
                $fields[] = array(
                    'key'       => 'price',
                    'value'     => array(1000, 3000),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '5':
                $fields[] = array(
                    'key'       => 'price',
                    'value'     => 3000,
                    'type'      => 'NUMERIC',
                    'compare'   => '>',
                ); 
                break;
              
        }
    }
    //query by rent price
    if (!empty($conditions['bds_rent_price'])) {
        
        switch ($conditions['bds_rent_price']) {
            case '1':
                $fields[] = array(
                    'key'       => 'rent_price',
                    'value'     => 1,
                    'type'      => 'NUMERIC',
                    'compare'   => '<',
                );    
                break;
            case '2':
                $fields[] = array(
                    'key'       => 'rent_price',
                    'value'     => array(1, 2),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '3':
                $fields[] = array(
                    'key'       => 'rent_price',
                    'value'     => array(2, 3),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '4':
                $fields[] = array(
                    'key'       => 'rent_price',
                    'value'     => array(3, 4),
                    'compare'   => 'BETWEEN',
                ); 
                break;
            case '5':
                $fields[] = array(
                    'key'       => 'rent_price',
                    'value'     => 4,
                    'type'      => 'NUMERIC',
                    'compare'   => '>',
                ); 
                break;
              
        }
    }
    //number of bedroom
    if (!empty($conditions['bds_bedroom'])) {
        $fields[] =array(
            'key' => 'bed_room',
            'value' => $conditions['bds_bedroom'],
            'type' => 'NUMERIC',
            'compare' => '='
        );
    }

    if (!empty($conditions['bds_quan'])) {
        $fields[] =array(
            'key' => 'district',
            'value' => $conditions['bds_quan'],
            'compare' => '='
        );
    }
    //direction
    if (!empty($conditions['bds_direction'])) {
        $fields[] = array(
            'key' => 'direction',
            'value' => $conditions['direction'],
            'compare' => '='
        );
    }
    if (!empty($fields)) {
        $fields['relation'] = 'AND';
        $arr_query['meta_query'] = $fields;
    }
    $bds_query = new WP_Query( 
        $arr_query
    );
    if ( $bds_query->have_posts() ) : 
        while ($bds_query->have_posts()) : $bds_query->the_post();
        $post[] = get_the_ID();
        endwhile; 
        $post['max_num_pages'] = $bds_query->max_num_pages;
        $post['total'] = $bds_query->found_posts;
    endif;
    return $post;
}

/**
 * Generate select option fields
 */
function huyhoang_generate_select_fields($name, $options) {
  $output = "<select name='{$name}'>";
  foreach ($options as $option) {
    $select = '';
    if (isset($_GET[$name]) && $_GET[$name] == $option['value']) {
      $select = 'selected';
    }
    $op = "<option {$select} value='".$option['value']."'>".$option['name']."</option>";
    $output.=$op;
  }
  $output.="</select>";
  return $output;
}

/**
 * load custom post type posts in category page
 */
function huyhoang_cat_post_type($query) {
    if ( is_category() && ( ! isset( $query->query_vars['suppress_filters'] ) || false == $query->query_vars['suppress_filters'] ) ) {
        $query->set( 'post_type', array( 'post', 'bat_dong_san' ) );
        return $query;
    }
}
add_filter('pre_get_posts', 'huyhoang_cat_post_type');