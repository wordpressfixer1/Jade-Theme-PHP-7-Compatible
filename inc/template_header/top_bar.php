<?php if(met_option('header_layout') != 1): ?>
<!-- Header Bar Starts -->
<div class="met_header_bar hidden-480">
	<div class="met_content clearfix">
		<?php get_template_part('inc/template_header/socials') ?>

		<?php get_template_part('inc/template_header/language_selector') ?>

        <?php if(met_option('header_layout') != 3) get_template_part('inc/template_header/search_form') ?>

		<?php get_template_part('inc/template_header/second_menu') ?>
	</div>
</div><!-- Header Bar Ends -->
<?php endif; ?>
