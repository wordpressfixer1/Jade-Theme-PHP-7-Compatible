<?php
/**
 * The Template for displaying all single projects.
 *
 * @package metcreative
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php if ( get_post_meta( get_the_ID(), 'dslc_code', true ) || isset( $_GET['dslc'] ) ) { ?>
	<?php the_content() ?>
	<?php } else { ?>
	<?php get_template_part( 'project', 'single' ); ?>
	<?php } ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>