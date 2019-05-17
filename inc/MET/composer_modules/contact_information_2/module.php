<?php

// Register Module
function register_contactinfotwo_module() {
    return dslc_register_module( "MET_ContactInformation2" );
}
add_action('dslc_hook_register_modules','register_contactinfotwo_module');

class MET_ContactInformation2 extends DSLC_Module {

    var $module_id = 'MET_ContactInformation2';
    var $module_title = 'Contact Info Boxed';
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
				'std' => 'head head_title view_all icon sub_title sub_text line_icon',
				'type' => 'checkbox',
				'choices' => array(
                    array(
                        'label' => __( 'Head', 'dslc_string' ),
                        'value' => 'head'
                    ),
                    array(
                        'label' => __( 'Head Title', 'dslc_string' ),
                        'value' => 'head_title'
                    ),
                    array(
                        'label' => __( 'View All', 'dslc_string' ),
                        'value' => 'view_all'
                    ),
                    array(
                        'label' => __( 'Icon', 'dslc_string' ),
                        'value' => 'icon'
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
                'label' => __( 'Head Title', 'dslc_string' ),
                'id' => 'head_title',
                'std' => 'EDIT TITLE',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'View All', 'dslc_string' ),
                'id' => 'view_all',
                'std' => 'View All',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
			array(
				'label' => 'sub title',
				'id' => 'sub_title',
				'std' => 'We Are Open',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => 'sub text',
				'id' => 'sub_text',
				'std' => 'Monday: 11 AM – 20 PM<br>Sunday: 12 AM – 19 PM',
				'type' => 'text',
				'visibility' => 'hidden'
			),
            array(
                'label' => __( 'View All Link', 'dslc_string' ),
                'id' => 'view_all_link',
                'std' => '#',
                'type' => 'text'
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

        $dslc_options = array_merge(
            $dslc_options,

            // Head Background Color
            lc_general('.met_content_box header', 'Head', array('background-color' => '')),

            // Head Fonts
            lc_general('.met_content_box header span', 'Head', array('color' => '','font-size' => '19','line-height' => '25'), 'Title'),

            // Head View All Fonts
            lc_general('.met_content_box header a', 'Head', array('color' => '', 'color:hover' => '','font-size' => '12','line-height' => '25'), 'View All'),

            // Head Paddings
            lc_paddings('.met_content_box header', 'Head', array('t' => '15', 'r' => '30', 'b' => '15', 'l' => '30')),

            // Icon
            lc_general('.met_content_box header i', 'Icon', array('icon' => 'html5', 'color' => '','font-size' => '25', 'line-height' => '25')),


			// Box
			lc_paddings('.met_content_box_contents', '', '25'),

            lc_general('.met_content_box_contents', '', array('background-color' => '#EEEDE8')),


			// Line Icon
			lc_general('.met_icon_text_icon_box', 'Line Icon', array('color' => '', 'font-size' => '18')),

            // Line Text
            lc_general('.met_icon_text span,.met_icon_text a', 'Line Text', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400')),

			// Sub Title
			lc_general('section .h4', 'Sub Title', array('color' => '', 'font-size' => '18', 'line-height' => '20', 'font-weight' => '400')),

			// Sub Text
			lc_general('.met_icon_text_descr', 'Sub Text', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400'))
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
        /* Module output starts here */

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('contact_information_2_');

        ?>

        <div class="met_content_box">
            <?php if( in_array( 'head', $elements ) ) : ?>
                <header>
                    <?php if( in_array( 'head_title', $elements ) ) : ?>
                        <?php if( $dslc_is_admin ): ?>
                            <span class="dslca-editable-content" data-id="head_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['head_title']); ?></span>
                        <?php elseif( !empty($options['head_title'] ) && !$dslc_is_admin): ?>
                            <span><?php echo stripslashes($options['head_title']); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if( in_array( 'view_all', $elements ) ) : ?>
                        <?php if( $dslc_is_admin ): ?>
                            <a href="<?php echo $options['view_all_link']; ?>" class="met_color2 dslca-editable-content" data-id="view_all" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['view_all']); ?></a>
                        <?php elseif( !empty($options['view_all'] ) && !$dslc_is_admin): ?>
                            <a href="<?php echo $options['view_all_link']; ?>" class="met_color2"><?php echo stripslashes($options['view_all']); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if( in_array( 'icon', $elements ) ) : ?>
                        <i class="dslc-icon dslc-icon-<?php echo $options['met_content_box_header_i_icon']; ?>"></i>
                    <?php endif; ?>
                </header>
            <?php endif; ?>
            <section>
                <div class="met_content_box_contents">
                    <?php for($i=1; $i <= $options['line_count']; $i++): ?>
                        <?php
                        $icon_id = 'line_icon_'.$i;
                        $text_id = 'line_text_'.$i;
                        $link_url_id = 'line_link_url_'.$i;
                        $link_target_id = 'line_link_target_'.$i;
                        ?>
                        <div class="met_icon_text clearfix">
                            <?php if( in_array( 'line_icon', $elements ) ) : ?>
                                <div class="met_icon_text_icon_box"><i class="dslc-icon dslc-icon-<?php echo $options[$icon_id]; ?>"></i></div>
                            <?php endif; ?>
                            <?php if( $dslc_is_admin ): ?>
                                <a class="dslca-editable-content" data-id="<?php echo $text_id ?>" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options[$text_id]); ?></a>
                            <?php elseif( !empty($options[$text_id] ) && !$dslc_is_admin): ?>
                                <<?php if(!empty($options[$link_url_id])): echo 'a' ?> href="<?php echo $options[$link_url_id]; ?>" target="<?php echo $options[$link_target_id]; ?>" <?php else: echo 'span'; endif; ?>><?php echo stripslashes($options[$text_id]); ?></<?php if(!empty($options[$link_url_id])): echo 'a'; else: echo 'span'; endif; ?>>
                            <?php endif; ?>
                        </div>
                        <div class="met_thin_line_split"></div>
                    <?php endfor; ?>
                    <?php if( in_array( 'sub_title', $elements ) ) : ?>
                        <?php if( $dslc_is_admin ): ?>
                            <span class="dslca-editable-content h4 met_color2" data-id="sub_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['sub_title']); ?></span>
                        <?php elseif( !empty($options['sub_title'] ) && !$dslc_is_admin): ?>
                            <span class="h4 met_color2"><?php echo stripslashes($options['sub_title']); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if( in_array( 'sub_text', $elements ) ) : ?>
                        <?php if( $dslc_is_admin ): ?>
                            <div class="met_icon_text_descr dslca-editable-content" data-id="sub_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['sub_text']); ?></div>
                        <?php elseif( !empty($options['sub_text'] ) && !$dslc_is_admin): ?>
                            <div class="met_icon_text_descr"><?php echo stripslashes($options['sub_text']); ?></div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}