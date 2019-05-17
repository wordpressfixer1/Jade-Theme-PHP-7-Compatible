<?php

// Register Module
function register_calltoaction_module() {
    return dslc_register_module( "MET_CallToAction" );
}
add_action('dslc_hook_register_modules','register_calltoaction_module');

class MET_CallToAction extends DSLC_Module {

    var $module_id = 'MET_CallToAction';
    var $module_title = 'Call to Action';
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
                'std' => 'CLICK TO EDIT. Jade Business, Clean, Flat, Modern & Responsive Template',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Content', 'dslc_string' ),
                'id' => 'content',
                'std' => 'CLICK TO EDIT. Lorem ipsum dolor sit amet, consecteg elitares Integer.',
                'type' => 'textarea',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Read More', 'dslc_string' ),
                'id' => 'read_more',
                'std' => 'Read More',
                'type' => 'text',
                'visibility' => 'hidden'
            ),



            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'title content read_more',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Content', 'dslc_string' ),
                        'value' => 'content'
                    ),
                    array(
                        'label' => __( 'Read More', 'dslc_string' ),
                        'value' => 'read_more'
                    ),
                )
            ),



            /**
             * General Options
             */
            array(
                'label' => __( 'Read More Link', 'dslc_string' ),
                'id' => 'read_more_link',
                'std' => '#',
                'type' => 'text'
            ),


        );

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_info_line', '', array('background-color' => ''), 'Box'),

            // Paddings
            lc_paddings('.met_info_line', 'Paddings', array('t' => '25', 'r' => '30', 'b' => '25', 'l' => '30')),

            // Box Borders
            lc_borders('.met_info_line', 'Borders', array(), array(), '0', '#FFFFFF', 'solid' ),

            // Border Radius
            lc_borderRadius('.met_info_line', 'Border Radius'),

            // Title
            lc_general('.met_info_line_texts h3', 'Title', array('text-align' => 'left', 'font-size' => '24', 'line-height' => '26','color' => '')),

            // Content
            lc_general('.met_p', 'Content', array('text-align' => 'left','font-size' => '14', 'line-height' => '','color' => '22','text-shadow' => '#FFFFFF')),

            // Button
            lc_general('.btn', 'Button', array('float' => 'right', 'font-size' => '12', 'line-height' => '40', 'color' => '', 'color:hover' => '', 'background-color' => '', 'background-color:hover' => '')),

            // Button Paddings
            lc_paddings('.btn', 'Button', array('t' => '0', 'r' => '20', 'b' => '0', 'l' => '20')),

            // Button Margins
            lc_margins('.btn', 'Button'),

            // Button Borders
            lc_borders('.btn', 'Button', array(
                't' => array('width' => '', 'color' => '', 'style' => ''),
                'r' => array('width' => '', 'color' => '', 'style' => ''),
                'b' => array('width' => '', 'color' => '', 'style' => ''),
                'l' => array('width' => '', 'color' => '', 'style' => ''),
            )),

            // Button Border Radius
            lc_borderRadius('.btn', 'Button', '4')
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
            
            $btn = ( in_array( 'read_more', $elements ) ? ('<a href="'.$options['read_more_link'].'" class="btn btn-sm btn-primary met_info_line_button met_color2 '. ( $dslc_is_admin ? 'dslca-editable-content" data-id="read_more" data-type="simple" contenteditable' : '"' ).'>'.stripslashes($options['read_more']).'</a>') : '' );

        ?>

        <div class="met_info_line clearfix <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>

            <?php if( $options['btn_float'] == 'left' ) echo $btn; ?>

            <?php if( in_array( 'title', $elements ) || in_array( 'content', $elements ) ) : ?>
            <div class="met_info_line_texts">

                <?php if( in_array( 'title', $elements ) ) : ?>
                		<h3 <?php if( $dslc_is_admin ): ?>class="dslca-editable-content" data-id="title" data-type="simple" contenteditable<?php endif; ?>><?php echo stripslashes($options['title']); ?></h3>
                <?php endif; ?>

                <?php if( in_array( 'content', $elements ) ) : ?>
                    <h4><div class="met_p <?php if( $dslc_is_admin ): ?>dslca-editable-content" data-id="content" data-type="simple" contenteditable<?php else: ?>"<?php endif; ?> style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>"><?php echo stripslashes($options['content']); ?></div></h4>
                <?php endif; ?>

            </div>
            <?php endif; ?>
            
            <?php if( $options['btn_float'] == 'right' ) echo $btn; ?>
        </div>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */

        $this->module_end( $options );

    }

}