<?php

// Register Module
function register_flickr_module() {
	return dslc_register_module( "MET_DLSC_Flickr_Widget" );
}
add_action('dslc_hook_register_modules','register_flickr_module');

class MET_DLSC_Flickr_Widget extends DSLC_Module {

	var $module_id = 'MET_DLSC_Flickr_Widget';
	var $module_title = 'Flickr Boxed';
	var $module_icon = 'info';
	var $module_category = 'met - socials & contact';

	function options() {

		$dslc_options = array(
			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Module Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'FLICKR PHOTOS',
				'type' => 'text',
			),

			array(
				'label' => __( 'Flickr Username', 'dslc_string' ),
				'id' => 'flickr_username',
				'std' => '12202794@N04',
				'type' => 'text',
			),

			array(
				'label' => __( 'Image Limit', 'dslc_string' ),
				'id' => 'flickr_limit',
				'std' => 10,
				'min' => 1,
				'max' => 20,
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'type' => 'slider',
			),
		);

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('.met_sidebar_box', '', array('background-color' => ''), 'Box'),

			// Margins
			lc_margins('.met_sidebar_box', '', array('t' => '0', 'r' => '0', 'b' => '0', 'l' => '0')),

			lc_paddings('.met_sidebar_box ul.met_flickr_feed', '', array('t' => '24', 'r' => '24', 'b' => '24', 'l' => '24')),

			// Box Borders
			lc_borders('.met_sidebar_box', 'Borders', array(), array(), '', '', '' ),

			// Title
			lc_general('.met_sidebar_box > header', 'Title', array('color' => '#000000', 'font-size' => '19')),
			lc_general('.met_sidebar_box > header h4', 'Title', array('line-height' => '25','text-align' => ''))
		);

		$dslc_options = met_lc_extras($dslc_options, array('animation','parallax'), 'shared_options');

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

        /* Animation */
        

        $met_shared_options = met_lc_extras( $options, array(
            'groups'   => array('animation', 'parallax'),
            'params'   => array(
                'js'           => false,
                'css'          => false,
                'external_run' => false,
                'is_grid'      => false,
            ),
            'is_admin' => $dslc_is_admin,
        ), 'shared_options_output' );

        if ( !$dslc_is_admin && $met_shared_options['activity'] ){
            wp_enqueue_style('metcreative-animate');
            wp_enqueue_script('metcreative-wow');
        }

		if ( $dslc_is_admin ){
			echo '<script src="'.get_template_directory_uri().'/js/jflickrfeed.min.js'.'"></script>';
		}

		$widget_options['title'] = $options['title'];
		$widget_options['flickr_limit'] = $options['flickr_limit'];
		$widget_options['flickr_username'] = $options['flickr_username'];

		$args = array(
			'before_widget' => '<div class="met_sidebar_box clearfix'.$met_shared_options['classes'].'"'.$met_shared_options['data-'].'>',
			'after_widget'  => '</div>',
			'before_title'  => '<header><h4>',
			'after_title'   => '</h4></header>',
		);

		echo '<div class="dslc_flickr_widget">';
		the_widget( 'MET_Flickr_Widget', $widget_options, $args );
		echo '</div>';

        echo $met_shared_options['script'];

		/* Module output ends here */
		$this->module_end( $options );
	}
}