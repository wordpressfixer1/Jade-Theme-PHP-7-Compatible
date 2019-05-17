<?php

// Register Module
function register_iboxicon_module() {
    return dslc_register_module( "MET_InfoBoxIcon" );
}
add_action('dslc_hook_register_modules','register_iboxicon_module');

class MET_InfoBoxIcon extends DSLC_Module {

    var $module_id = 'MET_InfoBoxIcon';
    var $module_title = 'Info Box Icon';
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
                'std' => 'EDIT TITLE',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Content', 'dslc_string' ),
                'id' => 'content',
                'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eget metus eros.',
                'type' => 'textarea',
                'visibility' => 'hidden'
            ),

            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'icon title content read_more',
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


            /**
             * Read More
             */
            array(
                'label' => __( 'Use Positions', 'dslc_string' ),
                'id' => 'use_positions',
                'std' => 'top right',
                'type' => 'checkbox',
                'section' => 'styling',
                'choices' => array(
                    array(
                        'label' => __( 'Top', 'dslc_string' ),
                        'value' => 'top'
                    ),
                    array(
                        'label' => __( 'Right', 'dslc_string' ),
                        'value' => 'right'
                    ),
                    array(
                        'label' => __( 'Bottom', 'dslc_string' ),
                        'value' => 'bottom'
                    ),
                    array(
                        'label' => __( 'Left', 'dslc_string' ),
                        'value' => 'left'
                    ),
                ),
                'tab' => __( 'Read More', 'dslc_string' )
            ),
            array(
                'label' => __( 'Position Top', 'dslc_string' ),
                'id' => 'button_position_top',
                'std' => '20',
                'type' => 'slider',
                'section' => 'styling',
                'refresh_on_change' => true,
                'affect_on_change_el' => '.met_simple_box_link',
                'affect_on_change_rule' => 'top',
                'ext' => 'px',
                'tab' => __( 'Read More', 'dslc_string' )
            ),
            array(
                'label' => __( 'Position Right', 'dslc_string' ),
                'id' => 'button_position_right',
                'std' => '20',
                'type' => 'slider',
                'section' => 'styling',
                'refresh_on_change' => true,
                'affect_on_change_el' => '.met_simple_box_link',
                'affect_on_change_rule' => 'right',
                'ext' => 'px',
                'tab' => __( 'Read More', 'dslc_string' )
            ),
            array(
                'label' => __( 'Position Bottom', 'dslc_string' ),
                'id' => 'button_position_bottom',
                'std' => '0',
                'type' => 'slider',
                'section' => 'styling',
                'refresh_on_change' => true,
                'affect_on_change_el' => '.met_simple_box_link',
                'affect_on_change_rule' => 'bottom',
                'ext' => 'px',
                'tab' => __( 'Read More', 'dslc_string' )
            ),
            array(
                'label' => __( 'Position Left', 'dslc_string' ),
                'id' => 'button_position_left',
                'std' => '0',
                'type' => 'slider',
                'section' => 'styling',
                'refresh_on_change' => true,
                'affect_on_change_el' => '.met_simple_box_link',
                'affect_on_change_rule' => 'left',
                'ext' => 'px',
                'tab' => __( 'Read More', 'dslc_string' )
            ),

        );

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_simple_box', '', array('background-color' => '','text-align' => 'left'), 'Box'),

            // Paddings
            lc_paddings('.met_simple_box.with_padding', 'Paddings', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

            // Box Borders
            lc_borders('.met_simple_box', 'Borders', array(), array(), '0', '#FFFFFF', 'solid' ),

            // Border Radius
            lc_borderRadius('.met_simple_box', 'Border Radius'),

            // Icon
            lc_general('.met_simple_box>i', 'Icon', array('icon' => 'html5', 'color' => '','font-size' => '92'), 'Icon'),

            // Read More
            lc_general('.met_simple_box_link', 'Read More', array('font-size' => '11', 'line-height' => '30', 'color' => '','color:hover' => '','background-color' => '','background-color:hover' => ''), 'Button'),

            // Title
            lc_general('.met_simple_box_content h5', 'Title', array('text-align' => 'left','font-size' => '19', 'line-height' => '22','color' => '','font-weight' => '400')),

            // Content
            lc_general('.met_p', 'Content', array('text-align' => 'left','font-size' => '14', 'line-height' => '22','color' => '','text-shadow' => '#FFFFFF'))
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

        // Positions
        $positions = $options['use_positions'];
        if ( ! empty( $positions ) )
            $positions = explode( ' ', trim( $positions ) );
        else
            $positions = array();
        $readMorePos = '';
        if( !in_array( 'top',       $positions ) ) $readMorePos .= 'top: auto;';
        if( !in_array( 'right',     $positions ) ) $readMorePos .= 'right: auto;';
        if( !in_array( 'bottom',    $positions ) ) $readMorePos .= 'bottom: auto;';
        if( !in_array( 'left',      $positions ) ) $readMorePos .= 'left: auto;';
        if( $readMorePos != '' )    $readMorePos = 'style="'.$readMorePos.'"';

        $openingTag = '<div class="met_simple_box with_bg with_padding '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].'>';
        $closingTag = '</div>';
        if( !in_array( 'read_more', $elements ) && $options['read_more_link'] != '' && $options['read_more_link'] != '#' ){
            $openingTag = '<a href="'.$options['read_more_link'].'" class="met_simple_box with_bg with_padding '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].' target="_blank">';
            $closingTag = '</a>';
        }
?>


        <?php echo $openingTag; ?>
            <?php if( in_array( 'icon', $elements ) ) : ?>
            <i class="dslc-icon dslc-icon-<?php echo $options['met_simple_box_i_icon']; ?>" style="<?php echo count($elements) < 2 ? 'margin-bottom: 0;' : ''; ?>"></i>
            <?php endif; ?>

            <?php if( in_array( 'title', $elements ) || in_array( 'content', $elements ) ) : ?>
            <div class="met_simple_box_content">
                <?php if( in_array( 'title', $elements ) ) : ?>
                    <?php if( $dslc_is_admin ): ?>
                    <h5 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></h5>
                    <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                    <h5><?php echo stripslashes($options['title']); ?></h5>
                    <?php endif; ?>
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
            <?php endif; ?>

            <?php if( in_array( 'read_more', $elements ) ) : ?>
            <a <?php echo $readMorePos ?> href="<?php echo $options['read_more_link'] ?>" class="met_simple_box_link met_bgcolor_transition"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
            <?php endif; ?>
        <?php echo $closingTag; ?>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */

        $this->module_end( $options );

    }

}