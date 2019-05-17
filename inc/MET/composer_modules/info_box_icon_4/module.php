<?php

// Register Module
function register_iboxiconfour_module() {
	return dslc_register_module( "MET_InfoBoxIcon4" );
}
add_action('dslc_hook_register_modules','register_iboxiconfour_module');

class MET_InfoBoxIcon4 extends DSLC_Module {

    var $module_id = 'MET_InfoBoxIcon4';
    var $module_title = 'Centered Icon';
    var $module_icon = 'info';
    var $module_category = 'met - info boxes';

    function options() {

		$dslc_options = array(

			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'CLICK TO EDIT TITLE',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Content', 'dslc_string' ),
				'id' => 'content',
				'std' => 'Vivamus id nulla in nunc euismod laoreet. Nunc volutpat augue id hendrerit adipiscing. Morbi in massa quam.',
				'type' => 'textarea',
				'visibility' => 'hidden'
			),

			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'icon title content',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Icon', 'dslc_string' ),
						'value' => 'icon'
					),
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Content', 'dslc_string' ),
						'value' => 'content'
					),
				)
			),

			/**
			 * General Options
			 */
			array(
				'label' => __( 'Icon', 'dslc_string' ),
				'id' => 'icon',
				'std' => 'cloud-download',
				'type' => 'icon',
			),

			array(
				'label' => __( 'Title Link URL', 'dslc_string' ),
				'id' => 'box_link_url',
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

			// Box
			lc_general('.met_info_box_icon_4', '', array('background-color' => '', 'text-align' => 'center')),

            // Box Margins
			lc_margins('.met_info_box_icon_4', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

            // Box Paddings
            lc_paddings('.met_info_box_icon_4', '', array('t' => '50', 'r' => '30', 'b' => '50', 'l' => '30')),

            // Box Borders
            lc_borders('.met_info_box_icon_4', '', array(), array(), '0', '', 'solid' ),

            // Box Border Radius
            lc_borderRadius('.met_info_box_icon_4', '', array('tl' => '0', 'tr' => '0', 'br' => '0', 'bl' => '0')),

			// Icon
			lc_general('.met_info_box_icon_4 > i', 'Icon', array('color' => '#373B3D', 'font-size' => '34', 'line-height' => '30')),

			// Title
			lc_general('.met_info_box_icon_4 > span', 'Title', array('color' => '#373B3D', 'font-size' => '36', 'line-height' => '40')),

			// Content
			lc_general('.met_p', 'Content', array('color' => '','font-size' => '14', 'line-height' => '20'))
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

		//print_r(met_lc_extras(array(), array('animation','parallax'), 'shared_options'));

        /* Animation */
        

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

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

		//print_r($met_shared_options);

        $boxTagOpen = '<div class="met_info_box_icon_4 clearfix '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].'>';
        $boxTagClose = '</div>';

        if( !empty($options['box_link_url']) && $options['box_link_url'] != '#' ){
            $boxTagOpen = '<a href="'.$options['box_link_url'].'" class="met_info_box_icon_4 clearfix '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].' target="'.$options['button_target'].'">';
            $boxTagClose = '</a>';
        }
        ?>

		<?php echo $boxTagOpen; ?>
			<?php if( in_array( 'icon', $elements ) ) : ?>
                <i class="dslc-icon dslc-icon-<?php echo $options['icon'] ?>"></i>
			<?php endif; ?>
            <?php if( in_array( 'title', $elements ) ) : ?>
                <span<?php if ( $dslc_is_admin ) echo ' contenteditable class="dslca-editable-content" data-id="title" data-type="simple"'; ?>><?php echo stripslashes($options['title']); ?></span>
            <?php endif; ?>
            <?php if( in_array( 'content', $elements ) ) : ?>
                <div class="met_p">

                    <?php if ( $dslc_active ): ?> <div class="dslca-editable-content" data-id="content"> <?php endif; ?>

                        <?php
                        $output_content = stripslashes( $options['content'] );
                        $output_content = do_shortcode( $output_content );
                        echo $output_content;
                        ?>

                        <?php if ( $dslc_active ) : ?></div> <div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e('Edit Content','dslc_string') ?></span></div> <?php endif; ?>

                </div>
            <?php endif; ?>
        <?php echo $boxTagClose; ?>
        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}