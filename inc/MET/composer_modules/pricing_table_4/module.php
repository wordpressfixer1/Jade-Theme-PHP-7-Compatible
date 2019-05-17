<?php

// Register Module
function register_pricetablefour_module() {
	return dslc_register_module( "MET_PricingTable4" );
}
add_action('dslc_hook_register_modules','register_pricetablefour_module');

class MET_PricingTable4 extends DSLC_Module {

    var $module_id = 'MET_PricingTable4';
    var $module_title = 'Boxed';
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
				'std' => 'price_box price_decimals price_period package_title feature_list bottom_button',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Package Title', 'dslc_string' ),
						'value' => 'package_title'
					),
					array(
						'label' => __( 'Price Box', 'dslc_string' ),
						'value' => 'price_box'
					),
					array(
						'label' => __( 'Price Period', 'dslc_string' ),
						'value' => 'price_period'
					),
					array(
						'label' => __( 'Feature List', 'dslc_string' ),
						'value' => 'feature_list'
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
				'label' => __( 'Price Period', 'dslc_string' ),
				'id' => 'price_period',
				'std' => '/ per month',
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
				'label' => __( 'Feature List', 'dslc_string' ),
				'id' => 'feature_list',
				'std' => '[met_pt_list][met_pt_li title="10 User Account"][met_pt_li title="10GB Disk Space"][met_pt_li title="10 Email Account"][met_pt_li title="Unlimited Bandwith"][met_pt_li title="Free Antivirus"][/met_pt_list]',
				'type' => 'textarea',
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

			// Content Box Background Color
			lc_general('.met_pricing_table_4', '', array('background-color' => '#EEEDE8'), 'Box'),

			// Content Box Borders
			lc_borders('.met_pricing_table_4', 'Borders', array(), array(), '', '', 'none' ),

			// Price Box
			lc_general('.met_pricing_table_4 .price_box', 'Price Box', array('color' => get_met_option('met_color2'),'background-color' => '','line-height' => '20', 'text-align' => 'center')),

			// Title
			lc_general('.met_pricing_table_4 .package', 'Title', array('background-color' => '', 'color' => '#35393D','font-size' => '24','line-height' => '22', 'text-align' => 'center', 'font-weight' => '400')),

			// Title Paddings
			lc_paddings('.met_pricing_table_4 .package', 'Title', array('t' => '16', 'r' => '0', 'b' => '16', 'l' => '0')),

			// Price
			lc_general('.met_pricing_table_4 .price_box .dollars', 'Price', array('color' => '','font-size' => '60','line-height' => '50','font-weight' => '400')),

			// Period
			lc_general('.met_pricing_table_4 .price_box .period', 'Period', array('color' => '','font-size' => '14','line-height' => '20','font-weight' => '400')),

			// Features List Margins
			lc_margins('.met_pricing_table_4 .pricing_properties ul', 'Features List', array('t' => '0', 'r' => '30', 'b' => '0', 'l' => '0')),

			// Features List Paddings
			lc_paddings('.met_pricing_table_4 .pricing_properties ul', 'Features List', array('t' => '15', 'r' => '0', 'b' => '40', 'l' => '')),

			// Feature List Item
			lc_general('.met_pricing_table_4 .pricing_properties ul li span', 'Features List Item', array('color' => '#616161','font-size' => '14','line-height' => '29','font-weight' => '400')),

			// Features List Item Paddings
			lc_paddings('.met_pricing_table_4 .pricing_properties ul li span', 'Features List', array('t' => '15', 'r' => '0', 'b' => '15', 'l' => '35')),

			// Feature List Item Check
			lc_general('.met_pricing_table_4 .pricing_properties ul li span:before', 'Features List Item', array('font-size' => '20','color' => '#35393D'),'Check'),


			// Button
			lc_general('.met_pricing_table_4 .details', 'Bottom Button', array('background-color' => '', 'color' => '#35393D','font-size' => '24','line-height' => '22','font-weight' => '400','text-align' => 'center')),

			// Button Paddings
			lc_paddings('.met_pricing_table_4 .details', 'Bottom Button', array('t' => '13', 'r' => '43', 'b' => '13', 'l' => '43'))

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
        ?>

		<div class="met_pricing_table_4 <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
			<?php if( in_array( 'package_title', $elements ) ) : ?>
				<?php if( $dslc_is_admin ): ?>
					<span class="package dslca-editable-content" data-id="package_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['package_title']); ?></span>
				<?php elseif( !empty($options['package_title'] ) && !$dslc_is_admin): ?>
					<span class="package"><?php echo stripslashes($options['package_title']); ?></span>
				<?php endif; ?>
			<?php endif; ?>

			<?php if( in_array( 'feature_list', $elements ) ) : ?>
				<div class="pricing_properties">
					<?php if ( $dslc_active ): ?> <div class="dslca-editable-content" data-id="feature_list"> <?php endif; ?>

						<?php
						$output_content = stripslashes( $options['feature_list'] );
						$output_content = do_shortcode( shortcode_fix($output_content) );
						echo $output_content;
						?>

						<?php if ( $dslc_active ) : ?></div> <div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e('Edit Features','dslc_string') ?></span></div> <?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if( in_array( 'price_box', $elements ) ) : ?>
				<div class="price_box">
					<?php if( $dslc_is_admin ): ?>
						<span class="dollars dslca-editable-content" data-id="price" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['price']); ?></span>
					<?php elseif( !empty($options['price'] ) && !$dslc_is_admin): ?>
						<span class="dollars"><?php echo stripslashes($options['price']); ?></span>
					<?php endif; ?>
					<?php if( in_array( 'price_period', $elements ) ) : ?>
						<?php if( $dslc_is_admin ): ?>
							<span class="period dslca-editable-content" data-id="price_period" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['price_period']); ?></span>
						<?php elseif( !empty($options['price_period'] ) && !$dslc_is_admin): ?>
							<span class="period"><?php echo stripslashes($options['price_period']); ?></span>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if( in_array( 'bottom_button', $elements ) ) : ?>
				<?php if( $dslc_is_admin ): ?>
					<a href="<?php echo $options['button_url'] ?>" class="details dslca-editable-content" data-id="button_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['button_text']); ?></a>
				<?php elseif( !empty($options['button_text'] ) && !$dslc_is_admin): ?>
					<a href="<?php echo $options['button_url'] ?>" target="<?php echo $options['button_target'] ?>" class="details"><?php echo stripslashes($options['button_text']); ?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>

        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}