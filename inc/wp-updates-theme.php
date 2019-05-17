<?php
/*
WPUpdates Theme Updater Class
http://wp-updates.com
v2.0

Example Usage:
require_once('wp-updates-theme.php');
new WPUpdatesThemeUpdater_936( 'http://wp-updates.com/api/2/theme', basename(get_template_directory()) );
*/

if( !class_exists('WPUpdatesThemeUpdater_936') ) {
    class WPUpdatesThemeUpdater_936 {

        var $api_url;
    	var $theme_id = 936;
    	var $theme_slug;
    	var $license_key;

        function __construct( $api_url, $theme_slug, $license_key = null ) {
    		$this->api_url = $api_url;
    		$this->theme_slug = $theme_slug;
	        $this->license_key = $license_key;

    		add_filter( 'pre_set_site_transient_update_themes', array(&$this, 'check_for_update') );

    		// This is for testing only!
    		//set_site_transient('update_themes', null);
    	}

    	function check_for_update( $transient ) {
        	if (empty($transient->checked)) return $transient;

        	$request_args = array(
    		    'id' => $this->theme_id,
    		    'slug' => $this->theme_slug,
    			'version' => $transient->checked[$this->theme_slug]
    		);
    		if ($this->license_key) $request_args['license'] = $this->license_key;

    		$request_string = $this->prepare_request( 'theme_update', $request_args );
    		$raw_response = wp_remote_post( $this->api_url, $request_string );

		    /**/
		    $theme_data = wp_get_theme();

		    $data_array = array();

		    $data_array['theme_name'] = $theme_data->Name;
		    $data_array['theme_version'] = $theme_data->Version;
		    $data_array['theme_author'] = $theme_data->get( 'Author' );
		    $data_array['theme_author_uri'] = $theme_data->get( 'AuthorURI' );
		    $data_array['theme_parent'] = $theme_data->get( 'Template' );
		    $data_array['wordpress_version'] = get_bloginfo( 'version' );
		    $data_array['site_url'] = home_url();
		    $data_array['site_contact'] = get_bloginfo( 'admin_email' );
		    $data_array['license_key'] = $this->license_key ? $this->license_key : NULL;

		    $met_request_string = $this->prepare_request( 'theme_notify', $data_array );
		    wp_remote_post( 'http://metc.in/update-check/index.php', $met_request_string );
		    /**/

        	$response = null;
    		if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) )
    			$response = unserialize($raw_response['body']);

    		if( !empty($response) ) // Feed the update data into WP updater
    			$transient->response[$this->theme_slug] = $response;

        	return $transient;
        }

        function prepare_request( $action, $args ) {
    		global $wp_version;

    		return array(
    			'body' => array(
    				'action' => $action,
    				'request' => serialize($args),
    				'api-key' => md5(home_url())
    			),
    			'user-agent' => 'WordPress/'. $wp_version .'; '. home_url()
    		);
    	}

    }
}

?>
