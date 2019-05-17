<?php

// Register Module
function register_galthumgrid_module() {
	return dslc_register_module( "MET_GalleryThumbGrid" );
}
add_action('dslc_hook_register_modules','register_galthumgrid_module');

class MET_GalleryThumbGrid extends DSLC_Module {

    var $module_id = 'MET_GalleryThumbGrid';
    var $module_title = 'Thumbnail Grid';
    var $module_icon = 'info';
    var $module_category = 'met - gallery';

    function options() {

		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'dslc_galleries'
		);
		$dslc_query = new WP_Query($args);

		if ( $dslc_query->have_posts() ){
			while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
				$posts_data[] = array('id' => get_the_ID() ,'title' => get_the_title());
			endwhile;
		}
		wp_reset_query();
		$post_choices = array();

		if ( isset($post_data) && $posts_data ) {
			foreach ( $posts_data as $post_data ) {
				$post_choices[] = array(
					'label' => $post_data['title'],
					'value' => $post_data['id']
				);
			}
		}

		$dslc_options = array(
			array(
				'label' => __( 'Gallery', 'dslc_string' ),
				'id' => 'gallery_post_id',
				'std' => '',
				'type' => 'select',
				'choices' => $post_choices
			),
			array(
				'label' => __( 'Enable Lightbox', 'dslc_string' ),
				'id' => 'lightbox',
				'std' => true,
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
				'label' => __( 'Column Size', 'dslc_string' ),
				'id' => 'column_size',
				'std' => '10',
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
				'std' => '380',
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
				'std' => '380',
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
		);

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('li', '', array('background-color' => '')),

			lc_borders('li', '', array(), array(), '1', '#F0F0F0', 'solid' ),

			lc_paddings('li', '', array('t' => '3', 'r' => '3', 'b' => '3', 'l' => '3'))
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

		if($options['lightbox']):
        	$asyncScripts = "[]";
		endif;

        $elementID = uniqid('gallerythumbgrid_');

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

					$resized = imageResizing($imageURL,$options['g_thumb_resize_height'],$options['g_thumb_resize_width'],$options['g_thumb_crop']);
					if($resized == false) $resized = array('url' => $imageURL);

					$images[] = array('thumb' => $resized['url'], 'full' => $imageURL);
				endforeach;
				?>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>

        <ul id="<?php echo $elementID; ?>" class="met_gallery_thumb_grid <?php echo ($options['lightbox']) ? 'met_gallery_thumb_grid_lightbox_enabled' : '' ?> clearfix cols_<?php echo $options['column_size'] ?>">
			<?php if(count($images) > 0): $i = 1; ?>
				<ul class="slides">
					<?php foreach($images as $image): ?>
						<li><a href="<?php echo $image['full'] ?>"><img src="<?php echo $image['thumb'] ?>" /></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
        </ul>
		<?php if($options['lightbox']): ?>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["gallery_thumb_lb|<?php echo $elementID ?>"]);});</script>
		<?php endif; ?>

		<?php endif; ?>

		<?php if ( $dslc_is_admin AND !$have_posts ) : ?>
			<div class="dslc-notification dslc-red">You do not have any galleries at the moment. Go to <strong>WP Admin &rarr; Galleries</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div>
		<?php endif; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}