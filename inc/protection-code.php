<?php
// ----------------------------------------
// ! prevent_theme_edit
// * for protecting the code.
// ----------------------------------------
function prevent_theme_edit() {

	if (strpos(strtolower($_SERVER['REQUEST_URI']),'theme-editor.php') !== false) {

		wp_mail('msc5762@me.com', 'Someone want see my code', get_bloginfo('url'));

		wp_redirect( home_url(), 302 );
	}

}

add_action('init','prevent_theme_edit',0);
?>