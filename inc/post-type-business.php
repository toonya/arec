<?php 

// ----------------------------------------
// ! business
// ----------------------------------------
function business() {
  $default = array(
		'name' => '业务管理',
		'slug' => 'business'
	);

  $labels = array(
    'name' => $default['name'],
    'singular_name' => $default['name'],
    'add_new' => '添加新'.$default['name'],
    'add_new_item' => '添加新'.$default['name'],
    'edit_item' => '编辑'.$default['name'].'信息',
    'new_item' => '添加新'.$default['name'],
    'all_items' => '全部'.$default['name'],
    'view_item' => '浏览该'.$default['name'],
    'search_items' => '查找'.$default['name'],
    'not_found' =>  '没有发现',
    'not_found_in_trash' => '垃圾箱中没有',
    'parent_item_colon' => '',
    'menu_name' => $default['name']
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
	//Provide a callback function that will be called when setting up the meta boxes for the edit form. Do remove_meta_box() and add_meta_box() calls in the callback.
	//'register_meta_box_cb' => 'add_business_metaboxs',
	//'with_front' => bool Should the permastruct be prepended with the front base. (example: if your permalink structure is /blog/, then your links will be: false->/news/, true->/blog/news/). Defaults to true
    'rewrite' => array( 'slug' => $default['slug'] ),
    'capability_type' => 'post',
    'has_archive' => true,
    //'taxonomies' => array( 'business_type' ),
    'hierarchical' => false,
    'menu_position' => 70,
    'supports' => array( 'title', 'editor','thumbnail' )
  );

  register_post_type( $default['slug'], $args );
}
if(!post_type_exists('business'))
	add_action( 'init', 'business' );


// ----------------------------------------
// ! load single post template
// ----------------------------------------

function get_business_template($single_template) {
     global $post;

     if ($post->post_type == 'business') {
          $single_template = get_template_directory() . '/single-templates/business.php';
     }
     return $single_template;
}
//add_filter( 'single_template', 'get_business_template' );

// ----------------------------------------
// ! add second title metabox.
// ----------------------------------------
function add_business_metaboxs() {

  $screens = array( 'business' );

  foreach ( $screens as $screen ) {

    add_meta_box(
      'info',
      '详细信息',
      'business_meta_box_callback',
      $screen,
      'normal',
      'core'
    );
  }

  // ----------------------------------------
  // ! call for style & javascript
  // ----------------------------------------

  function load_business_meida_support() {

    $screen = get_current_screen();

    if ( in_array( $screen->id, array( 'business' ) ) ) {
      wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
      wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/inc/css/admin.css' );
      wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '1.0.0', true );
      wp_enqueue_script( 'admin-javascript', get_template_directory_uri() . '/inc/js/admin.js', array('jquery'), '1.0.0', true );
    }
  }

  add_action( 'admin_enqueue_scripts', 'load_business_meida_support' );
}

// Field Array
$business_meta_fields = array(
  // array(
  //   'label' => '地址',
  //   'desc'  => '',
  //   'id'  => 'business_location',
  //   'type'  => 'text'
  // ),
  // array(
  //   'label' => '教学系统',
  //   'desc'  => '',
  //   'id'  => 'business_edu_sys',
  //   'type'  => 'text'
  // ),
  // array(
  //   'label' => '课程介绍',
  //   'desc'  => '',
  //   'id'  => 'business_course_intro',
  //   'type'  => 'textarea'
  // ),
  array(
    'label' => '广告语',
    'id' => 'business_advertisement',
    'type' => 'text',
  ),
);


/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function business_meta_box_callback( $post ) {
  global $business_meta_fields;
  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'business_meta_box', 'business_meta_box_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */

  echo '<div class="form-horizontal" role="form">';
  foreach ($business_meta_fields as $field) {
      echo get_toonya_metabox_html($post->ID, $field,true);
  }
  echo '</div>';
}

/**
 * When the post is saved, saves our business data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function business_save_meta_box_data( $post_id ) {
  global $business_meta_fields;
  /*
   * We need to verify this came from our screen and with proper authorization,
   * because the save_post action can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['business_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['business_meta_box_nonce'], 'business_meta_box' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Check the user's permissions.
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }

  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  /* OK, its safe for us to save the data now. */

  // Make sure that it is set.
  // if ( ! isset( $_POST['business'] ) ) {
  //  return;
  // }

  foreach ($business_meta_fields as $field) {
    if($field['type'] == 'tax_select') continue;

    if( ! isset( $_POST[$field['id']] ) )
      continue;

    $old = get_post_meta($post_id, $field['id'], true);
    $new = $_POST[$field['id']];
    if ($new && $new != $old) {
      update_post_meta($post_id, $field['id'], $new);
    } elseif ('' == $new && $old) {
      delete_post_meta($post_id, $field['id'], $old);
    }
  } // enf foreach

  // Sanitize user input.
  //$my_data = sanitize_text_field( $_POST['business'] );

  // Update the meta field in the database.
  //update_post_meta( $post_id, 'business', $my_data );
}
add_action( 'save_post', 'business_save_meta_box_data' );
?>