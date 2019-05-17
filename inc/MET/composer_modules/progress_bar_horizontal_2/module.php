<?php

// Register Module
function register_pbarhorizontwo_module() {
	return dslc_register_module( "MET_ProgressBarHorizontal2" );
}
add_action('dslc_hook_register_modules','register_pbarhorizontwo_module');

class MET_ProgressBarHorizontal2 extends DSLC_Module {

    var $module_id = 'MET_ProgressBarHorizontal2';
    var $module_title = 'Progress Bar Horizontal 2';
    var $module_icon = 'info';
    var $module_category = 'met - general';

    function options() {

		$dslc_options = array(
			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'title',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
				)
			),

			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'CLICK TO EDIT',
				'type' => 'text',
				'visibility' => 'hidden'
			),

			array(
				'label' => __( 'Progress Percent', 'dslc_string' ),
				'id' => 'percent',
				'std' => '75',
				'type' => 'text',
			),

		);

		$dslc_options = array_merge(
			$dslc_options,

			// Line Background Color
			lc_general('.met_progress_bar_2_wrap', '', array('background-color' => '#F4F5F5'), 'Line'),

			// Line Background Color
			lc_general('.met_progress_bar_2_progress', '', array('background-color' => ''), 'Line Fill'),

			// Title
			lc_general('.met_progress_bar_2_wrap span', 'Title', array('color' =>'#ffffff','font-size' => '14','line-height' => '40','font-weight' => '400')),

			// Paddings
			lc_paddings('.met_progress_bar_2_wrap span', 'Title', array('t' => '0', 'r' => '10', 'b' => '0', 'l' => '10'))
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

        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
        	$asyncScripts = '["'.get_template_directory_uri().'/js/jquery.appear.js"]';
        }else{
            wp_enqueue_script('metcreative-appear');
        }

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        $elementID = uniqid('progressbar2_');
        ?>

        <div id="<?php echo $elementID ?>" class="met_progress_bar_2_wrap <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
			<?php if( in_array( 'title', $elements ) ) : ?>
				<?php if( $dslc_is_admin ): ?>
					<span class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></span>
				<?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
					<span><?php echo stripslashes($options['title']); ?></span>
				<?php endif; ?>
			<?php endif; ?>

            <div class="met_progress_bar_2_progress met_bgcolor" style="width:<?php echo $options['percent'] ?>%"></div>
        </div>

        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["appearThis|<?php echo $elementID ?>"]);});</script>
        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}