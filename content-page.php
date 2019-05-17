<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package metcreative
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('entry-content single-page'); ?>>

	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Jade' ), 'after' => '</div>' ) ); ?>

</div><!-- .entry-content -->