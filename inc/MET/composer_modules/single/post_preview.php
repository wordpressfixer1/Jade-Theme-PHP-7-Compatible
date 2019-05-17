<?php
// Register Module
function register_singlepostprev_module() {
    return dslc_register_module( "MET_Single_PostPreview" );
}
add_action('dslc_hook_register_modules','register_singlepostprev_module');

class MET_Single_PostPreview extends DSLC_Module {

	var $module_id = 'MET_Single_PostPreview';
	var $module_title = 'Post Preview';
	var $module_icon = 'picture';
	var $module_category = 'met - single';

	function options() {

		$dslc_options = array();

		$dslc_options = array_merge( $dslc_options, $this->presets_options() );
		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active, $preview_data;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		$this->module_start( $options );

        $media_type = rwmb_meta('met_content_media_type');

        $project_overview = rwmb_meta('met_project_overview');

        if( !$project_overview ){
            $preview_data['width'] = 1170;
        }else{
            $preview_data['width'] = 800;
        }

        $media_height = rwmb_meta('met_media_height_listing');
        if($media_height == 0){
            $preview_data['height'] = 450;
        }else{
            $preview_data['height'] = $media_height;
        }

        $media_hardcrop = rwmb_meta('met_media_hardcrop_listing');
        if($media_hardcrop == 0){
            $preview_data['hardcrop'] = false;
        }else{
            $preview_data['hardcrop'] = true;
        }

        get_template_part('inc/template_single/post_preview_data');

        get_template_part('inc/template_single/post_preview', get_post_format());


		/* Module output ends here */
		$this->module_end( $options );
	}
}