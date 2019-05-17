<?php
if( !function_exists('met_button_shortcode') ){
	function met_button_shortcode( $atts, $content = null ) {
		$defaults = array(
			'type' 			=> 'primary',
			'size' 			=> '',
			'link'			=> '#',
			'target'		=> '_self'
		);
		extract( shortcode_atts( $defaults, $atts ) );

		return '<a href="'.$link.'" target="'.$target.'" class="btn btn-'.$size.' btn-'.$type.'">'.$content.'</a>';
	}add_shortcode( 'met_button', 'met_button_shortcode' );
}

/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_button') ){
	function mcsb_register_met_button( $shortcodes ) {
		$shortcodes['met_button'] = array(
			'title' => __('Button', 'mcsb'),
			'icon' => 'square',
			'template' => '[met_button {{attributes}}] {{content}} [/met_button]',
			'options' => array(
				'content' => array(
					'type' => 'text',
					'label' => __("Button's Text", 'mcsb'),
					'desc' => __("Add the button's text", 'mcsb'),
					'std' => 'Button Text',
				),
				'link' => array(
					'type' => 'url',
					'label' => __('Button URL', 'mcsb'),
					'desc' => __("Add the button's url eg http://example.com", 'mcsb'),
					'std' => 'http://example.com'
				),
				'target' => array(
					'type' => 'select',
					'label' => __('Button Target', 'mcsb'),
					'desc' => __('Set the browser behavior for the click action.', 'mcsb'),
					'options' => array(
						'_self' => 'Same window',
						'_blank' => 'New window'
					)
				),
				'type' => array(
					'type' => 'select',
					'label' => __('Button Style', 'mcsb'),
					'desc' => __("Select the button's style, ie the button's colour", 'mcsb'),
					'options' => array(
						'primary' => 'Primary (Theme Color)',
						'info' => 'Info',
						'warning' => 'Warning',
						'danger' => 'Danger',
						'success' => 'success',
					)
				),
				'size' => array(
					'type' => 'select',
					'label' => __('Button Size', 'mcsb'),
					'desc' => __("Select the button's size", 'mcsb'),
					'options' => array(
						'xs' => 'X-Small',
						'sm' => 'Small',
						'' => 'Medium',
						'lg' => 'Large'
					)
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_button' );
}
