<?php

// Register Module
function register_metacomments_module() {
	return dslc_register_module( "MET_Single_Comments" );
}
add_action('dslc_hook_register_modules','register_metacomments_module');

class MET_Single_Comments extends DSLC_Module {

	var $module_id = 'MET_Single_Comments';
	var $module_title = 'Custom Comments';
	var $module_icon = 'comments';
	var $module_category = 'met - single';

	function options() {

		$dslc_options = array();

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

		global $dslc_post_id;
		$dslc_post_id = $options['post_id'];

		get_template_part('inc/template_single/comments');

		/* Module output ends here */
		$this->module_end( $options );
	}
}