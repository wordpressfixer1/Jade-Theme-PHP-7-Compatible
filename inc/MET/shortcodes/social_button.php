<?php
if( !function_exists('met_social_button_shortcode') ){
	function met_social_button_shortcode( $atts, $content = null ) {
		$defaults = array(
			'link'			=> '#',
			'target'		=> '_self',
			'icon'			=> 'facebook'
		);
		extract( shortcode_atts( $defaults, $atts ) );

		global $dslc_post_id;
		$link = str_replace('{post-title}',get_the_title($dslc_post_id),$link);
		$link = str_replace('{permalink}',get_permalink($dslc_post_id),$link);

		return '<a href="'.$link.'" target="'.$target.'" class="met_icon_box bg_'.$icon.'"><i class="fa fa-'.$icon.'"></i></a>';
	}add_shortcode( 'met_social_button', 'met_social_button_shortcode' );
}

/* [ MC Shortcode Builder ] -> Register */
if( !function_exists('mcsb_register_met_social_button') ){
	function mcsb_register_met_social_button( $shortcodes ) {
		/* I need all fontawesome social network names for social button shortcode */
		$social_networks = array('facebook','twitter','youtube','android','apple','bitbucket','bitcoin','css3','dribbble','dropbox','flickr','foursquare','github','gittip','google-plus','html5','instagram','linkedin','linux','maxcdn','pagelines','pinterest','renren','skype','stack-exchange','stack-overflow','trello','vimeo-square','vk','weibo','windows','xing');
		foreach($social_networks as $social_network){
			$social_networks_[$social_network] = strtoupper($social_network);
		}

		$shortcodes['met_social_button'] = array(
			'title' => __('Social Button', 'mcsb'),
			'icon' => 'thumbs-up',
			'template' => '[met_social_button {{attributes}}]',
			'options' => array(
				'link' => array(
					'type' => 'url',
					'label' => __('Button URL', 'mcsb'),
					'desc' => __("Add the button's url eg http://example.com <br> For Posts you can use {post-title} and {permalink} <br> Example: http://www.facebook.com/sharer.php?u={permalink}", 'mcsb'),
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
				'icon' => array(
					'type' => 'select',
					'label' => __('Social Network', 'mcsb'),
					'desc' => __('Select social network.', 'mcsb'),
					'options' => $social_networks_
				),
			)
		);

		return $shortcodes;
	}add_filter( 'mcsb/register/shortcode', 'mcsb_register_met_social_button' );
}