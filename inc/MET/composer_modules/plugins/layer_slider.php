<?php

// Register Module
function register_layeslider_module() {
	return dslc_register_module( "MET_LayerSlider" );
}
add_action('dslc_hook_register_modules','register_layeslider_module');

class MET_LayerSlider extends DSLC_Module {

	var $module_id = 'MET_LayerSlider';
	var $module_title = 'LayerSlider';
	var $module_icon = 'picture';
	var $module_category = 'met - general';

	function options() {

		$sliders = array();
		if(class_exists('LS_Sliders')) $sliders = LS_Sliders::find(array('limit' => 100));

		$slider_choices = array();

		$slider_choices[] = array(
			'label' => __( '-- Select --', 'dslc_string' ),
			'value' => 'not_set',
		);

		if($sliders != null && !empty($sliders)) {

			foreach ( $sliders as $slider ) {
				$name = empty($slider['name']) ? 'Unnamed' : $slider['name'];
				$slider_choices[] = array(
					'label' => $name,
					'value' => $slider['id']
				);
			}

		}

		$dslc_options = array(
			array(
				'label' => __( 'Layer Slider', 'dslc_string' ),
				'id' => 'slider',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $slider_choices
			)
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

		/* Module output stars here */

		if ( ! isset( $options['slider'] ) || $options['slider'] == 'not_set' ) {

			if ( $dslc_is_admin ) :
				?><div class="dslc-notification dslc-red"><?php _e( 'Click the cog icon on the right of this box to choose which slider to show.', 'dslc_string' ); ?> <span class="dslca-module-edit-hook dslc-icon dslc-icon-cog"></span></span></div><?php
			endif;

		} else {

			if ( $dslc_active ) :
				?><div class="dslc-notification dslc-green"><?php _e( 'Save changes and disable composer to show slider.', 'dslc_string' ); ?> </div><?php
			endif;

			if(!$dslc_active) echo do_shortcode('[layerslider id="'.$options['slider'].'"]');

		}

		/* Module output ends here */

		$this->module_end( $options );

	}

}