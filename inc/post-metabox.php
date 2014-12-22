<?php 

// ----------------------------------------
// ! add second title metabox.
// ----------------------------------------
function add_second_title() {

	$screens = array( 'page', 'iedu_school' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'info',
			'详细信息',
			'second_title_meta_box_callback',
			$screen,
			'normal',
			'core'
		);
	}
}
add_action( 'add_meta_boxes', 'add_second_title' );


// Field Array
$prefix = 'custom_';
$custom_meta_fields = array(
	array(
		'label'	=> '地址',
		'desc'	=> '',
		'id'	=> $prefix.'location',
		'type'	=> 'text'
	),
	array(
		'label'	=> '教学系统',
		'desc'	=> '',
		'id'	=> $prefix.'edu_sys',
		'type'	=> 'text'
	),
	array(
		'label'	=> '课程介绍',
		'desc'	=> '',
		'id'	=> $prefix.'course_intro',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> '学费',
		'desc'	=> '',
		'id'	=> $prefix.'fee',
		'type'	=> 'text'
	),
	array(
		'label'	=> '教学&详情',
		'desc'	=> '',
		'id'	=> $prefix.'edu_info',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> '入学&要求',
		'desc'	=> '',
		'id'	=> $prefix.'requirement',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> '费用&条款',
		'desc'	=> '',
		'id'	=> $prefix.'fee_agreement',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> '服务流程',
		'desc'	=> '',
		'id'	=> $prefix.'service_process',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> '申请表格',
		'desc'	=> '',
		'id'	=> $prefix.'apply_form',
		'type'	=> 'textarea'
	),
);


/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function second_title_meta_box_callback( $post ) {
	global $custom_meta_fields;
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'custom_meta_box', 'custom_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */

	echo '<div class="form-horizontal" role="form">';
	foreach ($custom_meta_fields as $field) {
		$value = get_post_meta( $post->ID, $field['id'], true );

		echo '<div class="form-group" role="form">';
		switch ($field['type']) {
			case 'text':
				echo '<label class="col-sm-2 control-label" for="'.$field['id'].'">'.$field['label'].'</label>';
				echo '<div class="col-sm-8"><input class="form-control" type="text" id="'.$field['id'].'" name="'.$field['id'].'" value="' . esc_attr( $value ) . '" /></div>';
				break;

			case 'textarea':
				echo '<label class="col-sm-2 control-label" for="'.$field['id'].'">'.$field['label'].'</label>';
				echo '<div class="col-sm-8"><textarea rows="5" class="form-control" type="text" id="'.$field['id'].'" name="'.$field['id'].'">' . esc_attr( $value ) . '</textarea></div>';
				break;
			
			default:
				break;
		}
		echo '</div>';
	}
	echo '</div>';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function custom_save_meta_box_data( $post_id ) {
	global $custom_meta_fields;
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['custom_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['custom_meta_box_nonce'], 'custom_meta_box' ) ) {
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
	// if ( ! isset( $_POST['custom'] ) ) {
	// 	return;
	// }

	foreach ($custom_meta_fields as $field) {
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
	//$my_data = sanitize_text_field( $_POST['custom'] );

	// Update the meta field in the database.
	//update_post_meta( $post_id, 'custom', $my_data );
}
add_action( 'save_post', 'custom_save_meta_box_data' );
	
?>