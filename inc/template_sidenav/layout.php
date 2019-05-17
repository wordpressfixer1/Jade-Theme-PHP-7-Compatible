<?php
    if(met_option('sidenav_sticky')) wp_enqueue_script('metcreative-sticky');
?>
<div class="met_side_navbar_wrap hidden-1024" data-height="0">
	<div class="met_side_navbar <?php if(met_option('sidenav_sticky')) echo 'met_side_navbar_sticky' ?>">

		<?php if(met_option('sidenav_topbar_status')): ?>
			<div class="met_side_navbar_linkstop clearfix">
				<?php if(met_option('sidenav_secondary_menu_status')) get_template_part('inc/template_sidenav/second_menu') ?>
				<?php if(met_option('sidenav_lang_selector') AND function_exists('icl_get_languages')) get_template_part('inc/template_sidenav/language_selector') ?>
			</div>
		<?php endif; ?>

		<?php if(met_option('sidenav_logo_status')) get_template_part('inc/template_sidenav/logo') ?>

		<?php get_template_part('inc/template_sidenav/menu') ?>

		<?php if(met_option('sidenav_search')) get_template_part('inc/template_sidenav/search_form') ?>

		<?php if(met_option('sidenav_socials')) get_template_part('inc/template_sidenav/socials') ?>
	</div>
</div>
<script>
    jQuery(document).ready(function(){CoreJS.sideNavbar()});
    <?php if(met_option('sidenav_sticky')): ?>jQuery(window).load(function(){CoreJS.stickySideNav()});<?php endif; ?>
</script>