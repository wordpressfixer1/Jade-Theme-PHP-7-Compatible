<?php
$menu_wrapper_class = '';
$nav_class = '';
if(met_option('header_layout') == 1){
    wp_enqueue_script('metcreative-imagesLoaded');
    ?><script>jQuery(function(){CoreJS.header_1_nav_padding()})</script><?php
}elseif(met_option('header_layout') == 3){
	$menu_wrapper_class = 'clearfix';
}elseif(met_option('header_layout') == 5){
	$menu_wrapper_class = 'clearfix met_primary_nav_black';
	$nav_class = 'clearfix';
}elseif(met_option('header_layout') == 4){
	$nav_class = 'clearfix met_content';
}

global $header_main_nav_menu;
if( met_option('header_layout') == '4' && !met_option('boxed_layout') ) echo '<div class="met_header_id_4_bottom_wrap">';
?>
<!-- Main Menu Starts -->
<nav class="hidden-1024 <?php echo $nav_class; ?>" role="navigation">
	<?php

	$wp_main_nav_menu_args = array(
		'theme_location' => 'main_nav',
		'menu_id' => '' ,
		'menu_class' => 'met_primary_nav met_header_menu '.$menu_wrapper_class,
		'container' => '',
		'walker' => new Jade_Walker_Nav_Menu,
		'fallback_cb' => ''
	);

	if($header_main_nav_menu !== false) $wp_main_nav_menu_args['menu'] = $header_main_nav_menu;

	wp_nav_menu($wp_main_nav_menu_args);


    if(met_option('header_layout') == '4'){
        get_template_part('inc/template_header/language_selector');
        get_template_part('inc/template_header/search_form');
    }

	?>
</nav><!-- Main Menu Ends -->
<?php
if( met_option('header_layout') == '4' && !met_option('boxed_layout') ) echo '</div>';