<?php

// Register Module
function register_progbarverti_module() {
	return dslc_register_module( "MET_ProgressBarVertical" );
}
add_action('dslc_hook_register_modules','register_progbarverti_module');

class MET_ProgressBarVertical extends DSLC_Module {

    var $module_id = 'MET_ProgressBarVertical';
    var $module_title = 'Progress Bar Vertical';
    var $module_icon = 'info';
    var $module_category = 'met - general';

    function options() {

		$dslc_options = array(
			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'title counter',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Percent Counter', 'dslc_string' ),
						'value' => 'counter'
					),
				)
			),

			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'CLICK TO EDIT',
				'type' => 'text',
				'visibility' => 'hidden'
			),

			array(
				'label' => __( 'Progress Percent', 'dslc_string' ),
				'id' => 'percent',
				'std' => '75',
				'type' => 'text',
			),

			array(
				'label' => __( 'Counter Speed', 'dslc_string' ),
				'id' => 'counter_speed',
				'std' => '2200',
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
				'std' => '35',
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

			// Line Background Color
			lc_general('.met_progress_bar_3_wrap', '', array('background-color' => '#F4F5F5','height' => '270'), 'Line'),

			// Line Background Color
			lc_general('.met_progress_bar_3_progress', '', array('background-color' => ''), 'Line Fill'),

			// Title
			lc_general('.met_progress_bar_3_wrap .met_progress_bar_3_title', 'Title', array('color' =>'#393939','font-size' => '14','line-height' => '30','font-weight' => '600')),

			// Title
			lc_general('.met_progress_bar_3_wrap .countTo, .met_progress_bar_3_wrap .extension', 'Counter', array('color' =>'#393939','font-size' => '48','line-height' => '77','font-weight' => '600')),

			// Paddings
			lc_paddings('.met_progress_bar_2_wrap span', 'Title', array('t' => '0', 'r' => '10', 'b' => '0', 'l' => '10'))
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

        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
        	$asyncScripts = '["'.get_template_directory_uri().'/js/jquery.appear.js","'.get_template_directory_uri().'/js/jquery.countTo.js"]';
		}else{
			wp_enqueue_script('metcreative-appear');
			wp_enqueue_script('metcreative-countto');
		}

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('progressbar3_');
        ?>

        <div id="<?php echo $elementID ?>" class="met_progress_bar_3_wrap <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <div class="met_progress_bar_3_counts">
				<?php if( in_array( 'counter', $elements ) ): ?>
                <div>
                    <span class="countTo" data-from="0" data-to="<?php echo $options['percent'] ?>" data-speed="<?php echo $options['counter_speed'] ?>" data-refresh-interval="<?php echo $options['counter_interval'] ?>"></span>
                    <span class="extension">%</span>
                </div>
				<?php endif; ?>
				<?php if( in_array( 'title', $elements ) ) : ?>
					<?php if( $dslc_is_admin ): ?>
						<span class="met_progress_bar_3_title dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></span>
					<?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
						<span class="met_progress_bar_3_title"><?php echo stripslashes($options['title']); ?></span>
					<?php endif; ?>
				<?php endif; ?>
            </div>
            <div class="met_progress_bar_3_progress met_bgcolor" style="height: <?php echo $options['percent'] ?>%"></div>
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