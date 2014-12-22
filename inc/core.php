<?php
// ----------------------------------------
// ! remove dashboard widgets
// ----------------------------------------
function remove_dashboard_widgets(){
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');


// ----------------------------------------
// ! admin bar
// ----------------------------------------
if( current_user_can('level_10') )
	show_admin_bar(true);
else
	show_admin_bar(false);


// ----------------------------------------
// ! admin footer
// ----------------------------------------

add_action('admin_footer_text', 'my_admin_footer_function');
function my_admin_footer_function() {
	echo '同雅设计';
}
?>