<div class="met_header_links pull-right">
	<?php
	$wp_second_nav_menu_args = array(
		'theme_location' => 'second_nav',
		'menu_id' => '' ,
		'menu_class' => 'met_clean_list',
		'container' => '',
		'walker' => new jade_walker_nav_menu,
			'depth' => 1,
		'fallback_cb' => ''
	);

	wp_nav_menu($wp_second_nav_menu_args);
	?>
</div>
