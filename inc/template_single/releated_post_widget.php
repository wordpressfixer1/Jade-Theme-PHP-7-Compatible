<?php
$orig_post = $post;
global $post;
$tags = wp_get_post_tags(get_the_ID());

if($tags):
	?>
	<div class="met_hard_line_split"></div>
	<div class="met_you_might_like">
		<h4><?php _e('You Might Also Liked','Jade') ?></h4>
		<div class="met_you_might_like_images clearfix">
			<?php

			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
				'tag__in' 			=> $tag_ids,
				'post__not_in' 		=> array(get_the_ID()),
				'posts_per_page'	=> 8,
				'caller_get_posts'	=> 1
			);

			$my_query = new wp_query( $args );

			while( $my_query->have_posts() ) {
				$my_query->the_post();
				$releated_thumbnail = aq_resize( wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()),'full'), 88, 88, true );
				?>

				<a href="<?php the_permalink()?>"><img src="<?php echo (($releated_thumbnail) ? $releated_thumbnail : get_template_directory_uri().'/img/post_nothumbnail88.png' ) ?>" alt="<?php echo esc_attr(get_the_title()) ?>" /></a>

			<?php }

			$post = $orig_post;
			wp_reset_query();
			?>
		</div>
	</div>
<?php endif; // Tag check ?>