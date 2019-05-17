<?php

// Register Module
function register_countdown_module() {
	return dslc_register_module( "MET_Countdown" );
}
add_action('dslc_hook_register_modules', 'register_countdown_module' );

class MET_Countdown extends DSLC_Module {

    var $module_id = 'MET_Countdown';
    var $module_title = 'Countdown';
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
				'std' => 'D',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (DAYs)', 'dslc_string' ),
				'id' => 'label_days',
				'std' => 'D',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (HOUR)', 'dslc_string' ),
				'id' => 'label_hour',
				'std' => 'H',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (HOURs)', 'dslc_string' ),
				'id' => 'label_hours',
				'std' => 'H',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (MINUTE)', 'dslc_string' ),
				'id' => 'label_minute',
				'std' => 'M',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (MINUTEs)', 'dslc_string' ),
				'id' => 'label_minutes',
				'std' => 'M',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (SECOND)', 'dslc_string' ),
				'id' => 'label_second',
				'std' => 'S',
				'type' => 'text',
				'tab' => 'labels'
			),
			array(
				'label' => __( 'LABEL (SECONDs)', 'dslc_string' ),
				'id' => 'label_seconds',
				'std' => 'S',
				'type' => 'text',
				'tab' => 'labels'
			),

		);

		$dslc_options = array_merge(
			$dslc_options,

			// Counter Box Background Color
			lc_general('.met_countdown_wrap', '', array('background-color' => 'transparent','text-align' => 'center'), 'Box'),

			// Box Borders
			lc_borders('.met_countdown_wrap .met_countdown', '', array(), array(), '3', '#000000', 'solid' ),

			// Date
			lc_general('.met_countdown_wrap .ce-date', 'Date', array('background-color' => '','color' => '#000000','font-size' => '42','line-height' => '43', 'font-weight' => '600')),

			// Label
			lc_general('.met_countdown_wrap .ce-label', 'Label', array('background-color' => '','color' => '#7B7B7B','font-size' => '42','line-height' => '43', 'font-weight' => '600')),

			// Box Paddings
			lc_paddings('.met_countdown_wrap .met_countdown', '', array('t' => '25', 'r' => '40', 'b' => '25', 'l' => '40'))

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
        $elementID = uniqid('countdown_');

        ?>
        <div class="met_countdown_wrap">
            <div class="met_countdown clearfix" id="<?php echo $elementID; ?>" data-day="<?php echo $options['date_day'] ?>" data-month="<?php echo $options['date_month'] ?>" data-year="<?php echo $options['date_year'] ?>" data-hour="<?php echo $options['date_hour'] ?>" data-minute="<?php echo $options['date_minute'] ?>" data-second="<?php echo $options['date_second'] ?>" data-dayslabel="<?php echo $options['label_days'] ?>" data-daylabel="<?php echo $options['label_day'] ?>" data-hourslabel="<?php echo $options['label_hours'] ?>" data-hourlabel="<?php echo $options['label_hour'] ?>" data-minuteslabel="<?php echo $options['label_minutes'] ?>" data-minutelabel="<?php echo $options['label_minute'] ?>" data-secondslabel="<?php echo $options['label_seconds'] ?>" data-secondlabel="<?php echo $options['label_second'] ?>">
                <div><span class="ce-date ce-days"></span><span class="ce-label ce-days-label"></span></div>
                <div><span class="ce-date ce-hours"></span><span class="ce-label ce-hours-label"></span></div>
                <div><span class="ce-date ce-minutes"></span><span class="ce-label ce-minutes-label"></span></div>
                <div><span class="ce-date ce-seconds"></span><span class="ce-label ce-seconds-label"></span></div>
            </div>
        </div>
		<script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["setCountDown|<?php echo $elementID ?>"]);});</script>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}