<?php
/**
 * project detail
 * @package metcreative
 */

$project_overview = rwmb_meta('met_project_overview');

$content_box_class = ($project_overview) ? 'col-md-8' : 'col-md-12';

$recent_works_widget = true;
$mb_recent_works_widget = rwmb_meta(MET_MB_PREFIX.'project_recent_works_widget');
if( !empty($mb_recent_works_widget) AND $mb_recent_works_widget != '0'){
	$recent_works_widget = $mb_recent_works_widget;
}else{
	$recent_works_widget = met_option('project_detail_recent_works_widget');
}

global $preview_data;

$media_type = rwmb_meta('met_content_media_type');

if( !$project_overview ){
    $preview_data['width'] = 1170;
}else{
    $preview_data['width'] = 800;
}

$media_height = rwmb_meta('met_media_height_listing');
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

get_template_part('inc/template_single/post_preview_data');

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>

	<!-- Blog Details Starts -->
	<div class="col-md-12">

	    <div class="met_blog_detail_preview"><?php get_template_part('inc/template_single/post_preview') ?></div>

		<div class="row">
			<div class="<?php echo $content_box_class ?>">
				<h1 class="met_blog_detail_title"><?php the_title() ?></h1>

				<?php if( met_option('project_detail_meta_date') OR met_option('project_detail_meta_category') OR met_option('project_detail_meta_author') ): ?>
				<div class="met_blog_detail_info">
					<?php if( met_option('project_detail_meta_date') ) get_template_part('inc/template_single/meta_date') ?>

					<?php if( met_option('project_detail_meta_category') ) get_template_part('inc/template_single/meta_category') ?>

					<?php if( met_option('project_detail_meta_author') ) get_template_part('inc/template_single/meta_author') ?>
				</div>
				<?php endif; ?>

				<div class="met_blog_detail">
                    <?php get_template_part('inc/template_single/post_content') ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Jade' ), 'after' => '</div>' ) ); ?>
				</div>

				<?php if( met_option('project_detail_meta_socials') OR met_option('project_detail_meta_tags') ): ?>
				<div class="clearfix">
					<?php if( met_option('project_detail_meta_socials') ) get_template_part('inc/template_single/share') ?>

					<?php if( met_option('project_detail_meta_tags') ) get_template_part('inc/template_single/tags') ?>
				</div>
				<?php endif; ?>

				<?php if( met_option('project_detail_meta_authorbox') ) get_template_part('inc/template_single/authorbox') ?>

				<?php if( met_option('project_detail_comment_section') ) get_template_part('inc/template_single/comments') ?>
			</div>
			<?php if($project_overview): ?>
				<div class="col-md-4">
					<?php get_template_part('inc/template_single_project/overview_box') ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if( $recent_works_widget == 'true' OR $recent_works_widget == '1' ): ?>
			<div class="row">
				<div class="col-md-12"><?php get_template_part('inc/template_single_project/recent_works_widget') ?></div>
			</div>
		<?php endif; ?>

	</div><!-- Blog Details Ends -->

</div>