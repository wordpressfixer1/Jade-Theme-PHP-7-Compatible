<?php

// Register Module
function register_countdowntwo_module() {
	return dslc_register_module( "MET_Countdown2" );
}
add_action('dslc_hook_register_modules','register_countdowntwo_module');

class MET_Countdown2 extends DSLC_Module {

	var $module_id = 'MET_Countdown2';
	var $module_title = 'Countdown 2';
	var $module_icon = 'info';
	var $module_category = 'met - counters';

	function options() {

		$dslc_options = array(

			array(
				'label' => __( 'Target (YEAR)', 'dslc_string' ),
				'id' => 'date_year',
				'std' => '2016',
				'type' => 'text',
			),
			array(
				'label' => __( 'Target (MONTH)', 'dslc_string' ),
				'id' => 'date_month',
				'std' => '02',
				'type' => 'text',
			),
			array(
				'label' => __( 'Target (DAY)', 'dslc_string' ),
				'id' => 'date_day',
				'std' => '01',
				'type' => 'text',
			),
			array(
				'label' => __( 'Target (HOUR)', 'dslc_string' ),
				'id' => 'date_hour',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Target (MINUTE)', 'dslc_string' ),
				'id' => 'date_minute',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'Target (SECOND)', 'dslc_string' ),
				'id' => 'date_second',
				'std' => '',
				'type' => 'text',
			),

			/* LABELS */
			array(
				'label' => __( 'LABEL (DAY)', 'dslc_string' ),
				'id' => 'label_day',
				'std' => 'DAY',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (DAYs)', 'dslc_string' ),
				'id' => 'label_days',
				'std' => 'DAYS',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (HOUR)', 'dslc_string' ),
				'id' => 'label_hour',
				'std' => 'HOUR',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (HOURs)', 'dslc_string' ),
				'id' => 'label_hours',
				'std' => 'HOURS',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (MINUTE)', 'dslc_string' ),
				'id' => 'label_minute',
				'std' => 'MINUTE',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (MINUTEs)', 'dslc_string' ),
				'id' => 'label_minutes',
				'std' => 'MINUTES',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (SECOND)', 'dslc_string' ),
				'id' => 'label_second',
				'std' => 'SECOND',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (SECONDs)', 'dslc_string' ),
				'id' => 'label_seconds',
				'std' => 'SECONDS',
				'type' => 'text',
				'tab' => 'labels'
			),

			/* Styling */
			array(
				'label' => __( 'Separator Colors', 'dslc_string' ),
				'id' => 'sep_color',
				'std' => '#000000',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_countdown2 > div',
				'affect_on_change_rule' => 'border-left-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Separator Width', 'dslc_string' ),
				'id' => 'sep_width',
				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_countdown2 > div',
				'affect_on_change_rule' => 'border-left-width',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Separator Style', 'dslc_string' ),
				'id' => 'sep_style',
				'std' => 'solid',
				'type' => 'select',
				'choices' => borderStyles(),
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_countdown2 > div',
				'affect_on_change_rule' => 'border-left-style',
				'section' => 'styling',
			),

		);

		$dslc_options = array_merge(
			$dslc_options,

			// Counter Box Background Color
			lc_general('.met_countdown2_wrap', '', array('background-color' => 'transparent','text-align' => 'center'), 'Box'),

			// Box Paddings
			lc_paddings('.met_countdown2_wrap .met_countdown', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

			// Date Box Paddings
			lc_paddings('.met_countdown2_wrap .met_countdown2 > div', 'Date Box', array('t' => '15', 'r' => '60', 'b' => '15', 'l' => '60')),

			// Box Borders
			lc_borders('.met_countdown2_wrap .met_countdown2', '', array(), array(), '0', '', 'solid' ),

			// Date
			lc_general('.met_countdown2_wrap .ce-date', 'Date', array('background-color' => 'transparent','color' => '#000000','font-size' => '60','line-height' => '43', 'font-weight' => '600','text-align' => 'center')),

			// Label
			lc_general('.met_countdown2_wrap .ce-label', 'Label', array('background-color' => 'transparent','color' => '#000000','font-size' => '18','line-height' => '43', 'font-weight' => '600','text-align' => 'center'))

		);

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
        if ( $dslc_is_admin )
            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.counteverest.min.js"]';
        else
            wp_enqueue_script('metcreative-counteverest');
		$elementID = uniqid('countdown2_');
		?>
		<div class="met_countdown2_wrap">
			<div class="met_countdown2 clearfix" id="<?php echo $elementID; ?>" data-day="<?php echo $options['date_day'] ?>" data-month="<?php echo $options['date_month'] ?>" data-year="<?php echo $options['date_year'] ?>" data-hour="<?php echo $options['date_hour'] ?>" data-minute="<?php echo $options['date_minute'] ?>" data-second="<?php echo $options['date_second'] ?>" data-dayslabel="<?php echo $options['label_days'] ?>" data-daylabel="<?php echo $options['label_day'] ?>" data-hourslabel="<?php echo $options['label_hours'] ?>" data-hourlabel="<?php echo $options['label_hour'] ?>" data-minuteslabel="<?php echo $options['label_minutes'] ?>" data-minutelabel="<?php echo $options['label_minute'] ?>" data-secondslabel="<?php echo $options['label_seconds'] ?>" data-secondlabel="<?php echo $options['label_second'] ?>">
				<div><span class="ce-date ce-days"></span> <span class="ce-label ce-days-label"></span></div>
				<div><span class="ce-date ce-hours"></span> <span class="ce-label ce-hours-label"></span></div>
				<div><span class="ce-date ce-minutes"></span> <span class="ce-label ce-minutes-label"></span></div>
				<div><span class="ce-date ce-seconds"></span> <span class="ce-label ce-seconds-label"></span></div>
			</div>
		</div>
		<script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["setCountDown|<?php echo $elementID ?>"]);});</script>
		<?php
		/* Module output ends here */
		$this->module_end( $options );
	}
}