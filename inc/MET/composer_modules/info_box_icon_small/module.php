<?php

// Register Module
function register_iboxiconsmall_module() {
    return dslc_register_module( "MET_InfoBoxIconSmall" );
}
add_action('dslc_hook_register_modules','register_iboxiconsmall_module');

class MET_InfoBoxIconSmall extends DSLC_Module {

    var $module_id = 'MET_InfoBoxIconSmall';
    var $module_title = 'Icon on Strip';
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
                'std' => 'CLICK TO EDIT',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Sub Title', 'dslc_string' ),
                'id' => 'sub_title',
                'std' => 'Click to Edit Sub Information',
                'type' => 'text',
                'visibility' => 'hidden'
            ),

            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'icon title sub_title',
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
                        'label' => __( 'Sub Title', 'dslc_string' ),
                        'value' => 'sub_title'
                    ),
                )
            ),

            /**
             * General Options
             */
            array(
                'label' => __( 'Box Link URL', 'dslc_string' ),
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
            lc_general('.met_info_box_icon_small', '', array('background-color' => '', 'background-color:hover' => ''), 'Box'),

            // Paddings
            lc_paddings('.met_info_box_icon_small', 'Paddings', array('t' => '20', 'r' => '20', 'b' => '20', 'l' => '20')),

            // Box Borders
            lc_borders('.met_info_box_icon_small', 'Borders', array(), array(), '0', '#FFFFFF', 'solid' ),

            // Border Radius
            lc_borderRadius('.met_info_box_icon_small', 'Border Radius'),

            // Icon
            lc_general('.met_info_box_icon_small_icon>i', 'Icon', array('icon' => 'html5', 'color' => '','font-size' => '60'), 'Icon'),

            // Title
            lc_general('.met_info_box_icon_small_title', 'Title', array('color' => '', 'font-size' => '24', 'line-height' => '24', 'font-weight' => '400',)),

            // Sub Title
            lc_general('.met_info_box_icon_small_sub_title', 'Sub Title', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400',))
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

        $boxTagOpen = '<div class="met_info_box_icon_small met_bgcolor clearfix '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].'>';
        $boxTagClose = '</div>';

        if( !empty($options['box_link_url']) ){
            $boxTagOpen = '<a href="'.$options['box_link_url'].'" class="met_info_box_icon_small met_bgcolor clearfix '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].' target="'.$options['button_target'].'">';
            $boxTagClose = '</a>';
        }
?>
        <?php echo $boxTagOpen ?>
        <?php if( in_array( 'icon', $elements ) ) : ?>
            <span class="met_info_box_icon_small_icon"><i class="dslc-icon dslc-icon-<?php echo $options['met_info_box_icon_small_icon_i_icon']; ?>"></i></span>
        <?php endif; ?>
        <div>
            <?php if( in_array( 'title', $elements ) ) : ?>
                <span class="met_info_box_icon_small_title dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></span>
            <?php endif; ?>
            <?php if( in_array( 'sub_title', $elements ) ) : ?>
                <span class="met_info_box_icon_small_sub_title dslca-editable-content" data-id="sub_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['sub_title']); ?></span>
            <?php endif; ?>
        </div>
        <?php echo $boxTagClose ?>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */

        $this->module_end( $options );

    }

}