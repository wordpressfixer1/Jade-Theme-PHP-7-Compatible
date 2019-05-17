<?php
/**
 * Post listing
 * @package metcreative
 */

global $get_post_format, $preview_data, $blog_listing_post_animation, $blog_listing_post_animation_data;

$media_type = rwmb_meta('met_content_media_type');

if(met_option('blog_sidebar_position') == 'disable'){
	$preview_data['width'] = 410;
}else{
	$preview_data['width'] = 270;
}

$media_height = rwmb_meta('met_media_height_listing');
if($media_height == 0){
	$preview_data['height'] = 190;
}else{
	$preview_data['height'] = $media_height;
}

$media_hardcrop = rwmb_meta('met_media_hardcrop_listing');
if($media_hardcrop == 0){
	$preview_data['hardcrop'] = true;
}else{
	$preview_data['hardcrop'] = true;
}

$get_post_format = get_post_format();

if( $get_post_format == 'link' || $get_post_format == 'quote' ){
	$preview_data['width'] = 770;
	$preview_data['height'] = 380;
}

get_template_part('inc/template_single/post_preview_data');
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('met_blog_block clearfix '.($blog_listing_post_animation != 'none' ? 'met_run_animations '.$blog_listing_post_animation : '')); ?> <?php echo $blog_listing_post_animation_data ?>>
	<div class="met_blog_block_preview"><?php get_template_part('inc/template_single/post_preview', $get_post_format) ?></div>

	<?php if( $get_post_format != 'link' && $get_post_format != 'quote' ): ?>
		<div class="met_blog_block_details clearfix">

			<div class="met_blog_block_title_date">
				<?php get_template_part( 'inc/template_single/post_title', $get_post_format ) ?>

				<div class="met_blog_block_cats_date">
					<?php
					if(met_option('blog_listing_meta_category')):
						$categories_list = get_the_category_list( ',' );
						if ( $categories_list ) :
							$categories_list = str_replace('<a','<a class="met_blog_block_categories met_color2 met_color_transition" ',$categories_list);
							printf( '%1$s', $categories_list );
						endif; // End if categories
					endif; //show option
					?>

					<?php if(met_option('blog_listing_meta_date')) metcreative_post_meta_date(); ?>
				</div>
			</div>

			<div class="met_blog_block_text">
				<?php
				get_template_part('inc/template_single/post_content');

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Jade' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				?>
			</div>

			<div class="met_blog_block_metas clearfix">
				<?php if(met_option('blog_listing_meta_readmore')): ?>
					<?php if(get_post_format() != 'link' AND get_post_format() != 'quote'): ?>
						<a href="<?php the_permalink() ?>" class="met_blog_block_button met_bgcolor met_bgcolor_transition2 met_blog_readmore_but"><?php _e('Read More','Jade') ?></a>
					<?php endif; ?>
				<?php endif; ?>

				<?php if(met_option('blog_listing_meta_comments_number')): ?>
					<?php if(comments_open() || '0' != get_comments_number()): ?><a href="<?php comments_link(); ?>" class="pull-right met_blog_block_button met_blog_block_tags met_bgcolor_transition2"><?php comments_number( '<i class="dslc-icon dslc-icon-comment-alt"></i> 0', '<i class="dslc-icon dslc-icon-comments"></i> 1', '<i class="dslc-icon dslc-icon-comments-alt"></i> %' ); ?></a><?php endif; ?>
				<?php endif; ?>

				<?php $tagsDiv = ''; ?>
				<?php if(met_option('blog_listing_meta_tags')): ?>
					<?php
					$tags_list = get_the_tag_list();
					if($tags_list):
						$tags_list = str_replace('<a','<a class="met_blog_block_button met_blog_block_tag met_bgcolor_transition2" ',$tags_list);
						?>
						<a href="javascript:;" class="pull-right met_blog_block_button met_blog_block_tags met_tags_trigger met_bgcolor_transition2"><i class="dslc-icon dslc-icon-tags"></i> +</a>
						<?php $tagsDiv = '<div class="met_blog_block_tag_list">'.sprintf( '%1$s', $tags_list ).'</div>'; ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php if(met_option('blog_listing_meta_author')): ?>
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>" title="<?php _e('Author', 'Jade') ?>" class="met_blog_block_author met_blog_block_button met_blog_block_tags met_bgcolor_transition2">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
						<span><?php echo get_the_author() ?></span>
					</a>
				<?php endif; ?>
				<?php echo $tagsDiv; ?>
			</div>
		</div>
	<?php endif; ?>
</div>