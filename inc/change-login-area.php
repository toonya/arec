<?php
// ----------------------------------------
// ! remove logo
// ----------------------------------------

function my_custom_login_logo() {
    echo '<style type="text/css">
	h1 a {background-image:url('. get_template_directory_uri() .'/img/asset/logo.png) !important; margin:0 auto; background-size:auto !important;width:230px !important;height:45px !important;}
	</style>';
}
add_filter( 'login_head', 'my_custom_login_logo' );

// ----------------------------------------
// ! change logo url
// ----------------------------------------
function the_url( $url ) {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'the_url' );

?>