<?php

// ----------------------------------------
// ! disable update
// ----------------------------------------
function hide_update_notice_to_all_but_admin_users()
{
    // if (!current_user_can('update_core')) {
    //     remove_action( 'admin_notices', 'update_nag', 10);
    // }

	remove_action( 'admin_notices', 'update_nag', 3);
}
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 1 );

// ----------------------------------------
// ! hide some item on admin bar
// ----------------------------------------
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {
	// $wp_admin_bar->remove_node( 'comments' );
	// $wp_admin_bar->remove_node( 'wp-logo' );
	// $wp_admin_bar->remove_node( 'updates' );
}

?>