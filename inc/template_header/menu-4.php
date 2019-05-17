<!-- Main Menu Starts -->
<nav class="hidden-1024 clearfix" role="navigation">
	<?php
	global $header_main_nav_menu;
	$wp_main_nav_menu_args = array(
		'theme_location' => 'main_nav',
		'menu_id' => '' ,
		'menu_class' => 'met_primary_nav clearfix met_primary_nav_metro met_header_menu',
		'container' => '',
		'walker' => new Jade_Walker_Nav_Menu,
		'fallback_cb' => ''
	);

	if($header_main_nav_menu !== false) $wp_main_nav_menu_args['menu'] = $header_main_nav_menu;
	wp_nav_menu($wp_main_nav_menu_args)
	?>
</nav><!-- Main Menu Ends -->