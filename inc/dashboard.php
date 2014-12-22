<?php

// ----------------------------------------
// ! add customer dashboard widgets
// ----------------------------------------
add_action('wp_dashboard_setup','add_dashboard_widgets');


function dashboardWidgetContent() {
	echo '祝全体员工工作顺利!';
}


function add_dashboard_widgets() {

	$custom_dashboard_widgets = array(
	    'my-dashboard-widget' => array(
	        'title' => '汇付友',
	        'callback' => 'dashboardWidgetContent'
	    )
	);

    foreach ( $custom_dashboard_widgets as $widget_id => $options ) {
        wp_add_dashboard_widget(
            $widget_id,
            $options['title'],
            $options['callback']
        );
    }
}

?>