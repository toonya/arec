<?php
// ----------------------------------------
// ! add a admin page to edit the banner
//   slide images
// ----------------------------------------

//add_action( 'admin_menu', 'ty_mail_record' );

function ty_mail_record() {
    add_menu_page( '邮件记录', '邮件记录', 'manage_options', 'mail_record', 'ty_mail_record_fn', '', 60 );
}
function ty_mail_record_fn() {}


// ----------------------------------------
// ! load some info for js.file
// ----------------------------------------
function load_mail_ajax() {

	global $post;

	if ( !empty($post) && (in_array( $post->post_name, array( 'ask', 'contact' ) )) || (is_page_template('page-contact.php' )) )
	{
	    $ajax_mail_nonce = wp_create_nonce("ajax-mail-nonce");

		wp_enqueue_script( 'ajax_mail', get_template_directory_uri() . '/inc/js/mail.js', array('jquery'), '1.0.0', true );
	    wp_localize_script( 'ajax_mail', 'mail_options',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'ajax_mail_type'=>'contact' , 'action'=>'ajax_mail_handle' , 'security'=>$ajax_mail_nonce ));
	}
}

add_action( 'wp_enqueue_scripts', 'load_mail_ajax' );

// ----------------------------------------
// ! save banner option
// ----------------------------------------
function ajax_mail_handle() {
    //check nonce
    check_ajax_referer( 'ajax-mail-nonce', 'security' );

	// ----------------------------------------
	// ! use html
	// ----------------------------------------
	function set_html_content_type() {
		return 'text/html';
	}

	add_filter( 'wp_mail_content_type', 'set_html_content_type' );


    $results;
    $reciver = get_option('mail-reciver');

    if(!empty($reciver)) {

		$reciver = preg_split ("/\s+/", $reciver);

	    switch($_POST['ajax_mail_type']) {
		    case 'contact' :

				$subject       = sprintf( '[%s]. New contact request.', get_bloginfo('name'));
				$message       = sprintf( 'Name : %s <br /> <a href="mailto:%s">%s</a> <br /><br /> Subject : %s <br /> Message : %s ',
									$_POST['name'],
									$_POST['email'],
									$_POST['email'],
									$_POST['subject'],
									wpautop($_POST['content'])
									);

				$mail = wp_mail($reciver, $subject, $message);

				if(empty($mail)) {
					$results = array(
						'state' => false
					);

					wp_send_json($results);
				}
				else {
					$results = array(
						'state' => $mail
					);

					wp_send_json($results);
				}

		    	break;

		    case 'ask' :

				$subject       = sprintf( '[%s]. New question.', get_bloginfo('name'));
				$message       = sprintf( 'Name : %s <br /> <a href="mailto:%s">%s</a> <br /><br /> %s %s %s Subject : %s <br /> Message : %s ',
									$_POST['name'],
									$_POST['email'],
									$_POST['email'],
									( isset($_POST['topic']) && !empty($_POST['topic']) ) ? 'Topic : ' . $_POST['topic'] . '<br />' : '',
									( isset($_POST['primary']) && !empty($_POST['primary']) ) ? 'Category : ' . $_POST['primary'] : '',
									( isset($_POST['second']) && !empty($_POST['second']) ) ? '/' . $_POST['second'] . '<br />' : '<br />',
									$_POST['subject'],
									$_POST['description']
									);
				// make sure fn work
				if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
				$uploadedfile = $_FILES['attachment'];
				$upload_overrides = array( 'test_form' => false );
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
				if ( $movefile ) {
				    $file = $movefile['file'];
				} else {
				    $file = '';
				}


				$mail = wp_mail($reciver, $subject, $message , "From: International Education <iedu@toonya.me>" . "\r\n" , $file);
				wp_send_json($mail);
				if($file != '') {
					unlink($file);
				}

				if( !$mail ) {
					$results = array(
						'state' => false,
						'file'  => $_FILES['attachment']
					);

					wp_send_json($results);
				}
				else {
					$results = array(
						'state' => $mail,
						'file'  => $_FILES['attachment']
					);

					wp_send_json($results);
				}

		    	break;

		    default :
		    	$results = 'Please set a type.';
		    	break;
	    }
    }

	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

}
add_action('wp_ajax_nopriv_ajax_mail_handle', 'ajax_mail_handle');
add_action('wp_ajax_ajax_mail_handle', 'ajax_mail_handle');


?>