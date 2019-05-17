<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package metcreative
 */

get_header();
?>

	<!-- Search Results Header Starts -->
	<div class="row">
		<div class="col-md-12">
			<div class="met_search_results_header">
				<h4><?php echo get_search_query() ?></h4>
				<h5><?php _e('If you are not happy with the results below please do another search','Jade') ?></h5>

				<form class="met_bgcolor met_vcenter" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<div>
						<input name="s" type="text" required="" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'Jade' ); ?>" />
						<button type="submit"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- Search Results Header Ends -->

<div class="row">
	<div class="col-md-12">
		<?php if ( have_posts() ) : ?>
		<ul class="met_search_results met_clean_list">
		<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>
		</ul>

			<?php metcreative_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>