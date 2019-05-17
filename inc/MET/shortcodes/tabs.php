<?php
/* Tabs Shortcodes --- */

if (!function_exists('met_tabs_shortcode')) {
	function met_tabs_shortcode( $atts, $content = null ) {
		$defaults = array('style' => '', 'active' => '1');
		extract( shortcode_atts( $defaults, $atts ) );

		$elementID = uniqid('responsiveTabWrap_');

		$wrapper_class = '';
		if($style == 'vertical'){
			$wrapper_class = 'r-tabs-vertical';
		}

		$active = $active -1;

		STATIC $i = 0;
		$i++;

		// Extract the tab titles for use in the tab widget.
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }

		$output = '';

		if( count($tab_titles) ){
			$output .= '<div id="'.$elementID.'" class="met_tabs_wrapper r-tabs '.$wrapper_class.'" data-active="'.$active.'">';

			$output .= '<ul class="r-tabs-nav">';
			foreach( $tab_titles as $tab ){
				$output .= '<li class="r-tabs-tab"><a href="#'. sanitize_title( $tab[0] ) . $i .'" class="r-tabs-anchor">' . $tab[0] . '</a></li>';
			}
			$output .= '</ul>';

			$output .= do_shortcode( $content );

			$output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}

		if ( isset($_GET['dlsc']) ){
			$output .= '<link rel="stylesheet" href="'.get_template_directory_uri().'/css/responsive-tabs.css'.'" type="text/css" media="all" />';
			$output .= '<script src="'.get_template_directory_uri().'/js/responsive-tabs.js'.'"></script>';
		}else{
			wp_enqueue_style('metcreative-responsive-tabs');
			wp_enqueue_script('metcreative-responsive-tabs');
		}

        $output .= '<script>jQuery(document).ready(function(){CoreJS.responsiveTab("'.$elementID.'")});</script>';

		return $output;
	}
	add_shortcode( 'met_tabs', 'met_tabs_shortcode' );
}

if (!function_exists('met_tab_shortcode')) {
	function met_tab_shortcode( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );

		return '<div class="r-tabs-panel met-tab-content-'. sanitize_title( $title ) .'">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'met_tab', 'met_tab_shortcode' );
}

/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_tabs') ){
	function mcsb_register_met_tabs( $shortcodes ) {
		$shortcodes['met_tabs'] = array(
			'title' => __('Tabs', 'mcsb'),
			'icon' => 'folder-o',
			'template' => '[met_tabs {{attributes}}]{{child_shortcode}}[/met_tabs]',
			'desc' => __('Click <strong><i class="uk-icon-plus"></i> Tab Item</strong> to add a new item. ( <i class="uk-icon-bars"></i> ) Drag and drop to reorder tab items.', 'mcsb'),
			'options' => array(
				'style' => array(
					'type' => 'select',
					'label' => __('Tab Style', 'mcsb'),
					'desc' => '',
					'options' => array(
						'' 				=> 'Default',
						'vertical' 		=> 'Vertical',
					)
				),
				'active' => array(
					'std' => '',
					'type' => 'number',
					'label' => __('Active Item', 'mcsb'),
					'desc' => '*Default: First Item'
				),
			),
			'child' => array(
				'title' => __('Tab Item', 'mcsb'),
				'template' => '[met_tab {{attributes}}]{{content}}[/met_tab]',
				'options' => array(
					'title' => array(
						'std' => 'Im Tab Title',
						'type' => 'text',
						'label' => __('Tab Title', 'mcsb'),
						'desc' => '',
						'primary' => true
					),
					'content' => array(
						'std' => 'Im Tab Content',
						'type' => 'textarea',
						'label' => __('Tab Content', 'mcsb'),
						'desc' => ''
					),
				)
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_tabs' );
}
