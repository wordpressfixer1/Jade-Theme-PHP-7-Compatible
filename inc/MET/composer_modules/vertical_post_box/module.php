<?php

// Register Module
function register_vpostbox_module() {
	return dslc_register_module( "MET_VerticalPostBox" );
}
add_action('dslc_hook_register_modules','register_vpostbox_module');

class MET_VerticalPostBox extends DSLC_Module {

    var $module_id = 'MET_VerticalPostBox';
    var $module_title = 'Single Vertical';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

        $dslc_options = array(
			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'title category date thumbnail excerpt',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Category', 'dslc_string' ),
						'value' => 'category'
					),
                    array(
                        'label' => __( 'Date', 'dslc_string' ),
                        'value' => 'date'
                    ),
                    array(
                        'label' => __( 'Author', 'dslc_string' ),
                        'value' => 'author'
                    ),
					array(
						'label' => __( 'Thumbnail', 'dslc_string' ),
						'value' => 'thumbnail'
					),
					array(
						'label' => __( 'Excerpt', 'dslc_string' ),
						'value' => 'excerpt'
					),
                    array(
                        'label' => __( 'Read More', 'dslc_string' ),
                        'value' => 'read_more'
                    ),
				)
			),
			array(
				'label' => __( 'Post ID', 'dslc_string' ),
				'id' => 'pid',
				'std' => '',
				'type' => 'text'
			),
			array(
				'label' => __( 'Excerpt or Content', 'dslc_string' ),
				'id' => 'excerpt_or_content',
				'std' => 'excerpt',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Excerpt', 'dslc_string' ),
						'value' => 'excerpt'
					),
					array(
						'label' => __( 'Content', 'dslc_string' ),
						'value' => 'content'
					),
				),
				'tab' => 'Excerpt'
			),
			array(
				'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
				'id' => 'excerpt_length',
				'std' => '17',
				'type' => 'text',
				'tab' => 'Excerpt'
			),
			array(
				'label' => __( 'Resize - Height', 'dslc_string' ),
				'id' => 'thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail'
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
				'visibility' => 'hidden'
			),
        );

        $dslc_options = array_merge(
            $dslc_options,

			// Box
			lc_general('.met_vertical_post_box', '', array('background-color' => '#EFEEE9')),
			lc_paddings('.met_vertical_post_box', '', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),
			lc_margins('.met_vertical_post_box', '', array('t' => '0', 'r' => '0', 'b' => '0', 'l' => '0')),

            // Title
            lc_general('.met_blog_block_title h2', 'Title', array('color' => '#373B3D', 'color:hover' => '', 'font-size' => '24', 'line-height' => '28', 'font-weight' => '400','text-align' => '')),

            // Content
            lc_general('.met_blog_block_text', 'Content', array('color' => '#888381', 'font-size' => '13', 'line-height' => '22', 'font-weight' => '400','text-align' => '')),

            // Category
            lc_general('.met_blog_block_cats_date .met_color2', 'Category', array('color' => '', 'font-size' => '12', 'line-height' => '12', 'font-weight' => '400')),

			// Date
			lc_general('.met_post_meta_date', 'Date', array('color' => '', 'font-size' => '12', 'line-height' => '12', 'font-weight' => '400')),

            // Author
            lc_general('.byline,.byline a', 'Author', array('color' => '', 'font-size' => '12', 'line-height' => '12', 'font-weight' => '400')),

            // Read More
			lc_general('.met_blog_block_readmore_text', 'Date', array('color' => '', 'color:hover' => '', 'font-size' => '12', 'line-height' => '16', 'font-weight' => '400'))
        );

        $dslc_options = array_merge( $dslc_options, $this->presets_options() );
		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

    }

    function output( $options ) {

        global $dslc_active;

        if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
            $dslc_is_admin = true;
        else
            $dslc_is_admin = false;


        $this->module_start( $options );
        /* Module output starts here */

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('verticalpostbox_');

		$args = array(
			'posts_per_page' => 1,
			'p' => $options['pid'],
			'post_type' => 'any'
		);
		$dslc_query = new WP_Query($args);
        ?>

		<?php if ( $dslc_query->have_posts() ) : ?>
			<?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
				<?php
				/**
				 * Manual Resize
				 */

				$item_preview_width = 150;

				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				$thumb_url = $thumb_url[0];
                $resizedImage['url'] = '';

                if ( ! empty( $thumb_url ) ) :
                    $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                endif;

                if(!empty($options['thumb_resize_width_manual'])) $item_preview_width = $options['thumb_resize_width_manual'];

				$item_preview_width_style = 'width:'.$item_preview_width.'px;';
				if(empty( $thumb_url ) OR !in_array( 'thumbnail', $elements )){
					$item_preview_width = 0;
				}
				$item_details_margin_left_style = 'margin-left:'.$item_preview_width.'px;';

				?>
				<div class="met_vertical_post_box clearfix">
					<?php if(!empty( $thumb_url ) AND in_array( 'thumbnail', $elements )): ?>
					<div class="met_blog_block_preview" style="<?php echo $item_preview_width_style ?>">
						<a href="<?php the_permalink() ?>"><img src="<?php echo $resizedImage['url']; ?>" alt="<?php echo esc_attr(get_the_title()) ?>" /></a>
					</div>
					<?php endif; ?>

					<div class="met_blog_block_details clearfix" style="<?php echo $item_details_margin_left_style; ?>">

						<div class="met_blog_block_cats_date">
							<?php
							if(in_array( 'category', $elements )):
								$categories_list = get_the_category_list( ',' );
								if ( $categories_list ) :
									$categories_list = str_replace('<a','<a class="met_color2 met_color_transition" ',$categories_list);
									printf( '%1$s', $categories_list );
								endif; // End if categories
							endif;
							?>
							<?php if(in_array( 'date', $elements )): ?>
								<?php metcreative_post_meta_date(); ?>
							<?php endif; ?>
                            <?php if(in_array( 'author', $elements )): ?>
                                <?php metcreative_post_meta_author(); ?>
                            <?php endif; ?>
						</div>

						<?php if(in_array( 'title', $elements )): ?>
							<a href="<?php the_permalink() ?>" class="met_blog_block_title"><h2 class="met_color_transition2"><?php the_title() ?></h2></a>
						<?php endif; ?>

						<?php if(in_array( 'excerpt', $elements )): ?>
						<div class="met_blog_block_text">
							<?php if ( $options['excerpt_or_content'] == 'content' ) : ?>
								<?php the_content(); ?>
							<?php else : ?>
								<?php echo do_shortcode( wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ) ); ?>
							<?php endif; ?>
						</div>
						<?php endif; ?>

                        <?php if(in_array( 'read_more', $elements )): ?>
                            <a href="<?php the_permalink() ?>" class="met_color2 met_blog_block_readmore_text met_color_transition"><?php _e( 'Read More', 'Jade' ); ?> <i class="dslc-icon dslc-icon-long-arrow-right"></i></a>
                        <?php endif; ?>
					</div>

				</div>
			<?php endwhile; wp_reset_query(); ?>
		<?php
		else : //there is no post
			if ( $dslc_is_admin ) :
				?><div class="dslc-notification dslc-red">You do not have content at the moment. Go to <strong>WP Admin</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
			endif;

		endif;
		?>

        <?php
        /* Module output ends here */
        $this->module_end( $options );

    }

}