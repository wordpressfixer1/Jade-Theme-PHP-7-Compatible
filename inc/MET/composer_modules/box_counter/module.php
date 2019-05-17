<?php

// Register Module
function register_boxcounter_module() {
	return dslc_register_module( "MET_BoxCounter" );
}
add_action('dslc_hook_register_modules','register_boxcounter_module');

class MET_BoxCounter extends DSLC_Module {

    var $module_id = 'MET_BoxCounter';
    var $module_title = 'Box';
    var $module_icon = 'info';
    var $module_category = 'met - counters';

    function options() {

		$dslc_options = array(
			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'counter counter_text',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Counter', 'dslc_string' ),
						'value' => 'counter'
					),
					array(
						'label' => __( 'Counter Text', 'dslc_string' ),
						'value' => 'counter_text'
					),
				)
			),

			array(
				'label' => __( 'Counter Number', 'dslc_string' ),
				'id' => 'counter',
				'std' => '365',
				'type' => 'text',
			),
			array(
				'label' => __( 'Counter Text', 'dslc_string' ),
				'id' => 'counter_text',
				'std' => 'Days',
				'type' => 'text',
			),

			array(
				'label' => __( 'Counter Speed', 'dslc_string' ),
				'id' => 'counter_speed',
				'std' => '1500',
				'min' => '100',
				'max' => '5000',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => 'Counter',
				'ext' => '',
			),

			array(
				'label' => __( 'Counter Interval', 'dslc_string' ),
				'id' => 'counter_interval',
				'std' => '25',
				'min' => '1',
				'max' => '200',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => 'Counter',
				'ext' => '',
			),

		);

		$dslc_options = array_merge(
			$dslc_options,

			// Counter Box Background Color
			lc_general('.met_box_counter', '', array('background-color' => '#F7F6F4'), 'Box'),

			// Box Borders
			lc_borders('.met_box_counter', '', array(), array(), '0', '', 'solid' ),

			// Counter
			lc_general('.met_box_counter .met_box_counter_digit', 'Counter Number', array('background-color' => '#ECEBE9','color' => '#373B3D','font-size' => '48','line-height' => '98', 'font-weight' => '600')),

			// Counter Paddings
			lc_paddings('.met_box_counter .met_box_counter_digit', 'Counter Number', array('t' => '0', 'r' => '23', 'b' => '0', 'l' => '23')),

			// Counter Text
			lc_general('.met_box_counter .met_box_counter_text', 'Counter Text', array('color' => '#74706D','font-size' => '14','line-height' => '22', 'font-weight' => '')),

			// Counter Text Paddings
			lc_paddings('.met_box_counter .met_box_counter_text', 'Counter Number', array('t' => '0', 'r' => '20', 'b' => '0', 'l' => '20'))

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
        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
        	$asyncScripts = '["'.get_template_directory_uri().'/js/jquery.appear.js","'.get_template_directory_uri().'/js/jquery.countTo.js"]';
        }else{
            wp_enqueue_script('metcreative-appear');
            wp_enqueue_script('metcreative-countto');
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

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('boxcounter_');
        ?>

        <div id="<?php echo $elementID; ?>" class="met_box_counter <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <div class="met_box_counter_row">
				<?php if( in_array( 'counter', $elements ) ): ?>
                <div class="countTo met_box_counter_digit" data-from="0" data-to="<?php echo $options['counter'] ?>" data-speed="<?php echo $options['counter_speed'] ?>" data-refresh-interval="<?php echo $options['counter_interval'] ?>">0</div>
				<?php endif; ?>

				<?php if( in_array( 'counter_text', $elements ) ): ?>
				<span class="met_box_counter_text"><?php echo $options['counter_text'] ?></span>
				<?php endif; ?>
            </div>
        </div>

		<?php if( in_array( 'counter', $elements ) ): ?>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["countTo|<?php echo $elementID ?>"]);});</script>
		<?php endif; ?>
        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}