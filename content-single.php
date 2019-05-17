<?php
/**
 * blog content detail
 * @package metcreative
 */

global $preview_data;

$media_type = rwmb_meta('met_content_media_type');

if(met_option('blog_sidebar_position') == 'disable'){
    $preview_data['width'] = 1170;
}else{
    $preview_data['width'] = 775;
}

$media_height = rwmb_meta('met_media_height_detail');
if($media_height == 0){
    $preview_data['height'] = 450;
}else{
    $preview_data['height'] = $media_height;
}

$media_hardcrop = rwmb_meta('met_media_hardcrop_listing');
if($media_hardcrop == 0){
    $preview_data['hardcrop'] = false;
}else{
    $preview_data['hardcrop'] = true;
}

$get_post_format = get_post_format();
get_template_part('inc/template_single/post_preview_data');

	$dslc_template_id = dslc_st_get_template_ID(get_the_ID());
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>

	<?php if( is_int($dslc_template_id) AND $dslc_template_id > 0 ): ?>
		<?php the_content(); ?>
	<?php else: ?>
	<!-- Blog Details Starts -->
	<div class="col-md-8">

		<div class="met_blog_detail_preview"><?php get_template_part('inc/template_single/post_preview', $get_post_format) ?></div>

		<div class="met_blog_detail_info">
			<?php if( met_option('blog_detail_meta_date') ) get_template_part('inc/template_single/meta_date') ?>

			<?php if( met_option('blog_detail_meta_category') ) get_template_part('inc/template_single/meta_category') ?>

			<?php if( met_option('blog_detail_meta_author') ) get_template_part('inc/template_single/meta_author') ?>
		</div>

		<div class="met_blog_detail">
            <?php get_template_part('inc/template_single/post_content') ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Jade' ), 'after' => '</div>' ) ); ?>
		</div>

		<div class="clearfix">
			<?php if( met_option('blog_detail_meta_socials') ) get_template_part('inc/template_single/share') ?>

			<?php if( met_option('blog_detail_meta_tags') ) get_template_part('inc/template_single/tags') ?>
		</div>

		<?php if( met_option('blog_detail_meta_authorbox') ) get_template_part('inc/template_single/authorbox') ?>

		<?php if( met_option('blog_detail_releated_posts_widget') ) get_template_part('inc/template_single/releated_post_widget') ?>

		<?php if( met_option('blog_detail_comment_section') ) get_template_part('inc/template_single/comments') ?>

	</div><!-- Blog Details Ends -->

	<!-- Sidebar Starts -->
	<div class="col-md-4"><?php get_template_part('inc/template_single/sidebar') ?></div>
	<!-- Sidebar Ends -->

	<?php endif; ?>
</div>