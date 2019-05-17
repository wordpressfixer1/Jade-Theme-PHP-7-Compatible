<?php

// Register Module
function register_pricingtableone_module() {
	return dslc_register_module( "MET_PricingTable1" );
}
add_action('dslc_hook_register_modules','register_pricingtableone_module');

class MET_PricingTable1 extends DSLC_Module {

    var $module_id = 'MET_PricingTable1';
    var $module_title = 'Detailed';
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
				'std' => 'head price_box price_decimals price_period feature_list bottom_button',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Head Title', 'dslc_string' ),
						'value' => 'head'
					),
					array(
						'label' => __( 'Price Box', 'dslc_string' ),
						'value' => 'price_box'
					),
					array(
						'label' => __( 'Price Decimals', 'dslc_string' ),
						'value' => 'price_decimals'
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
					array(
						'label' => __( 'Make Featured', 'dslc_string' ),
						'value' => 'chosen'
					),
				)
			),

			array(
				'label' => __( 'Head Title', 'dslc_string' ),
				'id' => 'head_title',
				'std' => 'CLICK TO EDIT',
				'type' => 'text',
				'visibility' => 'hidden'
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
				'label' => __( 'Price Period', 'dslc_string' ),
				'id' => 'price_period',
				'std' => '/ per month',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Feature List', 'dslc_string' ),
				'id' => 'feature_list',
				'std' => '[met_pt_list][met_pt_li title="User Account" value="5 Account"][met_pt_li title="Disk Space" value="50GB"][met_pt_li title="Email Account" value="10 Email"][met_pt_li title="Bandwith" value="Unlimited"][met_pt_li title="Antivirus" value="Free"][/met_pt_list]',
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
			lc_general('.met_pricing_table_1', '', array('background-color' => 'transparent'), 'Box'),

			// Content Box Borders
			lc_borders('.met_pricing_table_1', 'Borders', array(
				't' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'r' => array('width' => '1', 'color' => '#EFEEE9', 'style' => 'solid'),
				'b' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'l' => array('width' => '1', 'color' => '#EFEEE9', 'style' => 'solid'),
			), array(), '', '', '' ),

			// Title
			lc_general('.met_pricing_table_1 header', 'Title', array('color' => '#373b3e','color:hover' => '','background-color' => '#f1f0eb','font-size' => '19','line-height' => '20', 'text-align' => 'center', 'font-weight' => '600')),

			// Title Paddings
			lc_paddings('.met_pricing_table_1 header', 'Title', array('t' => '10', 'r' => '0', 'b' => '10', 'l' => '0')),

			// Featured Title
			lc_general('.met_pricing_table_1.chosen header', 'Featured Title', array('color' => '#ffffff','color:hover' => '','background-color' => get_met_option('met_color'),'font-size' => '19','line-height' => '20', 'text-align' => 'center', 'font-weight' => '600')),

			// Featured Title Paddings
			lc_paddings('.met_pricing_table_1.chosen header', 'Featured Title', array('t' => '20', 'r' => '0', 'b' => '20', 'l' => '0')),

			// Price Box
			lc_general('.met_pricing_table_1 .price_box', 'Price Box', array('color' => '#373B3D','background-color' => '#fafaf8','line-height' => '20', 'text-align' => 'center')),

			// Price Box Paddings
			lc_paddings('.met_pricing_table_1 .price_box', 'Title', array('t' => '28', 'r' => '0', 'b' => '28', 'l' => '0')),

			// Price
			lc_general('.met_pricing_table_1 .price_box .dollars', 'Price', array('color' => '','font-size' => '48','line-height' => '37','font-weight' => '600')),

			// Decimals
			lc_general('.met_pricing_table_1 .price_box .cents', 'Decimals', array('color' => '','font-size' => '14','line-height' => '20','font-weight' => '600')),

			// Period
			lc_general('.met_pricing_table_1 .price_box .cents', 'Decimals', array('color' => '','font-size' => '14','line-height' => '25','font-weight' => '400')),

			// Features List
			lc_paddings('.met_pricing_table_1 .pricing_properties ul', 'Features List', array('t' => '10', 'r' => '30', 'b' => '10', 'l' => '30')),

			// Feature List Item
			lc_general('.met_pricing_table_1 .pricing_properties ul li', 'Features List Item', array('line-height' => '49')),

			// Feature List Item
			lc_borders('.met_pricing_table_1 .pricing_properties ul li', 'Borders', array(
				't' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'r' => array('width' => '0', 'color' => '', 'style' => 'none'),
				'b' => array('width' => '1', 'color' => '#EFEEE9', 'style' => 'solid'),
				'l' => array('width' => '0', 'color' => '', 'style' => 'none'),
			), array(), '', '', '' ),

			// Feature List Item Title
			lc_general('.met_pricing_table_1 .pricing_properties ul li span', 'Features LI Title', array('color' => '#888685','font-size' => '13','font-weight' => '600')),

			// Feature List Item Value
			lc_general('.met_pricing_table_1 .pricing_properties ul li strong', 'Features LI Value', array('color' => '#373B3D','font-size' => '13','font-weight' => '600')),

			// Button
			lc_general('.met_pricing_table_1 .details', 'Bottom Button', array('color' => '#373B3E','background-color' => '#F2F1ED','font-size' => '19','line-height' => '20','font-weight' => '600','text-align' => 'center')),

			// Button Paddings
			lc_paddings('.met_pricing_table_1 .details', 'Bottom Button', array('t' => '15', 'r' => '0', 'b' => '15', 'l' => '0')),

			// Button Featured
			lc_general('.met_pricing_table_1.chosen .details', 'Featured Button', array('color' => '#FFFFFF','background-color' => '#FFCA07','font-size' => '19','line-height' => '20','font-weight' => '600','text-align' => 'center')),

			// Button Featured Paddings
			lc_paddings('.met_pricing_table_1.chosen .details', 'Featured Button', array('t' => '20', 'r' => '0', 'b' => '20', 'l' => '0'))

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

		<div class="met_pricing_table_1 <?php if( in_array( 'chosen', $elements ) ) echo 'chosen' ?> <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>

			<?php if( in_array( 'head', $elements ) ) : ?>
				<?php if( $dslc_is_admin ): ?>
					<header class="dslca-editable-content" data-id="head_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['head_title']); ?></header>
				<?php elseif( !empty($options['head_title'] ) && !$dslc_is_admin): ?>
					<header><?php echo stripslashes($options['head_title']); ?></header>
				<?php endif; ?>
			<?php endif; ?>


			<section>
				<?php if( in_array( 'price_box', $elements ) ) : ?>
					<div class="price_box">
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

						<?php if( in_array( 'price_period', $elements ) ) : ?>
							<?php if( $dslc_is_admin ): ?>
								<span class="period met_color2 dslca-editable-content" data-id="price_period" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['price_period']); ?></span>
							<?php elseif( !empty($options['price_period'] ) && !$dslc_is_admin): ?>
								<span class="period met_color2"><?php echo stripslashes($options['price_period']); ?></span>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if( in_array( 'feature_list', $elements ) ) : ?>
				<div class="pricing_properties clearfix">
					<?php if ( $dslc_active ): ?> <div class="dslca-editable-content" data-id="feature_list"> <?php endif; ?>

					<?php
						$output_content = stripslashes( $options['feature_list'] );
						$output_content = do_shortcode( shortcode_fix($output_content) );
						echo $output_content;
					?>

					<?php if ( $dslc_active ) : ?></div> <div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e('Edit Features','dslc_string') ?></span></div> <?php endif; ?>
				</div>
				<?php endif; ?>
			</section>
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