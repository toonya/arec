<?php 

add_action( 'add_meta_boxes', 'add_metabox_abstract', 10, 2 );

function add_metabox_abstract() {
	$screens = array( 'page' );

	foreach ( $screens as $screen ) {
		add_meta_box(
			'abstract'
			,'简介'
			,'render_metabox_abstract'
			, $screen
			,'advanced'
			,'default'
			);
	}
}

// ----------------------------------------
// ! call for style & javascript
// ----------------------------------------

function load_abstract_meida_support() {

	$screen = get_current_screen();

	if ( in_array( $screen->id, array( 'page' ) ) ) {
		wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/inc/css/admin.css' );
		wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'admin-javascript', get_template_directory_uri() . '/inc/js/admin.js', array('jquery'), '1.0.0', true );
	}
}

add_action( 'admin_enqueue_scripts', 'load_abstract_meida_support' );

// ----------------------------------------
// ! render abstract metabox
// ----------------------------------------
$abstract_meta_fields = array(
  array(
    'label' => '填写简介内容',
    'desc'  => '',
    'id'  => 'abstract_content',
    'type'  => 'textarea'
    )
  );

function render_metabox_abstract($post) {

  global $abstract_meta_fields;
  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'metabox_abstract', 'metabox_abstract_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  echo '<div class="side-form" role="form">';
  foreach ($abstract_meta_fields as $field) {
    echo get_toonya_metabox_html($post->ID, $field, false);
  }
  echo '</div>';
}

// ----------------------------------------
// ! save abstract metabox
// ----------------------------------------


function save_metabox_abstract_data( $post_id ) {
  global $abstract_meta_fields;
  /*
   * We need to verify this came from our screen and with proper authorization,
   * because the save_post action can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['metabox_abstract_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['metabox_abstract_nonce'], 'metabox_abstract' ) ) {
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

  foreach ($abstract_meta_fields as $field) {
    //if($field['type'] == 'tax_select') continue;

    if( ! isset( $_POST[$field['id']] ) )
      $_POST[$field['id']] = '';

    $old = get_post_meta($post_id, $field['id'], true);
    $new = $_POST[$field['id']];
    if ($new && $new != $old) {
      update_post_meta($post_id, $field['id'], $new);
    } elseif ('' == $new && $old) {
      delete_post_meta($post_id, $field['id'], $old);
    }
  } // enf foreach
}

add_action( 'save_post', 'save_metabox_abstract_data' ); 

?>