<?php
	global $footer_nav_menu;

	$wp_footer_menu_args = array(
		'theme_location' => 'footer_nav',
		'menu_id' => 'footer_menu' ,
		'menu_class' => 'met_footer_menu met_clean_list ',
		'container' => '',
		'fallback_cb' => '',
		'depth' => 1
	);

	if( $footer_nav_menu !== false ) $wp_footer_menu_args['menu'] = $footer_nav_menu;

	wp_nav_menu($wp_footer_menu_args)
?>