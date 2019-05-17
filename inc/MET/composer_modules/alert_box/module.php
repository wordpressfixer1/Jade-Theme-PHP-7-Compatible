<?php

// Register Module
function register_alertbox_module() {
	return dslc_register_module( "MET_AlertBox" );
}
add_action('dslc_hook_register_modules','register_alertbox_module');

class MET_AlertBox extends DSLC_Module {

    var $module_id = 'MET_AlertBox';
    var $module_title = 'Alert Box';
    var $module_icon = 'info';
    var $module_category = 'met - general';

    function options() {

        $dslc_options = array(
			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'CLICK TO EDIT. Alert Box Message',
				'type' => 'text',
				'visibility' => 'hidden'
			),

			/**
			 * Type Option
			 */
			array(
				'label' => __( 'Display Type', 'dslc_string' ),
				'id' => 'type',
				'std' => 'success',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Success', 'dslc_string' ),
						'value' => 'success',
					),
					array(
						'label' => __( 'Info', 'dslc_string' ),
						'value' => 'info'
					),
					array(
						'label' => __( 'Warning', 'dslc_string' ),
						'value' => 'warning'
					),
					array(
						'label' => __( 'Danger', 'dslc_string' ),
						'value' => 'danger'
					),
				)
			),

			array(
				'label' => __( 'Shadow Color', 'dslc_string' ),
				'id' => 'shadow_color',
				'std' => '!',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_alert_2:after',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => 'Shadow',
			),
			array(
				'label' => __( 'Shadow Height', 'dslc_string' ),
				'id' => 'shadow_height',
				'std' => '5',
				'min' => '0',
				'max' => '20',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_alert_2:after',
				'affect_on_change_rule' => 'height',
				'section' => 'styling',
				'tab' => 'Shadow',
				'ext' => 'px',
			),

			array(
				'label' => __( 'Arrow Color', 'dslc_string' ),
				'id' => 'arrow_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_alert_2:before',
				'affect_on_change_rule' => 'border-right-color',
				'section' => 'styling',
				'tab' => 'Arrow',
			),
			array(
				'label' => __( 'Arrow Size', 'dslc_string' ),
				'id' => 'arrow_size',
				'std' => '18',
				'min' => '0',
				'max' => '50',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_alert_2:before',
				'affect_on_change_rule' => 'border-right-width,border-bottom-width',
				'section' => 'styling',
				'tab' => 'Arrow',
				'ext' => 'px',
			),
        );

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('.met_alert_2', '', array('background-color' => ''), 'Box'),

			// Title
			lc_general('.met_alert_2', '', array('color' => '','text-align' => '', 'font-size' => '24', 'line-height' => '26')),

			// Paddings
			lc_paddings('.met_alert_2', 'Paddings', array('t' => '17', 'r' => '15', 'b' => '17', 'l' => '15')),

			// Box Borders
			lc_borders('.met_alert_2', 'Borders', array(), array(), '', '', '' ),

			// Border Radius
			lc_borderRadius('.met_alert_2', 'Border Radius')
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

        $module_class = $module_attributes = '';
        if( $dslc_is_admin ){
            $module_class = 'dslca-editable-content';
            $module_attributes = 'data-id="title" data-type="simple" contenteditable';
        }
        ?>
        <div class="met_alert_2 alert-<?php echo $options['type'] ?> <?php echo $module_class ?> <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?> <?php echo $module_attributes ?>><?php echo $options['title'] ?></div>

        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}