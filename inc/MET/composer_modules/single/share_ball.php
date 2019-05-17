<?php

// Register Module
function register_singleshareball_module() {
    return dslc_register_module( "MET_Single_ShareBall" );
}
add_action('dslc_hook_register_modules','register_singleshareball_module');

class MET_Single_ShareBall extends DSLC_Module {

    var $module_id = 'MET_Single_ShareBall';
    var $module_title = 'Share Ball';
    var $module_icon = 'thumbs-up';
    var $module_category = 'met - single';

    function options() {

        $dslc_options = array(

            array(
                'label' => __( 'Share URL', 'dslc_string' ).' '.__( 'See', 'dslc_string' ).' <a href="#" target="_blank">'.__( 'Documentation', 'dslc_string' ).'</a> '.__( 'For Proper Usage', 'dslc_string' ),
                'id' => 'share_url',
                'std' => 'http://www.facebook.com/sharer.php?u=[permalink]',
                'type' => 'text'
            ),

            /**
             * General Options
             */
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
            lc_general('.met_info_box_icon_small', '', array('background-color' => '', 'background-color:hover' => '', 'text-align' => 'left'), 'Box'),

            // Paddings
            lc_paddings('.met_info_box_icon_small', 'Paddings', array('t' => '20', 'r' => '20', 'b' => '20', 'l' => '20')),

            // Box Borders
            lc_borders('.met_info_box_icon_small', 'Borders', array(), array(), '0', '#FFFFFF', 'solid' ),

            // Border Radius
            lc_borderRadius('.met_info_box_icon_small', 'Border Radius'),

            // Icon
            lc_general('.met_info_box_icon_small_icon>i', 'Icon', array('icon' => 'facebook', 'color' => '','font-size' => '60'), 'Icon')
        );

        $dslc_options = array_merge( $dslc_options, $this->presets_options() );
		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

    }

    function output( $options ) {

        global $dslc_active;

        $post_id = $options['post_id'];

        if ( is_singular() ) {
            $post_id = get_the_ID();
        }

        if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
            $dslc_is_admin = true;
        else
            $dslc_is_admin = false;

        $this->module_start( $options );

        /* Module output starts here */

        $share_url = $options['share_url'];
        $share_url = str_replace('[post-title]',get_the_title($post_id),$share_url);
        $share_url = str_replace('[permalink]',get_permalink($post_id),$share_url);

        $boxTagOpen = '<a href="'.$share_url.'" class="met_info_box_icon_small met_bgcolor '.$options['met_info_box_icon_small_text_align'].' clearfix" target="'.$options['button_target'].'">';
        $boxTagClose = '</a>';
        ?>
        <?php echo $boxTagOpen ?>

            <span class="met_info_box_icon_small_icon"><i class="dslc-icon dslc-icon-<?php echo $options['met_info_box_icon_small_icon_i_icon']; ?>"></i></span>

        <?php echo $boxTagClose ?>
        <?php

        /* Module output ends here */

        $this->module_end( $options );

    }

}