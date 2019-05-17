<?php
if( !function_exists('met_button_circle_shortcode') ){
	function met_button_circle_shortcode( $atts, $content = null ) {
		$defaults = array(
			'type' 			=> 'primary',
			'link'			=> '#',
			'target'		=> '_self',
			'effect'		=> ''
		);
		extract( shortcode_atts( $defaults, $atts ) );

		return '<a href="'.$link.'" target="'.$target.'" class="btn-circle btn-'.$type.' '.$effect.'">'.$content.'</a>';
	}add_shortcode( 'met_button_circle', 'met_button_circle_shortcode' );
}


/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_button_circle') ){
	function mcsb_register_met_button_circle( $shortcodes ) {
		$shortcodes['met_button_circle'] = array(
			'title' => __('Button (Circle)', 'mcsb'),
			'icon' => 'circle',
			'template' => '[met_button_circle {{attributes}}] {{content}} [/met_button_circle]',
			'options' => array(
				'content' => array(
					'std' => 'Button Text',
					'type' => 'text',
					'label' => __('Button\'s Text', 'mcsb'),
					'desc' => __('Add the button\'s text', 'mcsb'),
				),
				'link' => array(
					'type' => 'url',
					'label' => __('Button URL', 'mcsb'),
					'desc' => __('Add the button\'s url eg http://example.com', 'mcsb'),
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
				),
				'type' => array(
					'type' => 'select',
					'label' => __('Button Style', 'mcsb'),
					'desc' => __('Select the button\'s style, ie the button\'s colour', 'mcsb'),
					'options' => array(
						'primary' => 'Primary (Theme Color)',
						'info' => 'Info',
						'warning' => 'Warning',
						'danger' => 'Danger',
						'success' => 'success',
					)
				),
				'effect' => array(
					'type' => 'select',
					'label' => __('Button Effect', 'mcsb'),
					'desc' => __('Select the button\'s effect.', 'mcsb'),
					'options' => array(
						'' => '',
						'with-border' => 'Border',
						'with-shining' => 'Shine',
						'with-side-shining' => 'Side Shine',
						'with-trans-border' => 'Trans Border'
					)
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_button_circle' );
}
