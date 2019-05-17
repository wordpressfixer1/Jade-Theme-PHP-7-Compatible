<?php

// Register Module
function register_banner_module() {
	return dslc_register_module( "MET_Banner" );
}
add_action('dslc_hook_register_modules','register_banner_module');

class MET_Banner extends DSLC_Module {

    var $module_id = 'MET_Banner';
    var $module_title = 'Banner';
    var $module_icon = 'info';
    var $module_category = 'met - general';

    function options() {

        $dslc_options = array(

			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Title 1', 'dslc_string' ),
				'id' => 'title_1',
				'std' => 'YOUR',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Title 2', 'dslc_string' ),
				'id' => 'title_2',
				'std' => 'SLOGAN',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Title 3', 'dslc_string' ),
				'id' => 'title_3',
				'std' => 'CAMPAING TEXT HERE',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Button Text', 'dslc_string' ),
				'id' => 'button_text',
				'std' => 'CLICK HERE',
				'type' => 'text',
				'visibility' => 'hidden'
			),


			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'title_1 title_2 title_3 button',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Title 1', 'dslc_string' ),
						'value' => 'title_1'
					),
					array(
						'label' => __( 'Title 2', 'dslc_string' ),
						'value' => 'title_2'
					),
					array(
						'label' => __( 'Title 3', 'dslc_string' ),
						'value' => 'title_3'
					),
					array(
						'label' => __( 'Button', 'dslc_string' ),
						'value' => 'button'
					),
					array(
						'label' => __( 'Inner Borders', 'dslc_string' ),
						'value' => 'borders'
					),
					array(
						'label' => __( 'Second Part', 'dslc_string' ),
						'value' => 'second_part'
					),
				)
			),

			array(
				'label' => __( 'Titles Single Line', 'dslc_string' ),
				'id' => 'single_line',
				'std' => '',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => '0'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => '1'
					),
				)
			),

			array(
				'label' => __( 'Background Image', 'dslc_string' ),
				'id' => 'background_image',
				'std' => '',
				'type' => 'image',
				'tab' => 'background'
			),

			array(
				'label' => __( 'Background Fit', 'dslc_string' ),
				'id' => 'bg_fit',
				'std' => '0',
				'type' => 'select',
				'tab' => 'background',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( 'Fit', 'dslc_string' ),
						'value' => 'fit',
					),
					array(
						'label' => __( 'Fit Horizontally', 'dslc_string' ),
						'value' => 'fit_horizontally',
					),
					array(
						'label' => __( 'Fit Vertically', 'dslc_string' ),
						'value' => 'fit_vertically',
					)
				),
			),

			array(
				'label' => __( 'Background Position Y', 'dslc_string' ),
				'id' => 'bg_pos_y',
				'std' => '0',
				'type' => 'select',
				'tab' => 'background',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( 'Center', 'dslc_string' ),
						'value' => 'center',
					),
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom',
					)
				),
			),

			array(
				'label' => __( 'Background Position X', 'dslc_string' ),
				'id' => 'bg_pos_x',
				'std' => '0',
				'type' => 'select',
				'tab' => 'background',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right',
					)
				),
			),

			array(
				'label' => __( 'Button URL', 'dslc_string' ),
				'id' => 'button_url',
				'std' => 'http://#',
				'type' => 'text',
			),
			array(
				'label' => __( 'Position Middle', 'dslc_string' ),
				'id' => 'button_middle',
				'std' => '',
				'type' => 'select',
				'tab' => 'button',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => '0'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => '1'
					),
				)
			),

			array(
				'label' => __( 'Position Center', 'dslc_string' ),
				'id' => 'button_center',
				'std' => '1',
				'type' => 'select',
				'tab' => 'button',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => '0'
					),
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => '1'
					),
				)
			),

			array(
				'label' => __( 'Button Position Y', 'dslc_string' ),
				'id' => 'button_pos_y',
				'std' => 'bottom',
				'type' => 'select',
				'tab' => 'button',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom',
					)
				),
			),

			array(
				'label' => __( 'Button Position X', 'dslc_string' ),
				'id' => 'button_pos_x',
				'std' => '0',
				'type' => 'select',
				'tab' => 'button',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right',
					)
				),
			),

			array(
				'label' => __( 'Second Part Image', 'dslc_string' ),
				'id' => 'second_part_image',
				'std' => '',
				'type' => 'image',
				'tab' => 'second part'
			),

			array(
				'label' => __( 'Second Part Position', 'dslc_string' ),
				'id' => 'second_part_pos',
				'std' => '0',
				'type' => 'select',
				'tab' => 'second part',
				'choices' => array(
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right',
					)
				),
			),

        );

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('.met_banner_part_1', '', array('background-color' => ''), 'Box'),

			// Image Borders
			lc_borders('.met_banner_part_1 .met_banner_part_1_border', 'inner borders', array(), array(), '4', '#ffffff', 'solid' ),

			// Title 1
			lc_general('.met_banner_part_1 .met_banner_title_1', 'Title 1', array('color' => '#ffffff','font-size' => '24','line-height' => '35', 'text-align' => 'left', 'font-weight' => '600')),

			// Title 2
			lc_general('.met_banner_part_1 .met_banner_title_2', 'Title 2', array('color' => '#373B3D','font-size' => '48','line-height' => '35', 'text-align' => 'center', 'font-weight' => '600')),

			// Title 3
			lc_general('.met_banner_part_1 .met_banner_title_3', 'Title 3', array('color' => '#ffffff','font-size' => '14','line-height' => '25', 'text-align' => 'right', 'font-weight' => '600')),

			// Second Part
			lc_general('.met_banner .met_banner_part_2', 'second part', array('background-color' => '#EFEFEF'), 'Box')


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

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

		$part_1_style_atts = $part_1_class_atts = $button_class_atts = array();

		$bgImageExists = !empty($options['background_image']);
		if($bgImageExists){
			$part_1_style_atts[] = "background-image: url('".$options['background_image']."');";
		}

		$bgFit = $options['bg_fit'];
		if($bgFit != '0'){
			$part_1_class_atts[] = $bgFit;
		}

		$bgPos_y = $options['bg_pos_y'];
		if($bgPos_y != '0'){
			$part_1_class_atts[] = $bgPos_y;
		}

		$bgPos_x = $options['bg_pos_x'];
		if($bgPos_x != '0'){
			$part_1_class_atts[] = $bgPos_x;
		}

		if( $options['single_line'] == '1' ) $part_1_class_atts[] = 'single_line';

		if($options['button_middle'] != '1'){
			if( $options['button_center'] == '1' ) $button_class_atts[] = 'center';

			$buttonPos_y = $options['button_pos_y'];
			if($buttonPos_y != '0'){
				$button_class_atts[] = $buttonPos_y;
			}

			$buttonPos_x = $options['button_pos_x'];
			if($buttonPos_x != '0'){
				$button_class_atts[] = $buttonPos_x;
			}
		}else{
			$button_class_atts[] = 'middle';
		}

		$banner_wrapper_class_atts = array();
		if($options['second_part_pos'] != '0' AND in_array( 'second_part', $elements )){
			$banner_wrapper_class_atts[] = 'part_2_on_side '.$options['second_part_pos'];
		}

        ?>

		<figure class="met_banner <?php echo implode(' ',$banner_wrapper_class_atts) ?> <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>

			<figcaption class="met_banner_part_1 met_vcenter met_bgcolor met_banner_image <?php echo implode(' ',$part_1_class_atts) ?>" style="<?php echo implode(' ',$part_1_style_atts) ?>">
				<div>
					<?php if( in_array( 'title_1', $elements ) ) : ?>
						<?php if( $dslc_is_admin ): ?>
							<div class="met_banner_title_1 dslca-editable-content" data-id="title_1" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title_1']); ?></div>
						<?php elseif( !empty($options['title_1'] ) && !$dslc_is_admin): ?>
							<div class="met_banner_title_1"><?php echo stripslashes($options['title_1']); ?></div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if( in_array( 'title_2', $elements ) ) : ?>
						<?php if( $dslc_is_admin ): ?>
							<div class="met_banner_title_2 dslca-editable-content" data-id="title_2" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title_2']); ?></div>
						<?php elseif( !empty($options['title_2'] ) && !$dslc_is_admin): ?>
							<div class="met_banner_title_2"><?php echo stripslashes($options['title_2']); ?></div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if( in_array( 'title_3', $elements ) ) : ?>
						<?php if( $dslc_is_admin ): ?>
							<div class="met_banner_title_3 dslca-editable-content" data-id="title_3" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title_3']); ?></div>
						<?php elseif( !empty($options['title_3'] ) && !$dslc_is_admin): ?>
							<div class="met_banner_title_3"><?php echo stripslashes($options['title_3']); ?></div>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<?php if( in_array( 'button', $elements ) ) : ?>
					<?php if( $dslc_is_admin ): ?>
						<a href="<?php echo stripslashes($options['button_url']); ?>" class="met_banner_part_1_button btn btn-sm btn-warning dslca-editable-content <?php echo implode(' ',$button_class_atts) ?>" data-id="button_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['button_text']); ?></a>
					<?php elseif( !empty($options['title_3'] ) && !$dslc_is_admin): ?>
						<a href="<?php echo stripslashes($options['button_url']); ?>" class="met_banner_part_1_button btn btn-sm btn-warning <?php echo implode(' ',$button_class_atts) ?>"><?php echo stripslashes($options['button_text']); ?></a>
					<?php endif; ?>
				<?php endif; ?>

				<?php if( in_array( 'borders', $elements ) ) : ?>
				<div class="met_banner_part_1_borders"><div class="met_banner_part_1_border"></div></div>
				<?php endif; ?>
			</figcaption>

			<?php if( in_array( 'second_part', $elements ) ) : ?>
			<figcaption class="met_banner_part_2 met_vcenter">
				<div><img src="<?php echo $options['second_part_image'] ?>" alt=""/></div>
			</figcaption>
			<?php endif; ?>
		</figure>
        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );

    }

}