<?php
if( !function_exists('met_accordion_wrap_shortcode') ){
	function met_accordion_wrap_shortcode( $atts, $content = null ) {
		$defaults = array( 'style' => '', 'title' => '', 'link_text' => '', 'link_url' => '' );
		extract( shortcode_atts( $defaults, $atts ) );

		$list_type_class = '';
		if($style == 'transparent'){
			$list_type_class = 'transparent';
		}elseif($style == 'cubic'){
			$list_type_class = 'cubic';
		}elseif($style == 'holder'){
			$list_type_class = 'met_accordion_flat';
		}

		$elementID = uniqid('met_accordion_');
		$output = '';

		$before_accordion = '';
		$after_accordion = '';
		if($style == 'holder'){
			$before_accordion = '<div class="met_content_box met_accordion_holder">
            <header><span>'.$title.'</span><a href="'.$link_url.'" class="met_color2"> '.$link_text.'</a></header>
            <section>';
			$after_accordion = '</section></div>';
		}

		$output .= $before_accordion;
		$output .= '<div id="'.$elementID.'" class="met_accordion_group '.$list_type_class.'">';
		$output .= do_shortcode( trim($content) );
		$output .= '</div>';
		$output .= $after_accordion;

		$output .= '<script>jQuery(document).ready(function(){CoreJS.met_accordion("'.$elementID.'");});</script>';

		return shortcode_fix($output);
	}add_shortcode( 'met_accordions', 'met_accordion_wrap_shortcode' );
}

if( !function_exists('met_accordion_item_shortcode') ){
	function met_accordion_item_shortcode( $atts, $content = null ) {
		$defaults = array( 'title' => '','status' => '' );
		extract( shortcode_atts( $defaults, $atts ) );

		return '
	<div class="met_accordion '.$status.'">
		<a href="javascript:;" class="met_accordion_title">'.$title.'</a>
		<div class="met_accordion_content">'.do_shortcode($content).'</div>
	</div>';

	}add_shortcode( 'met_accordion', 'met_accordion_item_shortcode' );
}

/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_accordions') ){
	function mcsb_register_met_accordions( $shortcodes ) {
		$shortcodes['met_accordions'] = array(
			'title' => __('Accordion', 'mcsb'),
			'icon' => 'th-list',
			'template' => '[met_accordions {{attributes}}]{{child_shortcode}}[/met_accordions]',
			'desc' => __('Click <strong><i class="uk-icon-plus"></i> Accordion Item</strong> to add a new item. ( <i class="uk-icon-bars"></i> ) Drag and drop to reorder accordion items.', 'mcsb'),
			'options' => array(
				'style' => array(
					'type' => 'select',
					'label' => __('Accordion Style', 'mcsb'),
					'desc' => '',
					'options' => array(
						'' 				=> 'Default',
						'transparent' 	=> 'Transparent',
						'cubic'			=> 'Cubic',
						'holder' 		=> 'Holder',
					)
				),
				'title' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Holder Title', 'mcsb'),
					'desc' => '*Only available with "Holder" style.'
				),
				'link_text' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Holder Link Text', 'mcsb'),
					'desc' => '*Only available with "Holder" style.'
				),
				'link_url' => array(
					'std' => '',
					'type' => 'url',
					'label' => __('Holder Link URL', 'mcsb'),
					'desc' => '*Only available with "Holder" style.'
				),
			),
			'child' => array(
				'title' => __('Accordion Item', 'mcsb'),
				'template' => '[met_accordion {{attributes}}]{{content}}[/met_accordion]',
				'options' => array(
					'title' => array(
						'std' => 'Im Accordion Title',
						'type' => 'text',
						'label' => __('Accordion Title', 'mcsb'),
						'desc' => '',
						'primary' => true
					),
					'content' => array(
						'std' => 'Im Accordion Content',
						'type' => 'textarea',
						'label' => __('Accordion Content', 'mcsb'),
						'desc' => ''
					),
					'status' => array(
						'type' => 'select',
						'label' => __('Status', 'mcsb'),
						'desc' => '',
						'options' => array(
							'' 		=> 'Default',
							'on' 	=> 'ON',
						)
					),
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_accordions' );
}

