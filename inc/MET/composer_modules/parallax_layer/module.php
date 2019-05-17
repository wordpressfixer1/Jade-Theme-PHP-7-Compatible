<?php
// Register Module
function register_paralayer_module() {
	return dslc_register_module( "MET_ParallaxLayer" );
}
add_action('dslc_hook_register_modules','register_paralayer_module');

class MET_ParallaxLayer extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'MET_ParallaxLayer';
		$this->module_title = __( 'Parallax Layer', 'dslc_string' );
		$this->module_icon = 'picture';
		$this->module_category = 'met - general';

	}

	function options() {

		$dslc_options = array(

			array(
				'label' => __( 'Image', 'dslc_string' ),
				'id' => 'image',
				'std' => '',
				'type' => 'image',
			),
			array(
				'label' => __( 'Resize - Height', 'dslc_string' ),
				'id' => 'resize_height',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'resize_width',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Crop', 'dslc_string' ),
				'id' => 'resize_crop',
				'std' => 'false',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'false'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => 'true'
					),
				),
			),
			array(
				'label' => __( 'Opacity', 'dslc_string' ),
				'id' => 'layer_opacity',
				'std' => '1',
				'type' => 'select',
				'section' => 'styling',
				'choices' => array(
					array( 'label' => '0.1', 'value' => '0.1' ),
					array( 'label' => '0.2', 'value' => '0.2' ),
					array( 'label' => '0.3', 'value' => '0.3' ),
					array( 'label' => '0.4', 'value' => '0.4' ),
					array( 'label' => '0.5', 'value' => '0.5' ),
					array( 'label' => '0.6', 'value' => '0.6' ),
					array( 'label' => '0.7', 'value' => '0.7' ),
					array( 'label' => '0.8', 'value' => '0.8' ),
					array( 'label' => '0.9', 'value' => '0.9' ),
					array( 'label' => '1.0', 'value' => '1' ),
				),
				'refresh_on_change' => true,
				'affect_on_change_el' => ' ',
				'affect_on_change_rule' => 'opacity',
				'help' => __( 'Moving speed of the element is relative to the scroll speed.', 'dslc_string' ),
			),

			array(
				'label' => __( 'Position (X)', 'dslc_string' ),
				'id' => 'parallax_pos_x',
				'std' => '0',
				'tab' => 'Position',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => ' ',
				'affect_on_change_rule' => 'left',
				'min' => '0',
				'max' => '100',
				'ext' => '%',
			),
			array(
				'label' => __( 'Position (Y)', 'dslc_string' ),
				'id' => 'parallax_pos_y',
				'std' => '0',
				'tab' => 'Position',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => ' ',
				'affect_on_change_rule' => 'top',
				'min' => '0',
				'max' => '100',
				'ext' => '%',
			),
			array(
				'label' => __( 'Position (Z)', 'dslc_string' ),
				'id' => 'parallax_pos_z',
				'std' => '0',
				'tab' => 'Position',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => ' ',
				'affect_on_change_rule' => 'z-index',
				'min' => '0',
				'max' => '100',
				'ext' => '',
			),

			array(
				'label' => __( 'Parallax Speed', 'dslc_string' ),
				'id' => 'parallax_speed',
				'std' => '1',
				'type' => 'select',
				'tab' => 'Parallax',
				'choices' => array(
					array( 'label' => '0.1 (Slowest)', 'value' => '0.1' ),
					array( 'label' => '0.2', 'value' => '0.2' ),
					array( 'label' => '0.3', 'value' => '0.3' ),
					array( 'label' => '0.4', 'value' => '0.4' ),
					array( 'label' => '0.5 (Half-Speed)', 'value' => '0.5' ),
					array( 'label' => '0.6', 'value' => '0.6' ),
					array( 'label' => '0.7', 'value' => '0.7' ),
					array( 'label' => '0.8', 'value' => '0.8' ),
					array( 'label' => '0.9', 'value' => '0.9' ),
					array( 'label' => '1.0 (Natural)', 'value' => '1' ),
					array( 'label' => '1.1', 'value' => '1.1' ),
					array( 'label' => '1.2', 'value' => '1.2' ),
					array( 'label' => '1.3', 'value' => '1.3' ),
					array( 'label' => '1.4', 'value' => '1.4' ),
					array( 'label' => '1.5', 'value' => '1.5' ),
					array( 'label' => '1.6', 'value' => '1.6' ),
					array( 'label' => '1.7', 'value' => '1.7' ),
					array( 'label' => '1.8', 'value' => '1.8' ),
					array( 'label' => '1.9', 'value' => '1.9' ),
					array( 'label' => '2 (Fastest)', 'value' => '2' ),
				),
				'refresh_on_change' => true,
				'help' => __( 'Moving speed of the element is relative to the scroll speed.', 'dslc_string' ),
			),
			array(
				'label' => __( 'Vertical Offset', 'dslc_string' ),
				'id' => 'parallax_vertical_offset',
				'std' => '0',
				'type' => 'text',
				'tab' => 'Parallax',
				'help' => __( 'All elements will return to their original positioning when their offset parent meets the edge of the screen—plus or minus your own optional offset.', 'dslc_string' ),
			),
			/*
			array(
				'label' => __( 'Horizontal Offset', 'dslc_string' ),
				'id' => 'parallax_horizontal_offset',
				'std' => '100',
				'type' => 'text',
				'tab' => 'Parallax',
				'help' => __( 'All elements will return to their original positioning when their offset parent meets the edge of the screen—plus or minus your own optional offset.', 'dslc_string' ),
			),
			*/
		);

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		$this->module_start( $options );

		/* Module output starts here */

			global $dslc_active;

			if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
				$dslc_is_admin = true;
			else
				$dslc_is_admin = false;

		$asyncScripts = "[]";
		if ( $dslc_is_admin )
			$asyncScripts = '["'.get_template_directory_uri().'/js/jquery.stellar.min.js"]';
		else
			wp_enqueue_script('metcreative-stellar');




		if( empty($options['parallax_vertical_offset']) ) $options['parallax_vertical_offset'] = 0;

			$el_attr = array();

			/* Parallax */
			$el_attr[] = 'data-metparallax-element';
			//$el_attr[] = 'data-stellar-offset-parent="true"';
			$el_attr[] = 'data-metparallax-ratio="'.$options['parallax_speed'].'"';
			//$el_attr[] = 'data-metparallax-ratio="1"';
			$el_attr[] = 'data-metparallax-vertical-offset="'.$options['parallax_vertical_offset'].'"';
			//$el_attr[] = 'data-metparallax-horizontal-offset="'.$options['parallax_horizontal_offset'].'"';

			$elID = uniqid('parallaxlayer');
			?>

			<span id="<?php echo $elID; ?>" class="met_parallax_layer_item">
				<span class="met_parallax_layer_data" <?php echo implode(' ', $el_attr); ?>></span>

				<?php

					if ( empty( $options['image'] ) ){
						$the_image = 'http://placehold.it/200x200&text=Parallax+Layer';
					}else{
						$the_image = $options['image'];
					}

					$resize = false;

					$the_dimensions = false;

					if ( $options['resize_width'] != '' || $options['resize_height'] != '' ) {

						$resize = true;
						$resize_width = false;
						$resize_height = false;

						if ( $options['resize_width'] != '' ){
							$resize_width = $options['resize_width'];
							$the_dimensions .= 'width:'.$resize_width.'px;';
						}

						if ( $options['resize_height'] != '' ){
							$resize_height = $options['resize_height'];
							$the_dimensions .= 'height:'.$resize_height.'px;';
						}


						if( $options['resize_crop'] == 'true' AND !empty( $options['image'] ) ){
							$the_image = dslc_aq_resize( $options['image'], $resize_width, $resize_height, true );
						}else{
							$the_image = $options['image'];
						}

					}

				?>

				<img src="<?php echo $the_image ?>" <?php echo (( $the_dimensions !== false ) ? 'style="'.$the_dimensions.'"' : '') ?> alt="" title="" />

			</span><!-- .dslc-image -->
		<?php if( $asyncScripts != '[]' ): ?><script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,[]);});</script><?php endif; ?>
			<?php
		/* Module output ends here */
		$this->module_end( $options );
	}
}