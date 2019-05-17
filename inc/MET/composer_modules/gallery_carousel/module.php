<?php

// Register Module
function register_galcara_module() {
	return dslc_register_module( "MET_GalleryCarousel" );
}
add_action('dslc_hook_register_modules','register_galcara_module');

class MET_GalleryCarousel extends DSLC_Module {

    var $module_id = 'MET_GalleryCarousel';
    var $module_title = 'Bar Queue';
    var $module_icon = 'info';
    var $module_category = 'met - gallery';

    function options() {

        $dslc_options = array(
            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'title nav',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Navigation', 'dslc_string' ),
                        'value' => 'nav'
                    ),
                )
            ),

			array(
				'label' => __( 'Module Title', 'dslc_string' ),
				'id' => 'module_title',
				'std' => 'PHOTO GALLERY',
				'type' => 'text',
			),

			array(
				'label' => __( 'Gallery Post ID', 'dslc_string' ),
				'id' => 'gallery_post_id',
				'std' => '',
				'type' => 'text',
			),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '154',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '154',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
			array(
				'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
				'id' => 'g_thumb_resize_height',
				'std' => '154',
				'type' => 'text'
			),

			array(
				'label' => __( 'Column Size', 'dslc_string' ),
				'id' => 'column_size',
				'std' => '5',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '5',
						'value' => '5',
					),
					array(
						'label' => '4',
						'value' => '4',
					),
					array(
						'label' => '3',
						'value' => '3',
					),
				),
			),

			array(
				'label' => __( 'Speed', 'dslc_string' ),
				'id' => 'speed',
				'std' => '500',
				'type' => 'text',
			),
			array(
				'label' => __( 'Auto Slide', 'dslc_string' ),
				'id' => 'auto_slide',
				'std' => 'true',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Yes',
						'value' => 'true',
					),
					array(
						'label' => 'No',
						'value' => 'false',
					),
				),
			),
			array(
				'label' => __( 'Pause', 'dslc_string' ),
				'id' => 'pause',
				'std' => '5000',
				'type' => 'text',
			),

			array(
				'label' => __( 'Lightbox Support', 'dslc_string' ),
				'id' => 'lightbox',
				'std' => 'true',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Yes',
						'value' => 'true',
					),
					array(
						'label' => 'No',
						'value' => 'false',
					),
				),
			),

        );

		$dslc_options = array_merge(
			$dslc_options,

			// Wrapper
			lc_general('.met_gallery_grid', '', array('background-color' => ''), 'Box'),

			// Title
			lc_general('.met_gallery_grid_row > article span', 'Title', array('color' => '#FFFFFF','font-size' => '24','line-height' => '22','font-weight' => '600'), 'Title'),

			// Nav
			lc_general('.met_gallery_grid_row > article .prev, .met_gallery_grid_row > article .next', 'Navigation', array('width' => '50','height' => '50','color' => '#FFFFFF','font-size' => '15','line-height' => '50','font-weight' => '400'), 'Navigation')


		);

		$dslc_options = met_lc_extras($dslc_options, array('animation'), 'shared_options');

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

        /* Animation */
        

        $met_shared_options = met_lc_extras( $options, array(
            'groups'   => array('animation'),
            'params'   => array(
                'js'           => false,
                'css'          => false,
                'external_run' => false,
                'is_grid'      => false,
            ),
            'is_admin' => $dslc_is_admin,
        ), 'shared_options_output' );

        if ( !$dslc_is_admin && $met_shared_options['activity'] ){
            wp_enqueue_style('metcreative-animate');
            wp_enqueue_script('metcreative-wow');
        }

        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.bxslider.min.js"]';
        }else{
            wp_enqueue_script('metcreative-bxslider');
        }


        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();

        $elementID = uniqid('gallerycarousel_');

		// General args
		$args = array(
			'post_type' => 'dslc_galleries'
		);

		if(!empty($options['gallery_post_id'])) $args['p'] = $options['gallery_post_id'];

		// Do the query
		$dslc_query = new WP_Query( $args );
		$have_posts = false;
        ?>

		<?php if ( $dslc_query->have_posts() ) $have_posts = true; ?>

		<?php if($have_posts): ?>
			<?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
				<?php
					$gallery_images = get_post_meta( get_the_ID(), 'dslc_gallery_images', true );
					$gallery_images_count = 0;

					if ( $gallery_images )
						$gallery_images = explode( ' ', trim( $gallery_images ) );

					$images = array();
					foreach ( $gallery_images as $gallery_image ) :
						$imageURL = wp_get_attachment_image_src( $gallery_image, 'full' );
						$imageURL = $imageURL[0];

						$resized = imageResizing($imageURL,$options['g_thumb_resize_height'],$options['thumb_resize_width_manual']);
						if($resized == false) $resized = $imageURL;
						$images[] = array('thumb' => $resized['url'], 'full' => $imageURL);
					endforeach;
				?>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>

			<div id="<?php echo $elementID; ?>" class="met_gallery_grid met_bgcolor cols_<?php echo $options['column_size'] ?> clearfix <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?> data-cols="<?php echo $options['column_size'] ?>" data-auto="<?php echo $options['auto_slide'] ?>" data-speed="<?php echo $options['speed'] ?>" data-pause="<?php echo $options['pause'] ?>">
				<div class="met_gallery_grid_row clearfix">
					<article class="met_gallery_grid_nav_holder">
						<span><?php echo $options['module_title'] ?></span>
						<nav>
							<a href="#" class="next"><i class="dslc-icon dslc-icon-chevron-left"></i></a>
							<a href="#" class="prev"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
						</nav>
					</article>
					<?php if(count($images) > 0): $i = 1; ?>
						<div class="met_gallery_grid_first_row_wrap">
							<div class="met_gallery_grid_first_row clearfix">
								<?php foreach($images as $image): ?>
									<a class="met_gallery_grid_item" href="<?php echo $image['full'] ?>" data-lightboxid="<?php echo $i ?>"><img src="<?php echo $image['thumb'] ?>" alt="" /><span class="met_bgcolor"><i class="dslc-icon dslc-icon-plus"></i></span></a>
								<?php $i++; endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["gallery_grid|<?php echo $elementID ?>"]);});</script>
            <?php echo $met_shared_options['script']; ?>
		<?php endif; ?>

		<?php if ( $dslc_is_admin AND !$have_posts ) : ?>
				<div class="dslc-notification dslc-red">You do not have any galleries at the moment. Go to <strong>WP Admin &rarr; Galleries</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div>
		<?php endif; ?>


        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}