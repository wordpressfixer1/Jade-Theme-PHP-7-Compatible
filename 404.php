<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package metcreative
 */

get_header();
?>

	<div class="met_404_wrap">
		<div class="met_404">
			<h3><?php _e('404 page not found.','Jade') ?></h3>
			<h4><?php _e('please search again from below','Jade') ?></h4>

			<form method="get" id="searchform" class="searchform met_bgcolor" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
				<input name="s" type="text" placeholder="<?php _e('Search','Jade') ?>" required="">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
	</div>


<?php get_footer(); ?>