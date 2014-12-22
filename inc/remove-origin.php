<?php
// ----------------------------------------
// ! remove welcome information
// * that is for new init website
// * may use default tutorial.
// ----------------------------------------

remove_action( 'welcome_panel', 'wp_welcome_panel' );

// ----------------------------------------
// ! remove toolbar node
// ----------------------------------------

add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'comments' );
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'new-content' );
	$wp_admin_bar->remove_node( 'updates' );
	$wp_admin_bar->remove_node( 'dashboard' );
	$wp_admin_bar->remove_node( 'themes' );
	$wp_admin_bar->remove_node( 'customize' );
	$wp_admin_bar->remove_node( 'menus' );
	$wp_admin_bar->remove_node( 'view-site' );
}


// ----------------------------------------
// ! cunstomer system page
// ----------------------------------------

add_action( 'admin_menu', 'my_menu_pages');
function my_menu_pages() {
	//remove page
	$cc_remove_page = array(
		'edit.php',
		//'edit.php?post_type=page',
		'tools.php',
		'index.php',
		//'upload.php',
		'post-new.php?post_type=page',
		'edit-comments.php',
		'themes.php',
		'plugins.php',
		'options-general.php',
		'users.php'
		);

	foreach($cc_remove_page as $id=>$menu){
		remove_menu_page($menu);
	}
	//remove subpage
	$remove_submenu_page = array(
		'edit.php?post_type=page' => 'post-new.php?post_type=page',
		'edit.php' => 'post-new.php',
		'users.php' => 'profile.php'
		);

	foreach($remove_submenu_page as $menu=>$submenu){
		remove_submenu_page($menu,$submenu);
	};
	remove_submenu_page('edit.php','edit-tags.php?taxonomy=category');
	remove_submenu_page('edit.php','edit-tags.php?taxonomy=post_tag');
	remove_submenu_page('users.php','user-new.php');
	remove_submenu_page('upload.php','upload.php');
	remove_submenu_page('upload.php','media-new.php');
}

?>