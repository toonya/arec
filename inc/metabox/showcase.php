<?php 

add_action( 'add_meta_boxes', 'add_metabox_showcase', 10, 2 );

function add_metabox_showcase() {
	$screens = array( 'iedu_school', 'iedu_ed', 'iedu_visit', 'iedu_camp', 'iedu_certification', 'iedu_hotel' );

	foreach ( $screens as $screen ) {
		add_meta_box(
			'showcase'
			,'相片集'
			,'render_metabox_showcase'
			, $screen
			,'normal'
			,'core'
			);
	}
}

// ----------------------------------------
// ! call for style & javascript
// ----------------------------------------

function load_showcase_media_support() {

	$screen = get_current_screen();

	if ( in_array( $screen->id, array( 'iedu_school', 'iedu_ed', 'iedu_visit', 'iedu_camp', 'iedu_certification', 'iedu_hotel' ) ) ) {
		wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/inc/css/admin.css' );
		wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'admin-javascript', get_template_directory_uri() . '/inc/js/admin.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'admin-showcase', get_template_directory_uri() . '/inc/js/showcase.js', array('jquery'), '1.0.0', true );

		wp_enqueue_media(); //call the media management.	
	}
}

add_action( 'admin_enqueue_scripts', 'load_showcase_media_support' );

// ----------------------------------------
// ! render showcase metabox
// ----------------------------------------

function render_metabox_showcase($post) {

	wp_nonce_field( 'metabox_showcase', 'metabox_showcase_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta( $post->ID, 'showcase', true );
  ?>
  <div class="row">
  	<div class="funtions col-xs-11">
  		<div class="btn-group btn-group-justified">
  			<a href="#" class="btn btn-default disable new">新增</a>
  			<a href="#" class="btn btn-default disable edit-close">编辑</a>
  		</div>
  		<div class="hidden item template">
  			<input type="hidden" id="showcase" name="" value="" />
  			<div class="edit-area hidden">
  				<button type="button" class="close">×</button>
  			</div>
  			<img src="" alt="" />
  		</div>

      <div class="showcase"><!--
        <?php if($value): foreach($value as $key=>$url){ ?>
        --><div class="item">
        <input type="hidden" id="showcase" name="showcase[<?php echo $key; ?>]" value="<?php echo esc_attr($url); ?>" />
        <div class="edit-area hidden">
        	<button type="button" class="close">×</button>
        </div>
        <img src="<?php echo esc_attr($url); ?>" alt="" />
          </div><!--
        <?php } endif;?>
    --></div>
</div>
<div class="clear"></div>
</div>
<?php
}

// ----------------------------------------
// ! save showcase metabox
// ----------------------------------------


function save_metabox_showcase_data( $post_id ) {
  global $school_meta_fields;
  /*
   * We need to verify this came from our screen and with proper authorization,
   * because the save_post action can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['metabox_showcase_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['metabox_showcase_nonce'], 'metabox_showcase' ) ) {
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

  if( !empty($_POST['showcase']) ) {
    $mydata =  $_POST['showcase'] ;

    // Update the meta field in the database.
    update_post_meta( $post_id, 'showcase', $mydata );
  }
  else {
    $mydata = '';

    // Update the meta field in the database.
    update_post_meta( $post_id, 'showcase', $mydata );
  }
  // Sanitize user input.
  //$my_data = sanitize_text_field( $_POST['school'] );

  // Update the meta field in the database.
  //update_post_meta( $post_id, 'school', $my_data );
}
add_action( 'save_post', 'save_metabox_showcase_data' ); 

?>