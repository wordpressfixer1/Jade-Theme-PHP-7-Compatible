<?php

// Register Module
function register_galleryslider_module() {
	return dslc_register_module( "MET_GallerySlider" );
}
add_action('dslc_hook_register_modules','register_galleryslider_module');

class MET_GallerySlider extends DSLC_Module {

    var $module_id = 'MET_GallerySlider';
    var $module_title = 'Thumbnail Navigated Slider';
    var $module_icon = 'info';
    var $module_category = 'met - gallery';

    function options() {

        $dslc_options = array(
			array(
				'label' => __( 'Gallery Post ID', 'dslc_string' ),
				'id' => 'gallery_post_id',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Show Thumbnails', 'dslc_string' ),
				'id' => 'show_thumbnails',
				'std' => 'true',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Yes',
						'value' => true,
					),
					array(
						'label' => 'No',
						'value' => false,
					),
				),
			),
			array(
				'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
				'id' => 'g_thumb_resize_width',
				'std' => '90',
				'min' => '10',
				'max' => '300',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
				'id' => 'g_thumb_resize_height',
				'std' => '90',
				'min' => '10',
				'max' => '300',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Crop Thumbnail', 'dslc_string' ),
				'id' => 'g_thumb_crop',
				'std' => true,
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => true
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => false
					),
				),
			),

			array(
				'label' => __( 'Image Resize - Width', 'dslc_string' ),
				'id' => 'f_thumb_resize_width',
				'std' => '300',
				'min' => '300',
				'max' => '1170',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Image Resize - Height', 'dslc_string' ),
				'id' => 'f_thumb_resize_height',
				'std' => '300',
				'min' => '300',
				'max' => '1170',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Crop Image', 'dslc_string' ),
				'id' => 'f_thumb_crop',
				'std' => true,
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => true
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => false
					),
				),
			),

			/*FlexSlider Options*/
			array(
				'label' => __( 'Slideshow', 'dslc_string' ),
				'id' => 'data_slideshow',
				'std' => 'false',
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
				'tab' => 'Slider Options',
			),
			array(
				'label' => __( 'Slideshow Speed (ms)', 'dslc_string' ),
				'id' => 'data_slideshowspeed',
				'std' => '5000',
				'min' => '1000',
				'max' => '10000',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => 'Slider Options',
				'ext' => '',
			),
			array(
				'label' => __( 'Smooth Height', 'dslc_string' ),
				'id' => 'data_smoothheight',
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
				'tab' => 'Slider Options',
			),
			array(
				'label' => __( 'Animation Loop', 'dslc_string' ),
				'id' => 'data_animationloop',
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
				'tab' => 'Slider Options',
			),
			array(
				'label' => __( 'Pause On Hover', 'dslc_string' ),
				'id' => 'data_pauseonhover',
				'std' => 'false',
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
				'tab' => 'Slider Options',
			),
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
        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
            echo '<script src="'.get_template_directory_uri().'/js/jquery.flexslider-min.js"></script>';

            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.flexslider-min.js"]';
        }else{
            wp_enqueue_script('metcreative-flexslider');
        }

        $elementID = uniqid('galleryslider_');

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

				$resized = array('url' => '');
				if($options['show_thumbnails']):
					$resized = imageResizing($imageURL,$options['g_thumb_resize_height'],$options['g_thumb_resize_width'],$options['g_thumb_crop']);
					if($resized == false) $resized = array('url' => $imageURL);
				endif;

				$resizedFull = array('url' => $imageURL);
				if($options['f_thumb_resize_height'] != '0' OR $options['f_thumb_resize_width'] != '0'){
					$resizedFull = imageResizing($imageURL,$options['f_thumb_resize_height'],$options['f_thumb_resize_width'],$options['f_thumb_crop']);
					if($resizedFull == false) $resizedFull = array('url'=>$imageURL);
				}

				$images[] = array('thumb' => $resized['url'], 'full' => $resizedFull['url']);
			endforeach;
			?>
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>

        <div id="<?php echo $elementID; ?>" class="met_gallery_slider">
            <div class="flexslider theSlider" data-smoothheight="<?php echo $options['data_smoothheight'] ?>" data-slideshow="<?php echo $options['data_slideshow'] ?>" data-slideshowspeed="<?php echo $options['data_slideshowspeed'] ?>" data-animationloop="<?php echo $options['data_animationloop'] ?>" data-pauseonhover="<?php echo $options['data_pauseonhover'] ?>" data-itemwidth="<?php echo $options['g_thumb_resize_width'] ?>">
				<?php if(count($images) > 0): $i = 1; ?>
                <ul class="slides">
					<?php foreach($images as $image): ?>
                    <li><img src="<?php echo $image['full'] ?>" /></li>
					<?php endforeach; ?>
                </ul>
				<?php endif; ?>
            </div>
			<?php if($options['show_thumbnails']): ?>
            <div class="flexslider theCarousel">
				<?php if(count($images) > 0): $i = 1; ?>
                <ul class="slides">
					<?php foreach($images as $image): ?>
						<li><img src="<?php echo $image['thumb'] ?>" /></li>
					<?php endforeach; ?>
                </ul>
				<?php endif; ?>
            </div>
			<?php endif; ?>
        </div>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["gallery_slider|<?php echo $elementID ?>"]);});</script>
		<?php endif; ?>

		<?php if ( $dslc_is_admin AND !$have_posts ) : ?>
			<div class="dslc-notification dslc-red">You do not have any galleries at the moment. Go to <strong>WP Admin &rarr; Galleries</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div>
		<?php endif; ?>

        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}