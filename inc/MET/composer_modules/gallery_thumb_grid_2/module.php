<?php

// Register Module
function register_galthumbgridtwo_module() {
	return dslc_register_module( "MET_GalleryThumbGrid2" );
}
add_action('dslc_hook_register_modules','register_galthumbgridtwo_module');

class MET_GalleryThumbGrid2 extends DSLC_Module {

    var $module_id = 'MET_GalleryThumbGrid2';
    var $module_title = 'Rotating Grid';
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
				'label' => __( 'Column Size', 'dslc_string' ),
				'id' => 'column_size',
				'std' => '5',
				'min' => '2',
				'max' => '10',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
				'id' => 'g_thumb_resize_width',
				'std' => '70',
				'min' => '10',
				'max' => '500',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
				'id' => 'g_thumb_resize_height',
				'std' => '70',
				'min' => '10',
				'max' => '500',
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
				'label' => __( 'Cover Resize - Width', 'dslc_string' ),
				'id' => 'f_thumb_resize_width',
				'std' => '0',
				'min' => '100',
				'max' => '1170',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Cover Resize - Height', 'dslc_string' ),
				'id' => 'f_thumb_resize_height',
				'std' => '0',
				'min' => '100',
				'max' => '1170',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'ext' => '',
			),
			array(
				'label' => __( 'Crop Cover', 'dslc_string' ),
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

			/*Slide Options*/
			array(
				'label' => __( 'Slideshow', 'dslc_string' ),
				'id' => 'data_slideshow',
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
				'tab' => 'Slideshow Options',
			),
			array(
				'label' => __( 'Animation Speed (ms)', 'dslc_string' ),
				'id' => 'data_slideshowspeed',
				'std' => '500',
				'min' => '100',
				'max' => '10000',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => 'Slideshow Options',
				'ext' => '',
			),
			array(
				'label' => __( 'Slideshow Speed (ms)', 'dslc_string' ),
				'id' => 'data_slideshowpause',
				'std' => '5000',
				'min' => '500',
				'max' => '10000',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => 'Slideshow Options',
				'ext' => '',
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

        $elementID = uniqid('gallerythumbgrid2_');

		$have_posts = false;

		// General args
		$args = array(
			'post_type' => 'dslc_galleries'
		);

		if(!empty($options['gallery_post_id'])) $args['p'] = $options['gallery_post_id'];

		// Do the query
		$dslc_query = new WP_Query( $args );
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
					$resized = imageResizing($imageURL,$options['g_thumb_resize_height'],$options['g_thumb_resize_width'],$options['g_thumb_crop']);
					if($resized == false) $resized = array('url' => $imageURL);

					$resizedFull = array('url' => $imageURL);
					if($options['f_thumb_resize_height'] != '0' OR $options['f_thumb_resize_width'] != '0'){
						$resizedFull = imageResizing($imageURL,$options['f_thumb_resize_height'],$options['f_thumb_resize_width'],$options['f_thumb_crop']);
						if($resizedFull == false) $resizedFull = array('url'=>$imageURL);
					}

					$images[] = array('thumb' => $resized['url'], 'cover' => $resizedFull['url'], 'full' => $imageURL);
				endforeach;
				?>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>

        <div id="<?php echo $elementID; ?>" class="met_gallery_thumb_grid_2 clearfix" data-slideshow="<?php echo $options['data_slideshow'] ?>" data-pause="<?php echo $options['data_slideshowpause'] ?>" data-speed="<?php echo $options['data_slideshowspeed'] ?>">
			<?php if(count($images) > 0): ?>
				<ul class="big_caption clearfix">
					<?php foreach($images as $image): ?>
						<li><a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['cover'] ?>" /></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if(count($images) > 0): ?>
				<ul class="met_gallery_thumb_grid clearfix cols_<?php echo $options['column_size'] ?>">
					<?php foreach($images as $image): ?>
						<li><img src="<?php echo $image['thumb'] ?>" /></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
        </div>

		<?php endif; ?>

		<?php if ( $dslc_is_admin AND !$have_posts ) : ?>
			<div class="dslc-notification dslc-red">You do not have any galleries at the moment. Go to <strong>WP Admin &rarr; Galleries</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div>
		<?php endif; ?>

        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["gallery_thumb_grid_2|<?php echo $elementID ?>"]);});</script>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}