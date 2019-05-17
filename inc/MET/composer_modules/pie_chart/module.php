<?php

// Register Module
function register_piechart_module() {
	return dslc_register_module( "MET_PieChart" );
}
add_action('dslc_hook_register_modules','register_piechart_module');

class MET_PieChart extends DSLC_Module {

    var $module_id = 'MET_PieChart';
    var $module_title = 'Pie';
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
				'label' => __( 'Circle Percent', 'dslc_string' ),
				'id' => 'circle_percent',
				'std' => '75',
				'min' => '0',
				'max' => '100',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'tab' => 'Circle',
				'ext' => '',
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

			/* Styling */
			array(
				'label' => __( 'Circle Color', 'dslc_string' ),
				'id' => 'circle_trackcolor',
				'std' => '#F7F7F7',
				'type' => 'color',
				'section' => 'styling',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.pie_handler',
                'affect_on_change_rule' => '',
			),

			array(
				'label' => __( 'Circle Fill Color', 'dslc_string' ),
				'id' => 'circle_barcolor',
				'std' => get_met_option('met_color'),
				'type' => 'color',
				'section' => 'styling',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.pie_handler',
                'affect_on_change_rule' => '',
			),

			array(
				'label' => __( 'Circle Size', 'dslc_string' ),
				'id' => 'circle_size',
				'std' => '210',
				'min' => '100',
				'max' => '1000',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_pie_chart',
				'affect_on_change_rule' => 'width,height',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Circle Line Width', 'dslc_string' ),
				'id' => 'circle_line_width',
				'std' => '20',
				'min' => '1',
				'max' => '100',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.pie_handler',
				'affect_on_change_rule' => '',
				'section' => 'styling',
				'ext' => '',
			),
        );

		$dslc_options = array_merge(
			$dslc_options,

			// Counter
			lc_general('.met_pie_chart .met_pie_chart_counter', 'Counter Number', array('color' => '#373B3D','font-size' => '60','line-height' => '65', 'font-weight' => '600')),

			// Counter Text
			lc_general('.met_pie_chart .met_pie_chart_text', 'Counter Text', array('color' => '#373B3D','font-size' => '18','line-height' => '35', 'font-weight' => '600'))

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
		    'groups'   => array('animation','parallax'),
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
        
        $asyncScripts = "[]";
        if ( $dslc_is_admin ){

            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.appear.js","'.get_template_directory_uri().'/js/jquery.countTo.js","'.get_template_directory_uri().'/js/jquery.easypiechart.min.js"]';
        }else{
            wp_enqueue_script('metcreative-easypiechart');
            wp_enqueue_script('metcreative-appear');

			wp_enqueue_script('metcreative-countto');
        }

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('piechart_');

        ?>

		<div id="<?php echo $elementID; ?>" style="line-height: 210px;" class="met_pie_chart <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?> data-linewidth="<?php echo $options['circle_line_width'] ?>" data-percent="0" data-animatepercent="<?php echo $options['circle_percent'] ?>" data-size="<?php echo $options['circle_size'] ?>" data-barcolor="<?php echo lc_rgb_to_hex($options['circle_barcolor']) ?>" data-trackcolor="<?php echo lc_rgb_to_hex($options['circle_trackcolor']) ?>">

			<?php if( in_array( 'counter', $elements ) ): ?>
			<span class="met_pie_chart_counter countTo" data-from="0" data-to="<?php echo $options['counter'] ?>" data-speed="<?php echo $options['counter_speed'] ?>" data-refresh-interval="<?php echo $options['counter_interval'] ?>">0</span>
			<?php endif; ?>

			<?php if( in_array( 'counter_text', $elements ) ): ?>
			<span class="met_pie_chart_text"><?php echo $options['counter_text'] ?></span>
			<?php endif; ?>

			<span class="pie_handler" style="display: none"></span>
		</div>

		<?php if( in_array( 'counter', $elements ) ): ?>
    		<script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["pieChart|<?php echo $elementID ?>"]);});</script>
		<?php endif;
        echo $met_shared_options['script'];

        /* Module output ends here */
        $this->module_end( $options );

    }

}