<?php get_header(); ?>
<?php
	$mb_sidebar_status   = rwmb_meta(MET_MB_PREFIX.'page_custom_sidebar');
	$mb_sidebar_position = rwmb_meta(MET_MB_PREFIX.'page_sidebar_position');
?>

<?php if($mb_sidebar_status == 'true') echo '<div class="row">'; ?>

	<?php if($mb_sidebar_status == 'true' AND $mb_sidebar_position == 'left'): ?>
		<div class="col-md-4 page-sidebar page-sidebar-left"><?php generated_dynamic_sidebar(); ?></div>
	<?php endif; ?>

	<?php if($mb_sidebar_status == 'true') echo '<div class="col-md-8">'; ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
				if ( comments_open() || '0' != get_comments_number() ){
					comments_template();
				}
				?>

			<?php endwhile; // end of the loop. ?>
	<?php if($mb_sidebar_status == 'true') echo '</div>'; //end of col-md-8 ?>

	<?php if($mb_sidebar_status == 'true' AND $mb_sidebar_position == 'right'): ?>
		<div class="col-md-4 page-sidebar page-sidebar-right"><?php generated_dynamic_sidebar(); ?></div>
	<?php endif; ?>

<?php if($mb_sidebar_status == 'true') echo '</div>'; //end of row ?>

<?php get_footer(); ?>
