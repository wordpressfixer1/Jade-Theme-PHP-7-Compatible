<?php
// Register Module
function register_info_box_module() {
    return dslc_register_module( "MET_InfoBox" );
}
add_action('dslc_hook_register_modules','register_info_box_module');

class MET_InfoBox extends DSLC_Module {

    var $module_id = 'MET_InfoBox';
    var $module_title = 'Vertical with Image';
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
                'label' => __( 'Content', 'dslc_string' ),
                'id' => 'content',
                'std' => 'Lorem ipsum dolor sit amet, consecteg elitares Integer in aliquet risus. Class sociosqu adbus.',
                'type' => 'textarea',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Read More Text', 'dslc_string' ),
                'id' => 'read_more_text',
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
                'std' => 'image image_overlay title content read_more',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Image', 'dslc_string' ),
                        'value' => 'image'
                    ),
                    array(
                        'label' => __( 'Image Overlay', 'dslc_string' ),
                        'value' => 'image_overlay'
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
             * Image Options
             */
            array(
                'label' => __( 'Image Align', 'dslc_string' ),
                'id' => 'align',
                'std' => 'image_at_left',
                'type' => 'select',
                'section' => 'styling',
                'choices' => array(
                    array(
                        'label' => __( 'Left', 'dslc_string' ),
                        'value' => 'image_at_left',
                    ),
                    array(
                        'label' => __( 'Right', 'dslc_string' ),
                        'value' => ''
                    ),
                )
            ),
            array(
                'label' => __( 'Thumbnail', 'dslc_string' ),
                'id' => 'thumbnail_image',
                'std' => '',
                'type' => 'image'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Arrow Visibility', 'dslc_string' ),
                'id' => 'arrow_visibility',
                'std' => 'block',
                'type' => 'select',
                'section' => 'styling',
                'tab' => __( 'image', 'dslc_string' ),
                'choices' => array(
                    array(
                        'label' => __( 'Visible', 'dslc_string' ),
                        'value' => 'block',
                    ),
                    array(
                        'label' => __( 'Hidden', 'dslc_string' ),
                        'value' => 'none'
                    ),
                ),
                'refresh_on_change' => false,
                'affect_on_change_el' => '.met_info_box_image:before',
                'affect_on_change_rule' => 'display',
            ),
            array(
                'label' => __( 'Border Visibility', 'dslc_string' ),
                'id' => 'border_visibility',
                'std' => 'block',
                'type' => 'select',
                'section' => 'styling',
                'tab' => __( 'image', 'dslc_string' ),
                'choices' => array(
                    array(
                        'label' => __( 'Visible', 'dslc_string' ),
                        'value' => '2px',
                    ),
                    array(
                        'label' => __( 'Hidden', 'dslc_string' ),
                        'value' => '0px'
                    ),
                ),
                'refresh_on_change' => false,
                'affect_on_change_el' => '.met_info_box_image',
                'affect_on_change_rule' => 'border-left-width,border-right-width',
            ),
            array(
                'label' => __( 'Lightbox Image', 'dslc_string' ),
                'id' => 'lightbox_image',
                'std' => '',
                'type' => 'image'
            ),

            /**
             * Icons
             */
            array(
                'label' => __( 'Lightbox Icon', 'dslc_string' ),
                'id' => 'lightbox_icon',
                'std' => 'search',
                'type' => 'icon',
                'section' => 'styling',
                'tab' => __( 'Icons', 'dslc_string' )
            ),
            array(
                'label' => __( 'Link Icon', 'dslc_string' ),
                'id' => 'link_icon',
                'std' => 'link',
                'type' => 'icon',
                'section' => 'styling',
                'tab' => __( 'Icons', 'dslc_string' )
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Content Box Background Color
            lc_general('.met_info_box_background', '', array('background-color' => ''), 'Box'),

            // Paddings
            lc_margins('.met_info_box', '', array('t' => '0', 'r' => '0', 'b' => '0', 'l' => '0')),

            // Image Borders
            lc_borders('.met_info_box_image img', 'Image', array(), array(), '10', '', 'solid' ),

            // Title
            lc_general('.met_info_box_content h4', 'Title', array('color' => '','font-size' => '24','line-height' => '26')),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '#FFFFFF')),

            // Paddings
            lc_paddings('.met_info_box_content', 'Content', array('t' => '25', 'r' => '30', 'b' => '25', 'l' => '30')),

            // Read More
            lc_general('.met_info_box_read_more', 'Read More', array('color' => '','color:hover' => '','font-size' => '14','line-height' => '22')),

            // Icons
            lc_general('.met_overlay a', 'Icons', array('background-color' => '', 'background-color:hover' => '', 'color' => '', 'color:hover' => '', 'font-size' => '20', 'width,height,line-height' => '50')),

            // Icons Border Radius
            lc_borderRadius('.met_overlay a', 'Icons', '100')
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
        /* Module output starts here */

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

        $lbExists = !empty($options['lightbox_image']);

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();

        $elID = uniqid('infobox_');
        ?>

        <div id="<?php echo $elID; ?>" class="met_info_box <?php echo $options['align']; ?> clearfix <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <?php if( in_array( 'title', $elements ) || in_array( 'content', $elements ) || in_array( 'read_more', $elements ) ) : ?>
            <div class="met_info_box_content" <?php if( !in_array( 'image', $elements ) ) echo 'style="width: 100%;"'; ?>>

                <?php if( in_array( 'title', $elements ) ) : ?>

                    <?php if( $dslc_is_admin ): ?>
                        <h4 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></h4>
                    <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                        <h4><?php echo stripslashes($options['title']); ?></h4>
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

                <?php if( in_array( 'read_more', $elements ) ) : ?>

                    <?php if( $dslc_is_admin ): ?>
                        <a href="<?php echo $options['read_more_link'] ?>" class="met_info_box_read_more met_transition met_color2 dslca-editable-content" data-id="read-more-text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['read_more_text']); ?></a>
                    <?php elseif( !empty($options['read_more_text'] ) && !$dslc_is_admin): ?>
                        <a href="<?php echo $options['read_more_link'] ?>" class="met_info_box_read_more met_transition met_color2"><?php echo stripslashes($options['read_more_text']); ?></a>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if( in_array( 'image', $elements ) ) : ?>

                <?php //if( !empty($options['thumbnail_image'] ) ): ?>
                    <div class="met_info_box_image met_overlay_wrapper" style="<?php if( !in_array( 'title', $elements ) && !in_array( 'content', $elements ) && !in_array( 'read_more', $elements ) ) echo 'width: 100%;'; if(empty($options['align'])) echo 'float: right; margin-left: 0;'; ?>">
                        <?php $resizedImage = imageResizing($options['thumbnail_image'],$options['thumb_resize_height'],$options['thumb_resize_width_manual']); ?>
                        <img src="<?php echo $resizedImage['url']; ?>" alt="<?php echo !empty($options['title']) ? stripslashes($options['title']) : ''; ?>">
                        <?php if( in_array( 'image_overlay', $elements ) ) : ?>
                            <div class="met_overlay">
                                <div>
                                    <?php if( $lbExists ): ?>
                                        <a href="<?php echo $options['lightbox_image']; ?>" rel="lb_<?php echo $elID; ?>"><i class="dslc-icon dslc-icon-<?php echo $options['lightbox_icon']; ?>"></i></a>
                                    <?php endif; ?>

                                    <?php if( !empty($options['read_more_link']) ): ?>
                                        <a href="<?php echo $options['read_more_link']; ?>"><i class="dslc-icon dslc-icon-<?php echo $options['link_icon']; ?>"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php //endif; ?>

            <?php endif; ?>
            <div class="met_info_box_background"></div>
        </div>
        <?php if( $lbExists ): ?><script>jQuery(document).ready(function(){<?php if( $dslc_is_admin ): ?>CoreJS.lightbox();<?php endif; ?>});</script><?php endif; ?>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}