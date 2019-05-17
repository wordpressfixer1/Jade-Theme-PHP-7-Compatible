<?php

// Register Module
function register_contactinfo_module() {
	return dslc_register_module( "MET_ContactInformation" );
}
add_action('dslc_hook_register_modules','register_contactinfo_module');

class MET_ContactInformation extends DSLC_Module {

    var $module_id = 'MET_ContactInformation';
    var $module_title = 'Contact Info Transparent';
    var $module_icon = 'info';
    var $module_category = 'met - socials & contact';

    function options() {

        $dslc_options = array(
			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'title sub_title sub_text line_icon',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Line Icons', 'dslc_string' ),
						'value' => 'line_icon'
					),
					array(
						'label' => __( 'Sub Title', 'dslc_string' ),
						'value' => 'sub_title'
					),
					array(
						'label' => __( 'Sub Text', 'dslc_string' ),
						'value' => 'sub_text'
					),
				)
			),

			array(
				'label' => 'title',
                'id' => 'title',
                'std' => 'CONTACT INFORMATION',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
			array(
				'label' => 'sub title',
				'id' => 'sub_title',
				'std' => 'WE ARE OPEN',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => 'sub text',
				'id' => 'sub_text',
				'std' => 'Monday: 11 AM – 20 PM / Sunday: 12 AM – 19 PM / Friday: 11 AM – 18 PM',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Line Count', 'dslc_string' ),
				'id' => 'line_count',
				'std' => 3,
				'min' => 1,
				'max' => 10,
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
        );

		for($i=1; $i <= 10; $i++){
			$line_options = array(
				array(
					'label' => sprintf( __('Line Icon (%1$s)', 'dslc_string'), $i ),
					'id' => 'line_icon_'.$i,
					'std' => 'map-marker',
					'type' => 'icon',
					'tab' => 'Line '.$i
				),
				array(
					'label' => sprintf( __('Line Link URL (%1$s)', 'dslc_string'), $i ),
					'id' => 'line_link_url_'.$i,
					'std' => '',
					'type' => 'text',
					'tab' => 'Line '.$i
				),
				array(
					'label' => sprintf( __('Open in (%1$s)', 'dslc_string'), $i ),
					'id' => 'line_link_target_'.$i,
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
					'tab' => 'Line '.$i
				),

				/* Click to edit contents */
				array(
					'label' => 'Line Text',
					'id' => 'line_text_'.$i,
					'std' => 'CLICK TO EDIT LINE TEXT',
					'type' => 'text',
					'visibility' => 'hidden'
				)
			);

			$dslc_options = array_merge($dslc_options,$line_options);
		}

		$bg_options = array(
			array(
				'label' => __( 'Background Color', 'dslc_string' ),
				'id' => 'box_background_color',
				'std' => 'rgba(53, 57, 61, 0.55)',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_contact_information',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			)
		);

		$dslc_options = array_merge($dslc_options,$bg_options);

        $dslc_options = array_merge(
            $dslc_options,

			// Box
			lc_paddings('.met_contact_information', '', array('t' => '40', 'r' => '30', 'b' => '40', 'l' => '30')),

            // Title
            lc_general('.met_contact_information_title', 'Title', array('color' => '', 'font-size' => '18', 'line-height' => '20', 'font-weight' => '400','text-align' => '')),

			// Line Icon
			lc_general('.met_icon_text_icon_box', 'Line Icon', array('color' => '', 'font-size' => '18', 'font-weight' => '400','text-align' => 'center')),

            // Line Text
            lc_general('.met_icon_text a', 'Line Text', array('color' => '#ffffff','color:hover' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400','text-align' => '')),

			// Sub Title
			lc_general('.met_contact_information_sub_title', 'Sub Title', array('color' => '', 'font-size' => '18', 'line-height' => '20', 'font-weight' => '400','text-align' => '')),

			// Sub Text
			lc_general('.met_contact_information_sub_text', 'Sub Text', array('color' => '#ffffff', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400','text-align' => ''))
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

        $elementID = uniqid('contact_information_');
        ?>

        <div class="met_contact_information <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <div class="met_content_box_contents">
				<?php if( in_array( 'title', $elements ) ) : ?>
					<?php if( $dslc_is_admin ): ?>
						<h4 class="met_contact_information_title dslca-editable-content met_color" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></h4>
					<?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
						<h4 class="met_contact_information_title met_color"><?php echo stripslashes($options['title']); ?></h4>
					<?php endif; ?>
				<?php endif; ?>
				<?php for($i=1; $i <= $options['line_count']; $i++): ?>
					<?php
					$icon_id = 'line_icon_'.$i;
					$text_id = 'line_text_'.$i;
					$link_url_id = 'line_link_url_'.$i;
					$link_target_id = 'line_link_target_'.$i;
					?>
					<div class="met_icon_text clearfix">
						<?php if( in_array( 'line_icon', $elements ) ) : ?>
							<div class="met_icon_text_icon_box met_color"><i class="dslc-icon dslc-icon-<?php echo $options[$icon_id]; ?>"></i></div>
						<?php endif; ?>
						<?php if( $dslc_is_admin ): ?>
							<a class="dslca-editable-content" data-id="<?php echo $text_id ?>" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options[$text_id]); ?></a>
						<?php elseif( !empty($options[$text_id] ) && !$dslc_is_admin): ?>
							<a href="<?php echo $options[$link_url_id]; ?>" target="<?php echo $options[$link_target_id]; ?>"><?php echo stripslashes($options[$text_id]); ?></a>
						<?php endif; ?>
					</div>
					<div class="met_thin_line_split"></div>
				<?php endfor; ?>
				<?php if( in_array( 'sub_title', $elements ) ) : ?>
					<?php if( $dslc_is_admin ): ?>
						<h4 class="dslca-editable-content met_color met_contact_information_sub_title" data-id="sub_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['sub_title']); ?></h4>
					<?php elseif( !empty($options['sub_title'] ) && !$dslc_is_admin): ?>
						<h4 class="met_color met_contact_information_sub_title"><?php echo stripslashes($options['sub_title']); ?></h4>
					<?php endif; ?>
				<?php endif; ?>
				<?php if( in_array( 'sub_text', $elements ) ) : ?>
					<?php if( $dslc_is_admin ): ?>
						<div class="dslca-editable-content met_contact_information_sub_text" data-id="sub_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['sub_text']); ?></div>
					<?php elseif( !empty($options['sub_text'] ) && !$dslc_is_admin): ?>
						<div class="met_contact_information_sub_text"><?php echo stripslashes($options['sub_text']); ?></div>
					<?php endif; ?>
				<?php endif; ?>
            </div>
        </div>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}