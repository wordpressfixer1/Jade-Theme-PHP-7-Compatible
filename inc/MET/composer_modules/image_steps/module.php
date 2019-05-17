<?php

// Register Module
function register_imgsteps_module() {
	return dslc_register_module( "MET_ImageSteps" );
}
add_action('dslc_hook_register_modules','register_imgsteps_module');

class MET_ImageSteps extends DSLC_Module {

    var $module_id = 'MET_ImageSteps';
    var $module_title = 'Image Steps';
    var $module_icon = 'info';
    var $module_category = 'met - general';

    function options() {

		$dslc_options = array(

			array(
				'label' => __( 'Step Count', 'dslc_string' ),
				'id' => 'step_count',
				'std' => '3',
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

		);

		for($i=1; $i <= 4; $i++){
			$step_options = array(
				array(
					'label' => sprintf( __('Circle Image (%1$s)', 'dslc_string'), $i ),
					'id' => 'circle_image_'.$i,
					'std' => 'http://placehold.it/240x234',
					'type' => 'image',
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
				)
			);

			$dslc_options = array_merge($dslc_options,$step_options);
		}

		$dslc_options = array_merge(
			$dslc_options,

			lc_borders('.met_image_step_box img', '', array(
				't' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'r' => array('width' => '6', 'color' => '#EFEDE9', 'style' => 'solid'),
				'b' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'l' => array('width' => '0', 'color' => '', 'style' => 'none'),
			), array(), '', '', '' ),

			// Order Right Line
			lc_general('.met_image_step_box:after', '', array('background-color'=>'#EFEDE9'), 'Right Line'),

			// Order
			lc_general('.met_image_step_order', 'Order Box', array('width'=>'40','height' => '40','background-color'=>'#EFEDE9','color'=>'#000000','font-size'=>'16','line-height'=>'40','text-align'=>'center'), 'Order'),

			// Order Margins
			lc_margins('.met_image_step_order', 'Order Box', array('t' => '', 'r' => '10', 'b' => '', 'l' => '')),

			// Order Box Line
			lc_general('.met_image_step_order:after', 'Order Box Line', array('width'=>'2','height' => '30','background-color'=>'#EFEDE9'), 'Line'),

			// Title
			lc_general('.met_image_step_title', 'Title', array('color' => '#74706D','font-size' => '16','line-height' => '40','font-weight' => '40','text-align' => 'left')),

			// Hover
			lc_general('.met_image_step:hover .met_image_step_box:after, .met_image_step:hover .met_image_step_order:after, .met_image_step:hover .met_image_step_order', 'Hover', array('background-color' => get_met_option('met_color'))),

			// Hover
			lc_general('.met_image_step:hover .met_image_step_order', 'Hover', array('color' => '#ffffff'),'Order Text'),

			// Hover
			lc_general('.met_image_step:hover .met_image_step_title', 'Hover', array('color' => get_met_option('met_color')),'Title')

		);

		$right_border_hover_options = array(
			array(
				'label' => __( 'Right Border Color', 'dslc_string' ),
				'id' => 'border_right_hover',
				'std' => get_met_option('met_color'),
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_image_step:hover .met_image_step_box img',
				'affect_on_change_rule' => 'border-right-color',
				'section' => 'styling',
				'tab' => 'Hover',
			),
		);

		$dslc_options = array_merge($dslc_options,$right_border_hover_options);

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

        $elementID = uniqid('imagesteps_');

		$step_count = $options['step_count'];
        ?>

		<div id="<?php echo $elementID ?>" class="met_image_steps cols_<?php echo $options['step_count'] ?> clearfix">
			<?php for($i=1; $i <= $step_count; $i++): ?>
				<?php
				$title_id = 'step_title_'.$i;
				?>
				<a href="<?php echo $options['circle_link_url_'.$i] ?>" target="<?php echo $options['circle_link_target_'.$i] ?>" class="met_image_step">
					<div class="met_image_step_box"><img src="<?php echo $options['circle_image_'.$i] ?>" alt="<?php echo esc_attr($options[$title_id]); ?>" /></div>

					<div class="met_image_step_bottom">
						<span class="met_image_step_order"><?php echo $options['circle_text_'.$i] ?></span>
						<?php if( $dslc_is_admin ): ?>
							<span class="met_image_step_title dslca-editable-content" data-id="<?php echo $title_id ?>" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options[$title_id]); ?></span>
						<?php elseif( !empty($options[$title_id] ) && !$dslc_is_admin): ?>
							<span class="met_image_step_title"><?php echo stripslashes($options[$title_id]); ?></span>
						<?php endif; ?>
					</div>
				</a>
			<?php endfor; ?>
		</div>

        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}