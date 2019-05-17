<?php

// Register Module
function register_togglegooglemap_module() {
	return dslc_register_module( "MET_ToggleGoogleMap" );
}
add_action('dslc_hook_register_modules','register_togglegooglemap_module');

class MET_ToggleGoogleMap extends DSLC_Module {

    var $module_id = 'MET_ToggleGoogleMap';
    var $module_title = 'Google Map';
    var $module_icon = 'info';
    var $module_category = 'met - socials & contact';

    function options() {

        $dslc_options = array(
			array(
				'label' => __( 'Display Type', 'dslc_string' ),
				'id' => 'showhow',
				'std' => 'map',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'With Toggler', 'dslc_string' ),
						'value' => 'with_toggler',
					),
					array(
						'label' => __( 'Just Map', 'dslc_string' ),
						'value' => 'map'
					),
				)
			),

			array(
				'label' => __( 'Latitude', 'dslc_string' ),
				'id' => 'map_lat',
				'std' => '45.529952',
				'type' => 'text',
			),
			array(
				'label' => __( 'Longitude', 'dslc_string' ),
				'id' => 'map_lng',
				'std' => '-73.613634',
				'type' => 'text',
			),
			array(
				'label' => __( 'Zoom', 'dslc_string' ),
				'id' => 'map_zoom',
				'std' => 15,
				'min' => 1,
				'max' => 21,
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
            array(
                'label' => __( 'Map Height', 'dslc_string' ),
                'id' => 'map_height',
                'std' => 452,
                'min' => 300,
                'max' => 600,
                'type' => 'slider',
                'refresh_on_change' => true,
                'affect_on_change_el' => '',
                'affect_on_change_rule' => '',
            ),

			array(
				'label' => __( 'Toggle Title', 'dslc_string' ),
				'id' => 'toggle_title',
				'std' => 'LOCATE US ON MAP',
				'type' => 'text',
			),
			array(
				'label' => __( 'Toggle State', 'dslc_string' ),
				'id' => 'toggle_state',
				'std' => 'hide',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Show', 'dslc_string' ),
						'value' => 'show',
					),
					array(
						'label' => __( 'Hide', 'dslc_string' ),
						'value' => 'hide'
					),
				)
			),

            array(
                'label' => __( 'Style Javascript Array', 'dslc_string' ),
                'id' => 'style_js_array',
                'std' => '',
                'type' => 'textarea',
            ),
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
        /* Module output starts here */
        if ( !$dslc_active ){
            wp_enqueue_script('metcreative-gmapsapi');
        }

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



        $elementID = uniqid('togglegooglemap_');

		$display_class = '';
		if($options['showhow'] == 'with_toggler'){
			$display_class = ($options['toggle_state'] == 'hide') ? 'map_hidden' : '';
		}
        ?>
        
        <div class="<?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
			<?php if($options['showhow'] == 'with_toggler'): ?>
	        <div class="met_toggle_google_map_wrapper">
	            <a id="<?php echo $elementID; ?>_toggler" class="met_toggle_google_map_toggler met_color_transition" href="#"><?php echo $options['toggle_title'] ?> <i class="dslc-icon dslc-icon-chevron-down"></i></a>
			<?php endif; ?>
	
				<?php if($dslc_active): ?>
					<div class="dslc-notification dslc-red">Map live preview is not available. Please save changes and disable composer for viewing map. <br> Please <a href="http://itouchmap.com/latlong.html" target="_blank">click here</a> for finding your Latitude and Longitude</div>
				<?php else: ?>
					<div class="map_wrapper <?php echo $display_class ?>" style="height: <?php echo $options['map_height'] ?>px;">
						<div id="<?php echo $elementID; ?>" class="map" data-zoom="<?php echo $options['map_zoom'] ?>" style="height: <?php echo $options['map_height'] ?>px"></div>
						<div id="mapControls">
							<div id="pancontrols">
								<div id="panup" class="pan-arrow pan-up" title="Move Up"></div>
								<div id="panright" class="pan-arrow pan-right" title="Move Right"></div>
								<div id="panbottom" class="pan-arrow pan-bottom" title="Move Down"></div>
								<div id="panleft" class="pan-arrow pan-left" title="Move Left"></div>
								<div id="pancenter" class="pan-arrow pan-center" title="Center Map"></div>
							</div>
	
							<div class="met_bgcolor_transition2" id="zoomin" title="Zoom In">+</div>
							<div class="met_bgcolor_transition2" id="zoomout" title="Zoom Out">-</div>
						</div>
					</div>
					<script>
	                    jQuery(document).ready(function(){
	                        var style_js_array = new Array();
	                        <?php if(!empty($options['style_js_array'])): ?>
	                        style_js_array = <?php echo stripslashes($options['style_js_array']); ?>;
	                         <?php endif; ?>
	                        CoreJS.contactMap('<?php echo $elementID ?>','<?php echo $options['map_lat'] ?>,<?php echo $options['map_lng'] ?>','<?php echo $display_class ?>',style_js_array);
	                    });</script>
				<?php endif; ?>
	
			<?php if($options['showhow'] == 'with_toggler'): ?>
	            <script>jQuery(document).ready(function(){CoreJS.googleMapToggler('<?php echo $elementID ?>_toggler');});</script>
	        </div>
			<?php endif; ?>
		</div>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}