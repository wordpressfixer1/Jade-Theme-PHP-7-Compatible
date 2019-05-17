<?php
if( !function_exists('met_icon_box_shortcode') ){
	function met_icon_box_shortcode( $atts, $content = null ) {
		$defaults = array(
			'link'			=> '#',
			'target'		=> '_self',
			'icon'			=> 'fa-facebook'
		);
		extract( shortcode_atts( $defaults, $atts ) );

		return '<a href="'.$link.'" target="'.$target.'" class="met_icon_box"><i class="fa '.$icon.'"></i></a>';
	}add_shortcode( 'met_icon_box', 'met_icon_box_shortcode' );
}


/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_icon_box') ){
	function mcsb_register_met_icon_box( $shortcodes ) {
		$shortcodes['met_icon_box'] = array(
			'title' => __('Icon Box (Button)', 'mcsb'),
			'icon' => 'check-square-o',
			'template' => '[met_icon_box {{attributes}}]',
			'options' => array(
				'icon' => array(
					'type' => 'icon',
					'label' => __('Button Icon', 'mcsb'),
					'std' => 'fa-facebook',
				),
				'link' => array(
					'type' => 'url',
					'label' => __('Button URL', 'mcsb'),
					'desc' => __("Add the button's url eg http://example.com", 'mcsb'),
					'std' => 'http://example.com',
				),
				'target' => array(
					'type' => 'select',
					'label' => __('Button Target', 'mcsb'),
					'desc' => __('Set the browser behavior for the click action.', 'mcsb'),
					'options' => array(
						'_self' => 'Same window',
						'_blank' => 'New window'
					)
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_icon_box' );
}
