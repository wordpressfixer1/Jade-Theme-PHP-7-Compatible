<?php

// Register Module
function register_simpletitletwo_module() {
	return dslc_register_module( "MET_SimpleTitle2" );
}
add_action('dslc_hook_register_modules','register_simpletitletwo_module');

class MET_SimpleTitle2 extends DSLC_Module {

	var $module_id = 'MET_SimpleTitle2';
	var $module_title = 'Simple Title';
	var $module_icon = 'text-width';
	var $module_category = 'met - general';

	function options() {

		$dslc_options = array(

			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'Click to edit Title.',
				'type' => 'text',
				'visibility' => 'hidden'
			),
            array(
                'label' => __( 'Sub Title', 'dslc_string' ),
                'id' => 'sub_title',
                'std' => 'Click to edit Sub Title',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'title sub_title',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Sub Title', 'dslc_string' ),
                        'value' => 'sub_title'
                    ),
                )
            ),
		);

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('.met_simple_title_2', '', array('background-color' => '#FFFFFF', 'text-align' => 'center'), 'Box'),

			// Title
			lc_general('.met_simple_title_2_big', 'Title', array('font-family' => 'Sintony', 'color' => '#373B3D', 'font-size' => '30', 'line-height' => '40', 'font-weight' => '400')),

            // Sub Title
            lc_general('.met_simple_title_2_small', 'Sub Title', array('font-family' => 'Sintony', 'color' => '#373B3D', 'font-size' => '24', 'line-height' => '40', 'font-weight' => '400')),
            
			// Paddings
			lc_paddings('.met_simple_title_2', 'Paddings', array('t' => '14', 'r' => '0', 'b' => '14', 'l' => '0')),
			
			// Margins
			lc_margins('.met_simple_title_2', 'Margins', array('t' => '0', 'r' => '0', 'b' => '0', 'l' => '0'))
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
        <div class="met_simple_title_2 <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
        <?php if(empty($elements) || in_array('title', $elements)){ ?>
            <span class="dslca-editable-content met_simple_title_2_big" <?php if ( $dslc_is_admin ) echo 'contenteditable data-id="title" data-type="simple"'; ?>><?php echo stripslashes($options['title']); ?></span>
        <?php } ?>
        <?php if(empty($elements) || in_array('sub_title', $elements)){ ?>
            <span class="dslca-editable-content met_simple_title_2_small" <?php if ( $dslc_is_admin ) echo 'contenteditable data-id="sub_title" data-type="simple"'; ?>><?php echo stripslashes($options['sub_title']); ?></span>
        <?php } ?>
        </div>
        <?php echo $met_shared_options['script']; ?>
		<?php

		/* Module output ends here */

		$this->module_end( $options );

	}

}
