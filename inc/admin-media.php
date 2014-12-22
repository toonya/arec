<?php
function admin_bs_media() {
	wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/inc/css/admin.css' );
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'admin-javascript', get_template_directory_uri() . '/inc/js/admin.js', array('jquery'), '1.0.0', true );

	wp_enqueue_media(); //call the media management.	
}

add_action( 'admin_enqueue_scripts', 'admin_bs_media' );
?>