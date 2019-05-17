<nav>
	<?php
	$wp_main_nav_menu_args = array(
		'theme_location' => 'main_nav',
		'menu_id' => '' ,
		'menu_class' => 'met_primary_nav',
		'container' => '',
		'walker' => new Jade_Walker_Nav_Menu,
		'fallback_cb' => '',
	);

	if( defined('SIDENAV_CUSTOM_MENU') ) $wp_main_nav_menu_args['menu'] = SIDENAV_CUSTOM_MENU;

	wp_nav_menu($wp_main_nav_menu_args);
	?>
</nav>