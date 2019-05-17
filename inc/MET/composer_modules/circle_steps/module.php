<?php

// Register Module
function register_circlesteps_module() {
	return dslc_register_module( "MET_CircleSteps" );
}
add_action('dslc_hook_register_modules','register_circlesteps_module');

class MET_CircleSteps extends DSLC_Module {

    var $module_id = 'MET_CircleSteps';
    var $module_title = 'Circle Steps';
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
				'std' => 'circle_text step_title step_sub_title',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Circle Text', 'dslc_string' ),
						'value' => 'circle_text'
					),
					array(
						'label' => __( 'Step Title', 'dslc_string' ),
						'value' => 'step_title'
					),
					array(
						'label' => __( 'Step Sub Title', 'dslc_string' ),
						'value' => 'step_sub_title'
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
					'label' => sprintf( __('Circle Type (%1$s)', 'dslc_string'), $i ),
					'id' => 'circle_type_'.$i,
					'std' => 'text',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => __( 'Text', 'dslc_string' ),
							'value' => 'text'
						),
						array(
							'label' => __( 'Icon', 'dslc_string' ),
							'value' => 'icon'
						),
					),
					'tab' => 'Step '.$i
				),
				array(
					'label' => sprintf( __('Circle Text (%1$s)', 'dslc_string'), $i ),
					'id' => 'circle_text_'.$i,
					'std' => $i,
					'type' => 'text',
					'tab' => 'Step '.$i
				),
				array(
					'label' => sprintf( __('Circle Icon (%1$s)', 'dslc_string'), $i ),
					'id' => 'circle_icon_'.$i,
					'std' => 'rocket',
					'type' => 'icon',
					'tab' => 'Step '.$i
				),
				array(
					'label' => sprintf( __('Circle Link URL (%1$s)', 'dslc_string'), $i ),
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

			// Circle
			lc_general('.met_circle_step_button', '', array('background-color' => '#EFEEE9','background-color:hover' => '','color'=>'#000000','color:hover'=>'','width' => '100','height'=>'100','font-size'=>'36', 'line-height'=>'100','font-weight'=>'600','text-align' => 'center'), 'Circle'),

			// Circle Border Radius
			lc_borderRadius('.met_circle_step_button', '', '50'),

			// Circle Borders
			lc_borders('.met_circle_step_button', '', array(), array(), '0', '', 'solid' ),

			// Line
			lc_general('.met_circle_step_col:before', 'Line', array('background-color' => '#EFEEE9','height'=>'5'), 'Line'),

			// Title
			lc_general('.met_circle_step_texts h4', 'Title', array('color' => '#000000','font-size' => '16','line-height' => '20','font-weight' => '600','text-align' => 'center')),

			// Sub Title
			lc_general('.met_circle_step_texts h5', 'Sub Title', array('color' => '#000000','font-size' => '14','line-height' => '20','font-weight' => '400','text-align' => 'center')),

			// Current
			lc_general('.met_circle_step_col.current .met_circle_step_button', 'Current', array('background-color' => get_met_option('met_color'),'color'=>'#ffffff'), 'Current')
		);

		$arrow_options = array(
			array(
				'label' => __( 'Line Top Distance', 'dslc_string' ),
				'id' => 'circle_line_top',
				'std' => '50',
				'min' => '1',
				'max' => '500',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_circle_step_col:before',
				'affect_on_change_rule' => 'top',
				'ext' => 'px',
				'section' => 'styling',
				'tab' => 'Line',
			),
		);

		$dslc_options = array_merge($dslc_options,$arrow_options);

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

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('circlesteps_');

		$step_count = $options['step_count'];
        ?>

		<div id="<?php echo $elementID ?>" class="met_circle_steps cols_<?php echo $options['step_count'] ?> clearfix <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
			<?php for($i=1; $i <= $step_count; $i++): ?>
				<?php
				$step_button_text = ($options['circle_type_'.$i]) == 'text' ? $options['circle_text_'.$i] : '<i class="dslc-icon dslc-icon-'.$options['circle_icon_'.$i].'"></i>';
				$title_id = 'step_title_'.$i;
				$sub_title_id = 'step_sub_title_'.$i;
				?>
				<div class="met_circle_step_col <?php echo (($i==$options['current_step']) ? 'current' : '') ?>">
					<div class="met_circle_step">
						<a href="<?php echo $options['circle_link_url_'.$i] ?>" target="<?php echo $options['circle_link_target_'.$i] ?>" class="met_circle_step_button"><?php echo $step_button_text ?></a>

						<div class="met_circle_step_texts">
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
						</div>
					</div>
				</div>
			<?php endfor; ?>
		</div>
        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}