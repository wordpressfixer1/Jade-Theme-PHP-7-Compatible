<?php

// Register Module
function register_simpletitle_module() {
    return dslc_register_module( "MET_SimpleTitle" );
}
add_action('dslc_hook_register_modules','register_simpletitle_module');

class MET_SimpleTitle extends DSLC_Module {

	var $module_id = 'MET_SimpleTitle';
	var $module_title = 'Advanced Title';
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
				'std' => 'CLICK TO EDIT. Im simple title, for separating page sections..',
				'type' => 'text',
				'visibility' => 'hidden'
			),
            array(
                'label' => __( 'Sub Title', 'dslc_string' ),
                'id' => 'sub_title',
                'std' => 'CLICK TO EDIT. Im simple title, for separating page sections..',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Third Title', 'dslc_string' ),
                'id' => 'third_title',
                'std' => 'Click to Edit Third Title',
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
                    array(
                        'label' => __( 'Third Title', 'dslc_string' ),
                        'value' => 'third_title'
                    ),
                    array(
                        'label' => __( 'Custom Border', 'dslc_string' ),
                        'value' => 'custom_border'
                    ),
                )
            ),

            /**
             * Custom Border
             */
            array(
                'label' => __( 'Words', 'dslc_string' ),
                'id' => 'rotate_words',
                'std' => '',
                'type' => 'text',
                'tab' => 'Rotate Words',
                'section' => 'styling',
                'help' => __( 'Words to be rotated in title. E.g. Your title is "I Love My Dog,Cat,Turtle". You have to write Dog,Cat,Turtle here to rotate these words.', 'dslc_string' )
            ),
            array(
                'label' => __( 'Speed', 'dslc_string' ),
                'id' => 'rotate_words_speed',
                'std' => '2000',
                'type' => 'text',
                'tab' => 'Rotate Words',
                'section' => 'styling',
                'help' => __( 'How many milliseconds until the next word show.', 'dslc_string' )
            ),
            array(
                'label' => __( 'Animation', 'dslc_string' ),
                'id' => 'rotate_words_animation',
                'std' => 'dissolve',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Dissolve', 'dslc_string' ),
                        'value' => 'dissolve'
                    ),
                    array(
                        'label' => __( 'fade', 'dslc_string' ),
                        'value' => 'fade'
                    ),
                    array(
                        'label' => __( 'Flip', 'dslc_string' ),
                        'value' => 'flip'
                    ),
                    array(
                        'label' => __( 'Flip Up', 'dslc_string' ),
                        'value' => 'flipUp'
                    ),
                    array(
                        'label' => __( 'Flip Cube', 'dslc_string' ),
                        'value' => 'flipCube'
                    ),
                    array(
                        'label' => __( 'Flip Cube Up', 'dslc_string' ),
                        'value' => 'flipCubeUp'
                    ),
                    array(
                        'label' => __( 'Spin', 'dslc_string' ),
                        'value' => 'spin'
                    ),
                ),
                'tab' => 'Rotate Words',
                'section' => 'styling',
            ),

            /**
             * Custom Border
             */
            array(
                'label' => __( 'Position Y', 'dslc_string' ),
                'id' => 'pos_y',
                'std' => 'stick_bottom',
                'type' => 'select',
                'tab' => 'Custom Border',
                'choices' => array(
                    array(
                        'label' => __( 'Top', 'dslc_string' ),
                        'value' => 'stick_top'
                    ),
                    array(
                        'label' => __( 'Bottom', 'dslc_string' ),
                        'value' => 'stick_bottom'
                    ),
                ),
                'section' => 'styling',
            ),
            array(
                'label' => __( 'Position X', 'dslc_string' ),
                'id' => 'pos_x',
                'std' => 'stick_center',
                'type' => 'select',
                'tab' => 'Custom Border',
                'choices' => array(
                    array(
                        'label' => __( 'Left', 'dslc_string' ),
                        'value' => 'stick_left'
                    ),
                    array(
                        'label' => __( 'Center', 'dslc_string' ),
                        'value' => 'stick_center'
                    ),
                    array(
                        'label' => __( 'Right', 'dslc_string' ),
                        'value' => 'stick_right'
                    ),
                ),
                'section' => 'styling',
            ),

		);

		$dslc_options = array_merge(
			$dslc_options,

            // Custom Border BG
            lc_general('.met_simple_title.custom_border:after', 'Custom Border', array('background-color' => '', 'width' => '20_%', 'height' => '3')),

			// Box
			lc_general('.met_simple_title', '', array('background-color' => ''), 'Box'),

            // Paddings
            lc_paddings('.met_simple_title', 'Paddings', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

            // Margins
            lc_margins('.met_simple_title', 'Margins', array('t' => '0', 'r' => '0', 'b' => '0', 'l' => '0')),

			// Box Borders
			lc_borders('.met_simple_title', 'Borders', array(
                't' => array('width' => '1', 'color' => '#F0F0F0', 'style' => 'solid'),
                'r' => array('width' => '', 'color' => '', 'style' => ''),
                'b' => array('width' => '1', 'color' => '#F0F0F0', 'style' => 'solid'),
                'l' => array('width' => '', 'color' => '', 'style' => ''),
            ) ),

			// Border Radius
			lc_borderRadius('.met_simple_title', 'Border Radius'),

			// Title
			lc_general('.met_simple_title h2', 'Title', array('color' => '','text-align' => '', 'font-size' => '22', 'line-height' => '24', 'font-weight' => '400')),

            // Sub Title
            lc_general('.met_simple_title h3', 'Sub Title', array('color' => '','text-align' => '', 'font-size' => '18', 'line-height' => '20', 'font-weight' => '400')),

            // Third Title
            lc_general('.met_simple_title .third_title', 'Third Title', array( 'text-align' => '')),

            // Third Title
            lc_general('.met_simple_title .third_title h4 span', 'Third Title', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400')),

            // Box
            lc_general('.met_simple_title .third_title h4:before,.met_simple_title .third_title h4:after', 'Third Title', array('background-color' => '#000000', 'width' => '40', 'height' => '2', 'top' => '49_%'), 'Border')
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
		
		$the_title = stripslashes($options['title']);
		$the_sub_title = stripslashes($options['sub_title']);
		$the_third_title = stripslashes($options['third_title']);

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
        
        $met_rotate_words_script = '';
        if ( !$dslc_is_admin && !empty($options['rotate_words']) ){
        	$rotationID = uniqid('met_word_rotate_');
        	if( !empty($the_title) ) { $the_title = str_replace($options['rotate_words'], '<span class="hidden '.$rotationID.'">'.$options['rotate_words'].'</span>', $the_title); }
        	if( !empty($the_sub_title) ) { $the_sub_title = str_replace($options['rotate_words'], '<span class="hidden '.$rotationID.'">'.$options['rotate_words'].'</span>', $the_sub_title); }
        	if( !empty($the_third_title) ) { $the_third_title = str_replace($options['rotate_words'], '<span class="hidden '.$rotationID.'">'.$options['rotate_words'].'</span>', $the_third_title); }
        	
        	if( is_numeric( strpos($the_title, 'met_word_rotate') ) ||  is_numeric( strpos($the_sub_title, 'met_word_rotate') ) ||  is_numeric( strpos($the_third_title, 'met_word_rotate') ) ){
	        	
	        	$rotate_words_animation = 'dissolve';
	        	$rotate_words_speed = '2000';
	        	
	        	if( !empty( $options['rotate_words_animation'] ) ) $rotate_words_animation = $options['rotate_words_animation'];
	        	if( !empty( $options['rotate_words_speed'] ) ) $rotate_words_speed = $options['rotate_words_speed'];
	        	
	        	$met_rotate_words_script = '<script>jQuery(document).ready(function(){jQuery(".'.$rotationID.'").textrotator({animation: "'.$rotate_words_animation.'",separator: ",",speed: '.$rotate_words_speed.'}).removeClass("hidden");});</script>';
	        	
	        	wp_enqueue_style('metcreative-textrotate');
				wp_enqueue_script('metcreative-textrotate');
        	}
        	
            
        }

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();
            
            

		?>

		<div class="met_simple_title <?php echo $options['pos_y'].' '.$options['pos_x']; echo in_array('custom_border', $elements) ? ' custom_border' : ''; ?> <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>

        <?php if(empty($elements) || in_array('title', $elements)){ ?>
            <?php if( $dslc_is_admin ): ?>
                <h2 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo $the_title; ?></h2>
            <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                <h2><?php echo $the_title; ?></h2>
            <?php endif; ?>
        <?php } ?>

        <?php if(empty($elements) || in_array('sub_title', $elements)){ ?>
            <?php if( $dslc_is_admin ): ?>
                <h3 class="dslca-editable-content" data-id="sub_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo $the_sub_title; ?></h3>
            <?php elseif( !empty($options['sub_title'] ) && !$dslc_is_admin): ?>
                <h3><?php echo $the_sub_title; ?></h3>
            <?php endif; ?>
        <?php } ?>

        <?php if(empty($elements) || in_array('third_title', $elements)){ ?>
            <?php if( $dslc_is_admin ): ?>
                <div class="third_title"><h4 style="padding-left: <?php echo $options['met_simple_title__third_title_h4_before_width'] ?>px; padding-right: <?php echo $options['met_simple_title__third_title_h4_before_width'] ?>px;"><span class="dslca-editable-content" data-id="third_title" data-type="simple" contenteditable><?php echo $the_third_title; ?></span></h4></div>
            <?php elseif( !empty($options['third_title'] ) && !$dslc_is_admin): ?>
                <div class="third_title"><h4 style="padding-left: <?php echo $options['met_simple_title__third_title_h4_before_width'] ?>px; padding-right: <?php echo $options['met_simple_title__third_title_h4_before_width'] ?>px;"><span><?php echo $the_third_title; ?></span></h4></div>
            <?php endif; ?>
        <?php } ?>

		</div>
        <?php echo $met_shared_options['script']; ?>
        <?php echo $met_rotate_words_script; ?>
		<?php

		/* Module output ends here */

		$this->module_end( $options );

	}

}