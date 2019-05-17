<?php
if( !function_exists('met_list_wrap_shortcode') ){
	function met_list_wrap_shortcode( $atts, $content = null ) {
		$defaults = array( 'type' => 'clean' );
		extract( shortcode_atts( $defaults, $atts ) );

		$list_tag = 'ul';
		if($type == 'clean'){
			$list_type_class = 'met_clean_list';
		}elseif($type == 'ol'){
			$list_tag = 'ol';
			$list_type_class = 'met_ol';
		}elseif($type == 'ul'){
			$list_type_class = 'met_ul';
		}elseif($type == 'iconic'){
			$list_type_class = 'clearfix met_ul_iconic';
		}elseif($type == 'iconic_circle'){
			$list_type_class = 'clearfix met_ul_iconic met_ul_iconic_circle';
		}elseif($type == 'check'){
			$list_type_class = 'met_check_list';
		}

		$output = '<'.$list_tag.' id="'.uniqid('met_list_').'" class="'.$list_type_class.'">';
		$output .= do_shortcode( trim($content) );
		$output .= '</'.$list_tag.'>';

		$output = str_replace('li>&nbsp;',"li>\r\n",$output);
		return shortcode_fix($output);
	}add_shortcode( 'met_list', 'met_list_wrap_shortcode' );
}

if( !function_exists('met_list_item_shortcode') ){
	function met_list_item_shortcode( $atts, $content = null ) {
		$defaults = array( 'icon' => '','icon_color' => '','circle_color' => '', 'text' => '' );
		extract( shortcode_atts( $defaults, $atts, 'met_li' ) );

		$li_before = '';
		$li_after = '';
		if( !empty($icon) ){
			$style_atts = '';
			if( !empty($icon_color) OR !empty($circle_color) ){
				$style_atts = 'style="';
				if(!empty($icon_color)) 	$style_atts .= 'color:'.$icon_color.';';
				if(!empty($circle_color)) 	$style_atts .= 'background-color:'.$circle_color.';';
				$style_atts .= '"';
			}

			$li_before = '<i class="met_ul_iconic_icon fa '.$icon.'" '.$style_atts.'></i><span class="met_ul_iconic_text">';
			$li_after = '</span>';
		}

		return '<li>'.$li_before.trim($text).$li_after.'</li>';
	}add_shortcode( 'met_li', 'met_list_item_shortcode' );
}

/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_list') ){
	function mcsb_register_met_list( $shortcodes ) {
		$shortcodes['met_list'] = array(
			'title' => __('List', 'mcsb'),
			'icon' => 'list-ul',
			'template' => '[met_list {{attributes}}]{{child_shortcode}}[/met_list]',
			'desc' => __('Click <strong><i class="uk-icon-plus"></i> List Item</strong> to add a new item. ( <i class="uk-icon-bars"></i> ) Drag and drop to reorder list items.', 'mcsb'),
			'options' => array(
				'type' => array(
					'type' => 'select',
					'label' => __('List Type', 'mcsb'),
					'desc' => '',
					'options' => array(
						'clean' 		=> 'Clean',
						'ol' 			=> 'Ordered Circle',
						'ul'			=> 'Unordered Dotted',
						'iconic' 		=> 'Iconic',
						'iconic_circle' => 'Iconic Circle',
						'check' 		=> 'Check',
					)
				),
			),
			'child' => array(
				'title' => __('List Item', 'mcsb'),
				'template' => '[met_li {{attributes}}]',
				'options' => array(
					'text' => array(
						'std' => 'Im List Item Text',
						'type' => 'text',
						'label' => __('List Item Text', 'mcsb'),
						'desc' => '',
						'primary' => true
					),
					'icon' => array(
						'std' => '',
						'type' => 'icon',
						'label' => __('List Item Icon', 'mcsb'),
						'desc' => __('<strong>*Only available with "Iconic Circle" List Type.</strong>', 'mcsb'),
					),
					'icon_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('List Item Icon Color', 'mcsb'),
						'desc' => ''
					),
					'circle_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('List Item Circle Color', 'mcsb'),
						'desc' => ''
					),
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_list' );
}