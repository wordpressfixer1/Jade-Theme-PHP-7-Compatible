<?php
	require_once get_template_directory()."/inc/template_responsive/menu_walker.php";

	global $header_main_nav_menu;
?>
<!-- Mobile Bar Closer Starts -->
<div id="met_mobile_bar_closer">X</div>
<div id="met_mobile_bar_bottom_button"><i class="fa fa-align-justify"></i></div>
<!-- Mobile Bar Closer Ends -->

<div id="met_mobile_bar" class="visible-1024">
	<div>

		<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"  class="met_search_on_menu">
			<input type="text" name="s" required="" placeholder="<?php _e('Search','Jade') ?>">
			<button type="submit"><i class="fa fa-search"></i></button>
		</form><!-- .met_search_on_menu -->

		<!-- Mobile Menu Starts -->
		<?php

			$wp_responsive_nav_menu_args = array(
				'theme_location' => 'main_nav',
				'menu_id' => 'met_mobile_menu' ,
				'menu_class' => 'met_clean_list',
				'container' => '',
				'walker' => new Jade_Responsive_Nav_Menu,
				'fallback_cb' => ''
			);

			if($header_main_nav_menu !== false) $wp_responsive_nav_menu_args['menu'] = $header_main_nav_menu;

			wp_nav_menu($wp_responsive_nav_menu_args);

		?>
		<!-- #met_mobile_menu -->

	</div>
</div><!-- #met_mobile_bar -->

<script>jQuery(document).ready(function(){CoreJS.responsiveUtilities()})</script>