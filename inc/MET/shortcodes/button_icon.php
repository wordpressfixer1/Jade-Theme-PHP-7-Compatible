<?php
if( !function_exists('met_button_icon_shortcode') ){
	function met_button_icon_shortcode( $atts, $content = null ) {
		$defaults = array(
			'type' 			=> 'primary',
			'size' 			=> '',
			'link'			=> '#',
			'target'		=> '_self',
			'icon'			=> 'fa-info'
		);
		extract( shortcode_atts( $defaults, $atts ) );

		return '<div><a href="'.$link.'" target="'.$target.'" class="iconic-btn btn-'.$size.' btn-'.$type.'"><div><div><span class="icon-caption"><i class="fa '.$icon.'"></i></span><span class="text-caption">'.$content.'</span></div></div></a></div>';
	}add_shortcode( 'met_icon_button', 'met_button_icon_shortcode' );
}


/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_icon_button') ){
	function mcsb_register_met_icon_button( $shortcodes ) {
		$shortcodes['met_icon_button'] = array(
			'title' => __('Button (Icon)', 'mcsb'),
			'icon' => 'caret-square-o-right',
			'template' => '[met_icon_button {{attributes}}] {{content}} [/met_icon_button]',
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
					'desc' => __("Add the button's url eg http://example.com", 'mcsb'),
					'std' => 'http://example.com',
				),
				'target' => array(
					'type' => 'select',
					'label' => __('Link Target', 'mcsb'),
					'desc' => __('Set the browser behavior for the click action.', 'mcsb'),
					'options' => array(
						'_self' => 'Same window',
						'_blank' => 'New window'
					)
				),
				'icon' => array(
					'type' => 'icon',
					'label' => __('Button Icon', 'mcsb'),
					'desc' => '',
					'std' => 'fa-info',
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
					'desc' => __('Select the button\'s size', 'mcsb'),
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
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_icon_button' );
}