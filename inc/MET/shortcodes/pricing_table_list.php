<?php
if( !function_exists('met_pricing_list_wrap_shortcode') ){
	function met_pricing_list_wrap_shortcode( $atts, $content = null ) {

		$output = '<ul id="'.uniqid('met_list_').'">';
		$output .= do_shortcode( trim($content) );
		$output .= '</ul>';

		return shortcode_fix($output);
	}add_shortcode( 'met_pt_list', 'met_pricing_list_wrap_shortcode' );
}

if( !function_exists('met_pricing_list_item_shortcode') ){
	function met_pricing_list_item_shortcode( $atts, $content = null ) {
		$defaults = array( 'title' => '','value' => '' );
		extract( shortcode_atts( $defaults, $atts, 'met_li' ) );

		$title_html = '';
		if(!empty($title)){
			$title_html = '<span>'.$title.'</span>';
		}

		$value_html = '';
		if(!empty($value)){
			$value_html = '<strong>'.$value.'</strong>';
		}

		return '<li>'.$title_html.$value_html.'</li>';
	}add_shortcode( 'met_pt_li', 'met_pricing_list_item_shortcode' );
}

/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_pt_list_1') ){
	function mcsb_register_met_pt_list_1( $shortcodes ) {
		$shortcodes['met_pt_list_1'] = array(
			'title' => __('Feature List <span class="uk-text-small uk-text-muted">(Pricing Table 1)</span>', 'mcsb'),
			'icon' => 'list',
			'template' => '[met_pt_list]{{child_shortcode}}[/met_pt_list]',
			'desc' => __('<strong>IMPORTANT!</strong> This shortcode designed to be use only on "Pricing Table 1" module.<br> Live preview is not actual output.', 'mcsb'),
			'options' => array(),
			'child' => array(
				'title' => __('Table Row', 'mcsb'),
				'template' => '[met_pt_li {{attributes}}]',
				'options' => array(
					'title' => array(
						'std' => 'Disk Space',
						'type' => 'text',
						'label' => __('Title', 'mcsb'),
						'desc' => '',
						'primary' => true
					),
					'value' => array(
						'std' => '50GB',
						'type' => 'text',
						'label' => __('Value', 'mcsb'),
						'desc' => '',
					),
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_pt_list_1' );
}

if( !function_exists('mcsb_register_met_pt_list_3_4') ){
	function mcsb_register_met_pt_list_3_4( $shortcodes ) {
		$shortcodes['met_pt_list_3_4'] = array(
			'title' => __('Feature List <span class="uk-text-small uk-text-muted">(Pricing Table 3 & 4)</span>', 'mcsb'),
			'icon' => 'bars',
			'template' => '[met_pt_list]{{child_shortcode}}[/met_pt_list]',
			'desc' => __('<strong>IMPORTANT!</strong> This shortcode designed to be use only on "Pricing Table 3 & 4" modules.<br> Live preview is not actual output.', 'mcsb'),
			'options' => array(),
			'child' => array(
				'title' => __('Table Row', 'mcsb'),
				'template' => '[met_pt_li {{attributes}}]',
				'options' => array(
					'title' => array(
						'std' => '50GB Disk Space',
						'type' => 'text',
						'label' => __('Title', 'mcsb'),
						'desc' => '',
						'primary' => true
					)
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_pt_list_3_4' );
}