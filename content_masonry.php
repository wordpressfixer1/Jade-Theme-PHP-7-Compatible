<?php
/**
 * Post listing
 * @package metcreative
 */
global $get_post_format, $preview_data, $blog_listing_post_animation, $blog_listing_post_animation_data, $masonry_column_no, $grid_unique_class;

$blog_sidebar_position 	= met_option('blog_sidebar_position');
$media_type 			= rwmb_meta('met_content_media_type');
$media_height 			= rwmb_meta('met_media_height_listing');
$media_hardcrop 		= rwmb_meta('met_media_hardcrop_listing');
$get_post_format 		= get_post_format();
$masonry_column_width 	= $blog_sidebar_position == 'disable' ? array(1170,569,369,269) : array(770,369,236,169);
$preview_data['width'] 	= $masonry_column_width[($masonry_column_no-1)];
$preview_data['height'] = $media_height == 0 ? 190 : $media_height;
$preview_data['hardcrop'] = $media_hardcrop == 0 ? true : true;

if( $get_post_format == 'link' || $get_post_format == 'quote' ){
    $preview_data['width'] = 770;
    $preview_data['height'] = 380;
}

get_template_part('inc/template_single/post_preview_data');
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('met_blog_masonry_item met_isotope_item '.$blog_listing_post_animation.' '.$grid_unique_class); ?> <?php echo $blog_listing_post_animation_data; ?>>
	<div class="met_blog_masonry_item_preview"><?php get_template_part('inc/template_single/post_preview', $get_post_format) ?></div>

	<div class="met_blog_masonry_item_details">

		<?php if( $get_post_format != 'link' && $get_post_format != 'quote' ): ?>
		<header>
			<?php
			$category = get_the_category();
			if ($category) {
				echo '<div><a href="' . get_category_link( $category[0]->term_id ) . '"  class="met_color2 met_color_transition" title="' . sprintf( __( "View all posts in %s",'Jade' ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a></div>';
			}
			?>
			<?php get_template_part( 'inc/template_single/post_title', $get_post_format ) ?>
		</header>

		<section>
			<?php
                get_template_part('inc/template_single/post_content');

                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Jade' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );
                ?>
		</section>
		<?php endif; ?>

		<?php if( $get_post_format != 'link' AND $get_post_format != 'quote' ): ?>
		<footer class="clearfix">
			<div class="met_blog_masonry_item_socials">
				<?php
				$social_codes_output =  met_option('blog_detail_meta_socials_code');
				if($social_codes_markup = explode("\n",$social_codes_output)){
					foreach($social_codes_markup as $social_code_item){
						if($social_code_item_data = explode('|',$social_code_item,2)){
							$social_code_item_data[1] = str_replace('[post-title]',get_the_title(),$social_code_item_data[1]);
							$social_code_item_data[1] = str_replace('[permalink]',get_permalink(),$social_code_item_data[1]);

							printf('<a href="%2$s" class="met_color_transition2"><i class="fa %1$s"></i></a>',$social_code_item_data[0],$social_code_item_data[1]);
						}
					}
				}
				?>
			</div>

			<?php if(comments_open() || '0' != get_comments_number()): ?>
			<div class="met_blog_masonry_item_comments">
				<a href="<?php comments_link(); ?>" class="met_color_transition2"><i class="fa fa-comments"></i><?php comments_number( '0', '1', '%' ); ?></a>
			</div>
			<?php endif; ?>

			<div class="met_blog_masonry_item_readmore">
				<a href="<?php the_permalink() ?>" class="met_color2 met_color_transition"><?php _e('Read More','Jade') ?></a>
			</div>
		</footer>
		<?php endif; ?>

	</div>
</div>