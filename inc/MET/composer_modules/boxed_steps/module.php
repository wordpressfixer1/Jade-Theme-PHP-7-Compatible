<?php

// Register Module
function register_boxedsteps_module() {
	return dslc_register_module( "MET_BoxedSteps" );
}
add_action('dslc_hook_register_modules','register_boxedsteps_module');

class MET_BoxedSteps extends DSLC_Module {

    var $module_id = 'MET_BoxedSteps';
    var $module_title = 'Boxed Steps';
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
				'std' => 'step_title step_sub_title box_arrow',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Step Title', 'dslc_string' ),
						'value' => 'step_title'
					),
					array(
						'label' => __( 'Step Sub Title', 'dslc_string' ),
						'value' => 'step_sub_title'
					),
					array(
						'label' => __( 'Box Arrow', 'dslc_string' ),
						'value' => 'box_arrow'
					),
				)
			),

			array(
				'label' => __( 'Step Count', 'dslc_string' ),
				'id' => 'step_count',
				'std' => '4',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( '4 Elements', 'dslc_string' ),
						'value' => '4'
					),
					array(
						'label' => __( '3 Elements', 'dslc_string' ),
						'value' => '3'
					),
				)
			),

			array(
				'label' => __( 'Current Step', 'dslc_string' ),
				'id' => 'current_step',
				'std' => '0',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => '0'
					),
					array(
						'label' => __( 'First', 'dslc_string' ),
						'value' => '1'
					),
					array(
						'label' => __( 'Second', 'dslc_string' ),
						'value' => '2'
					),
					array(
						'label' => __( 'Third', 'dslc_string' ),
						'value' => '3'
					),
					array(
						'label' => __( 'Fourth', 'dslc_string' ),
						'value' => '4'
					),
				)
			),

		);

		for($i=1; $i <= 4; $i++){
			$step_options = array(
				array(
					'label' => sprintf( __('Box Link URL (%1$s)', 'dslc_string'), $i ),
					'id' => 'circle_link_url_'.$i,
					'std' => '#',
					'type' => 'text',
					'tab' => 'Step '.$i
				),
				array(
					'label' => sprintf( __('Open in (%1$s)', 'dslc_string'), $i ),
					'id' => 'circle_link_target_'.$i,
					'std' => '_self',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => __( 'Same Tab', 'dslc_string' ),
							'value' => '_self',
						),
						array(
							'label' => __( 'New Tab', 'dslc_string' ),
							'value' => '_blank',
						),
					),
					'tab' => 'Step '.$i
				),

				/* Click to edit contents */
				array(
					'label' => 'Title',
					'id' => 'step_title_'.$i,
					'std' => 'CLICK TO EDIT',
					'type' => 'text',
					'visibility' => 'hidden'
				),
				array(
					'label' => 'Sub Title',
					'id' => 'step_sub_title_'.$i,
					'std' => 'Click To Edit',
					'type' => 'text',
					'visibility' => 'hidden'
				),
			);

			$dslc_options = array_merge($dslc_options,$step_options);
		}

		$dslc_options = array_merge(
			$dslc_options,

			// Step
			lc_general('.met_boxed_step', '', array('background-color' => '#FBFBF9','color'=>'#000000'), 'Step'),

			// Step Paddings
			lc_paddings('.met_boxed_step', 'Paddings', array('t' => '30', 'r' => '20', 'b' => '30', 'l' => '20')),

			lc_borders('.met_boxed_step', 'Borders', array(
				't' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'r' => array('width' => '5', 'color' => '#EFEEE9', 'style' => 'solid'),
				'b' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'l' => array('width' => '0', 'color' => '', 'style' => 'none'),
			), array(), '', '', '' ),

			// Arrow
			lc_general('.met_boxed_step_icon', 'Arrow', array('color'=>'#000000','font-size'=>'31'), 'Arrow'),

			// Title
			lc_general('.met_boxed_step h4', 'Title', array('color' => '#000000','font-size' => '24','line-height' => '29','font-weight' => '600','text-align' => 'left')),

			// Sub Title
			lc_general('.met_boxed_step h5', 'Sub Title', array('color' => '#000000','font-size' => '16','line-height' => '19','font-weight' => '400','text-align' => 'left')),

			// Current
			lc_general('.met_boxed_step.current', 'Current', array('background-color' => get_met_option('met_color')), 'Current'),

			// Current
			lc_general('.met_boxed_step.current .met_boxed_step_icon, .met_boxed_step.current h4, .met_boxed_step.current h5', 'Current', array('color' => '#ffffff'), 'Current'),

			// hover
			lc_general('.met_boxed_step:hover', 'Hover', array('background-color' => '#ffca07'), 'Hover'),

			// hover
			lc_general('.met_boxed_step:hover .met_boxed_step_icon, .met_boxed_step:hover h4, .met_boxed_step:hover h5', 'Hover', array('color' => '#ffffff'), 'Hover')
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

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('boxedsteps_');

		$step_count = $options['step_count'];
        ?>

		<div id="<?php echo $elementID ?>" class="met_boxed_steps cols_<?php echo $options['step_count'] ?> clearfix">
			<?php for($i=1; $i <= $step_count; $i++): ?>
				<?php
				$title_id = 'step_title_'.$i;
				$sub_title_id = 'step_sub_title_'.$i;
				?>
				<a href="<?php echo $options['circle_link_url_'.$i] ?>" target="<?php echo $options['circle_link_target_'.$i] ?>" class="met_boxed_step <?php echo (($i==$options['current_step']) ? 'current' : '') ?>">
					<?php if( in_array( 'step_title', $elements ) ) : ?>
						<?php if( $dslc_is_admin ): ?>
							<h4 class="dslca-editable-content" data-id="<?php echo $title_id ?>" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options[$title_id]); ?></h4>
						<?php elseif( !empty($options[$title_id] ) && !$dslc_is_admin): ?>
							<h4><?php echo stripslashes($options[$title_id]); ?></h4>
						<?php endif; ?>
					<?php endif; ?>

					<?php if( in_array( 'step_sub_title', $elements ) ) : ?>
						<?php if( $dslc_is_admin ): ?>
							<h5 class="dslca-editable-content" data-id="<?php echo $sub_title_id ?>" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options[$sub_title_id]); ?></h5>
						<?php elseif( !empty($options[$sub_title_id] ) && !$dslc_is_admin): ?>
							<h5><?php echo stripslashes($options[$sub_title_id]); ?></h5>
						<?php endif; ?>
					<?php endif; ?>

					<?php if( in_array( 'box_arrow', $elements ) ) : ?>
						<i class="dslc-icon dslc-icon-caret-right met_boxed_step_icon"></i>
					<?php endif; ?>
				</a>
			<?php endfor; ?>
		</div>

        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}