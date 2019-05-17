<?php

// Register Module
function register_textblock_module() {
    return dslc_register_module( "MET_TextBlock" );
}
add_action('dslc_hook_register_modules','register_textblock_module');

class MET_TextBlock extends DSLC_Module {

    var $module_id = 'MET_TextBlock';
    var $module_title = 'Text Block';
    var $module_icon = 'info';
    var $module_category = 'met - general';

    function options() {

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'Title', 'dslc_string' ),
                'id' => 'title',
                'std' => 'Edit Title /',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Sub Title', 'dslc_string' ),
                'id' => 'sub_title',
                'std' => 'Sub Title',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Content', 'dslc_string' ),
                'id' => 'content',
                'std' => 'Edit Content Text',
                'type' => 'textarea',
                'visibility' => 'hidden'
            ),

            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'title sub_title content',
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
                        'label' => __( 'Content', 'dslc_string' ),
                        'value' => 'content'
                    ),
                )
            ),
        );


        $dslc_options = array_merge(
            $dslc_options,

            // Box Background Color
            lc_general('.met_text_block', '', array('background-color' => ''), 'Box'),

            // Box Paddings
            lc_paddings('.met_text_block', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

            // Box Borders
            lc_borders('.met_text_block', '', array(), array(), '0', '', 'solid' ),

            // Box Border Radius
            lc_borderRadius('.met_text_block'),

            //Header
            lc_general('.met_title_with_subtitle', 'Header', array('background-color' => 'rgba(0,0,0,0.03)')),

			//Header
			lc_paddings('.met_title_with_subtitle', 'Header', array('t' => '0', 'r' => '30', 'b' => '0', 'l' => '30')),

            // Title
            lc_general('.met_title_with_subtitle h3', 'Title', array('color' => '','font-size' => '19','line-height' => '55')),

            // Sub Title
            lc_general('.met_title_with_subtitle h4', 'Sub Title', array('color' => '','font-size' => '12','line-height' => '55')),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '#FFFFFF')),
			lc_paddings('.met_p', 'Content', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30'))
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
        <div class="met_text_block <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
        <?php if( in_array( 'title', $elements ) || in_array( 'sub_title', $elements ) ) : ?>
            <header class="met_title_with_subtitle">
                <?php if( in_array( 'title', $elements ) ) : ?>
                    <?php if( $dslc_is_admin ): ?>
                        <h3 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></h3>
                    <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                        <h3><?php echo stripslashes($options['title']); ?></h3>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if( in_array( 'sub_title', $elements ) ) : ?>
                    <?php if( $dslc_is_admin ): ?>
                        <h4 class="met_color2 dslca-editable-content" data-id="sub_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['sub_title']); ?></h4>
                    <?php elseif( !empty($options['sub_title'] ) && !$dslc_is_admin): ?>
                        <h4 class="met_color2"><?php echo stripslashes($options['sub_title']); ?></h4>
                    <?php endif; ?>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <?php if( in_array( 'content', $elements ) ) : ?>
            <div style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>" class="met_p">
                <?php
                if ( $dslc_active ) {
                ?><div class="dslca-editable-content" data-id="content"><?php
                    }

                    $output_content = stripslashes( $options['content'] );
                    $output_content = do_shortcode( $output_content );
                    echo $output_content;

                    if ( $dslc_active ) {
                    ?></div><!-- .dslca-editable-content --><?php
            ?><div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook">Edit Content</span></div><?php
            }
            ?>
            </div>
        <?php endif; ?>
        </div>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */

        $this->module_end( $options );

    }

}