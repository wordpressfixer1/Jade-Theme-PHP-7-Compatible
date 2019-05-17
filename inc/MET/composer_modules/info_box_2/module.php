<?php
// Register Module
function register_iboxtwo_module() {
    return dslc_register_module( "MET_InfoBox2" );
}
add_action('dslc_hook_register_modules','register_iboxtwo_module');

class MET_InfoBox2 extends DSLC_Module {

    var $module_id = 'MET_InfoBox2';
    var $module_title = 'Image Heading';
    var $module_icon = 'info';
    var $module_category = 'met - info boxes';

    function options() {

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'Head Title', 'dslc_string' ),
                'id' => 'head_title',
                'std' => 'EDIT TITLE',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'View All', 'dslc_string' ),
                'id' => 'view_all',
                'std' => 'View All',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
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


            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'head head_title view_all icon image title content',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Head', 'dslc_string' ),
                        'value' => 'head'
                    ),
                    array(
                        'label' => __( 'Head Title', 'dslc_string' ),
                        'value' => 'head_title'
                    ),
                    array(
                        'label' => __( 'View All', 'dslc_string' ),
                        'value' => 'view_all'
                    ),
                    array(
                        'label' => __( 'Icon', 'dslc_string' ),
                        'value' => 'icon'
                    ),
                    array(
                        'label' => __( 'Image', 'dslc_string' ),
                        'value' => 'image'
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
                'label' => __( 'View All Link', 'dslc_string' ),
                'id' => 'view_all_link',
                'std' => '#',
                'type' => 'text'
            ),

            /**
             * Image Options
             */
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
        );


        $dslc_options = array_merge(
            $dslc_options,

            // Content Box Background Color
            lc_general('.met_content_box', '', array('background-color' => ''), 'Box'),

            // Head Fonts
            lc_general('.met_content_box header', 'Head', array('background-color' => '')),

            // Head Fonts
            lc_general('.met_content_box header span', 'Head', array('color' => '','font-size' => '19','line-height' => '25', 'font-weight' => ''), 'Title'),

            // Head View All Fonts
            lc_general('.met_content_box header a', 'Head', array('color' => '','color:hover' => '','font-size' => '12','line-height' => '25'), 'View All'),

            // Head Icon
            lc_general('.met_content_box header i', 'Head', array('icon' => 'html5', 'color' => '','font-size' => '25', 'line-height' => '25'), 'Icon'),

            // Head Paddings
            lc_paddings('.met_content_box header', 'Head', array('t' => '15', 'r' => '30', 'b' => '15', 'l' => '30')),

            // Title
            lc_general('.met_content_box_contents h4', 'Title', array('color' => '','font-size' => '18','line-height' => '19')),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '#FFFFFF')),

            // Content Paddings
            lc_paddings('.met_content_box_contents', 'Content', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

            // Image Borders
            lc_borders('.met_content_box section > img', 'Image', array(), array(), '10', '#E8E6E1', 'solid' ),

            // Border Radius
            lc_borderRadius('.met_content_box section > img', 'Image')
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

        <div class="met_content_box <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <?php if( in_array( 'head', $elements ) ) : ?>
                <header>
                    <?php if( in_array( 'head_title', $elements ) ) : ?>
                        <?php if( $dslc_is_admin ): ?>
                            <span class="dslca-editable-content" data-id="head_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['head_title']); ?></span>
                        <?php elseif( !empty($options['head_title'] ) && !$dslc_is_admin): ?>
                            <span><?php echo stripslashes($options['head_title']); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if( in_array( 'view_all', $elements ) ) : ?>
                        <?php if( $dslc_is_admin ): ?>
                            <a href="<?php echo $options['view_all_link']; ?>" class="met_color2 dslca-editable-content" data-id="view_all" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['view_all']); ?></a>
                        <?php elseif( !empty($options['view_all'] ) && !$dslc_is_admin): ?>
                            <a href="<?php echo $options['view_all_link']; ?>" class="met_color2"><?php echo stripslashes($options['view_all']); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if( in_array( 'icon', $elements ) ) : ?>
                        <i class="dslc-icon dslc-icon-<?php echo $options['met_content_box_header_i_icon']; ?>"></i>
                    <?php endif; ?>
                </header>
            <?php endif; ?>
            <section>
                <?php if( in_array( 'image', $elements ) ) : ?>
                    <?php $resizedImage = imageResizing($options['thumbnail_image'],$options['thumb_resize_height'],$options['thumb_resize_width_manual']); ?>
                    <img src="<?php echo $resizedImage['url']; ?>" alt="<?php echo stripslashes($options['title']); ?>">
                <?php endif; ?>

                <div class="met_content_box_contents">
                    <?php if( in_array( 'title', $elements ) ) : ?>
                        <h4 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></h4>
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
            </section>
        </div>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */

        $this->module_end( $options );

    }

}