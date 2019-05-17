<?php

// Register Module
function register_ptabletwo_module() {
	return dslc_register_module( "MET_PricingTable2" );
}
add_action('dslc_hook_register_modules','register_ptabletwo_module');

class MET_PricingTable2 extends DSLC_Module {

    var $module_id = 'MET_PricingTable2';
    var $module_title = 'Simple';
    var $module_icon = 'info';
    var $module_category = 'met - pricing tables';

    function options() {

		$dslc_options = array(
			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'price_box price_decimals package_title bottom_button',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Price Box', 'dslc_string' ),
						'value' => 'price_box'
					),
					array(
						'label' => __( 'Price Decimals', 'dslc_string' ),
						'value' => 'price_decimals'
					),
					array(
						'label' => __( 'Package Title', 'dslc_string' ),
						'value' => 'package_title'
					),
					array(
						'label' => __( 'Bottom Button', 'dslc_string' ),
						'value' => 'bottom_button'
					),
				)
			),

			array(
				'label' => __( 'Price', 'dslc_string' ),
				'id' => 'price',
				'std' => '$99',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Price Decimals', 'dslc_string' ),
				'id' => 'price_decimals',
				'std' => '.99',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Package Title', 'dslc_string' ),
				'id' => 'package_title',
				'std' => 'CLICK TO EDIT',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Button Text', 'dslc_string' ),
				'id' => 'button_text',
				'std' => 'SIGN UP',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Button Link URL', 'dslc_string' ),
				'id' => 'button_url',
				'std' => '#',
				'type' => 'text'
			),
			array(
				'label' => __( 'Open in', 'dslc_string' ),
				'id' => 'button_target',
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
				)
			),
		);

		$dslc_options = array_merge(
			$dslc_options,

			// Pricing Box
			lc_general('.met_pricing_table_2 .price_box', '', array('color' => '#373B3D','color:hover' => '','background-color' => '#F1F0EB','line-height' => '20', 'text-align' => 'center')),

			// Pricing Box Borders
			lc_borders('.met_pricing_table_2', 'Borders', array(), array(), '', '', '' ),

			// Pricing Box Border Radius
			lc_borderRadius('.met_pricing_table_2', 'Border Radius',array('tl' => '2', 'tr' => '2', 'br' => '2', 'bl' => '2')),

			// Pricing Box Paddings
			lc_paddings('.met_pricing_table_2 .price_box', 'Paddings', array('t' => '71', 'r' => '0', 'b' => '71', 'l' => '0')),

			// Price
			lc_general('.met_pricing_table_2 .price_box .dollars', 'Price', array('color' => '','color:hover' => '','background-color' => '','font-size' => '72','line-height' => '57', 'font-weight' => '600')),

			// Decimal
			lc_general('.met_pricing_table_2 .price_box .cents', 'Decimals', array('color' => '','background-color' => '','font-size' => '18', 'font-weight' => '600')),

			// Package Title
			lc_general('.met_pricing_table_2 .price_box .package', 'Package Title', array('color' => '','color:hover' => '','background-color' => '','font-size' => '18','line-height' => '21', 'font-weight' => '400')),

			// Package Title
			lc_borders('.met_pricing_table_2 .price_box .package', 'Package Title', array(
				't' => array('width' => '1', 'color' => '#DFDED9', 'style' => 'solid'),
				'r' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'b' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'l' => array('width' => '0', 'color' => '', 'style' => 'none'),
			), array(), '', '', '' ),

			// Package Title Paddings
			lc_paddings('.met_pricing_table_2 .price_box .package', 'Package Title', array('t' => '7', 'r' => '20', 'b' => '7', 'l' => '20')),

			// Button
			lc_general('.met_pricing_table_2 .details', 'Bottom Button', array('color' => '#FFFFFF','background-color' => '','font-size' => '18','line-height' => '19','font-weight' => '600','text-align' => 'center')),

			// Button Paddings
			lc_paddings('.met_pricing_table_2 .details', 'Bottom Button', array('t' => '20', 'r' => '0', 'b' => '20', 'l' => '0'))

		);

		$arrow_options = array(
			array(
				'label' => __( 'Arrow Color', 'dslc_string' ),
				'id' => 'arrow_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_pricing_table_2 .details:after',
				'affect_on_change_rule' => 'border-bottom-color',
				'section' => 'styling',
				'tab' => 'Bottom Button',
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
        ?>

		<div class="met_pricing_table_2 <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
			<?php if( in_array( 'price_box', $elements ) ) : ?>
				<div class="price_box">
					<div class="prices">
						<?php if( $dslc_is_admin ): ?>
							<span class="dollars dslca-editable-content" data-id="price" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['price']); ?></span>
						<?php elseif( !empty($options['price'] ) && !$dslc_is_admin): ?>
							<span class="dollars"><?php echo stripslashes($options['price']); ?></span>
						<?php endif; ?>

						<?php if( in_array( 'price_decimals', $elements ) ) : ?>
							<?php if( $dslc_is_admin ): ?>
								<span class="cents dslca-editable-content" data-id="price_decimals" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['price_decimals']); ?></span>
							<?php elseif( !empty($options['price_decimals'] ) && !$dslc_is_admin): ?>
								<span class="cents"><?php echo stripslashes($options['price_decimals']); ?></span>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<?php if( in_array( 'package_title', $elements ) ) : ?>
						<?php if( $dslc_is_admin ): ?>
							<span class="package dslca-editable-content" data-id="package_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['package_title']); ?></span>
						<?php elseif( !empty($options['package_title'] ) && !$dslc_is_admin): ?>
							<span class="package"><?php echo stripslashes($options['package_title']); ?></span>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if( in_array( 'bottom_button', $elements ) ) : ?>
				<?php if( $dslc_is_admin ): ?>
					<a href="<?php echo $options['button_url'] ?>" class="details met_bgcolor dslca-editable-content" data-id="button_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['button_text']); ?></a>
				<?php elseif( !empty($options['button_text'] ) && !$dslc_is_admin): ?>
					<a href="<?php echo $options['button_url'] ?>" target="<?php echo $options['button_target'] ?>" class="details met_bgcolor"><?php echo stripslashes($options['button_text']); ?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>

        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}