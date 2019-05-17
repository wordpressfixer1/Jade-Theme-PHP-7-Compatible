<?php
// Register Module
function register_brandscarathree_module() {
    return dslc_register_module( "MET_BrandsCarousel3" );
}
add_action('dslc_hook_register_modules','register_brandscarathree_module');

class MET_BrandsCarousel3 extends DSLC_Module {

    var $module_id = 'MET_BrandsCarousel3';
    var $module_title = 'Vertical Carousel';
    var $module_icon = 'info';
    var $module_category = 'met - gallery';

    function options() {

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'First Title', 'dslc_string' ),
                'id' => 'first_title',
                'std' => 'PARTNERS',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Second Title', 'dslc_string' ),
                'id' => 'second_title',
                'std' => 'Customers',
                'type' => 'text',
                'visibility' => 'hidden'
            ),

            array(
                'label' => __( 'Gallery Post ID', 'dslc_string' ),
                'id' => 'gallery_post_id',
                'std' => '',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
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
                'label' => __( 'Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '',
                'type' => 'text'
            ),

            /**
             * Carousel Options
             */
            array(
                'label' => __( 'Speed', 'dslc_string' ),
                'id' => 'speed',
                'std' => '500',
                'type' => 'text',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Start Slide', 'dslc_string' ),
                'id' => 'start_slide',
                'std' => '0',
                'type' => 'text',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Random Start', 'dslc_string' ),
                'id' => 'random_start',
                'std' => 'false',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Yes',
                        'value' => 'true',
                    ),
                    array(
                        'label' => 'No',
                        'value' => 'false',
                    ),
                ),
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Infinite Loop', 'dslc_string' ),
                'id' => 'infinite_loop',
                'std' => 'true',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Yes',
                        'value' => 'true',
                    ),
                    array(
                        'label' => 'No',
                        'value' => 'false',
                    ),
                ),
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Auto Slide', 'dslc_string' ),
                'id' => 'auto_slide',
                'std' => 'true',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Yes',
                        'value' => 'true',
                    ),
                    array(
                        'label' => 'No',
                        'value' => 'false',
                    ),
                ),
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Pause', 'dslc_string' ),
                'id' => 'pause',
                'std' => '4000',
                'type' => 'text',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Slide Direction', 'dslc_string' ),
                'id' => 'slide_direction',
                'std' => 'next',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Next',
                        'value' => 'next',
                    ),
                    array(
                        'label' => 'Previous',
                        'value' => 'prev',
                    ),
                ),
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Hover Over Stop', 'dslc_string' ),
                'id' => 'hover_over_stop',
                'std' => 'false',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Yes',
                        'value' => 'true',
                    ),
                    array(
                        'label' => 'No',
                        'value' => 'false',
                    ),
                ),
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Move Slides', 'dslc_string' ),
                'id' => 'move_slides',
                'std' => '1',
                'type' => 'text',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Minimum Visible', 'dslc_string' ),
                'id' => 'minimum_visible',
                'std' => '3',
                'type' => 'text',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Maximum Visible', 'dslc_string' ),
                'id' => 'maximum_visible',
                'std' => '3',
                'type' => 'text',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Caption
            lc_general('.met_image_carousel_wrap_3_caption', '', array('background-color' => ''), 'Caption'),

            // Caption Paddings
            lc_paddings('.met_image_carousel_wrap_3_caption', '', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

            // First Title
            lc_general('.met_image_carousel_wrap_3_caption h4', 'First Title', array('color' => '','font-size' => '24','line-height' => '26', 'font-weight' => '600')),

            // Second Title
            lc_general('.met_image_carousel_wrap_3_caption h5', 'First Title', array('color' => '','font-size' => '16','line-height' => '18', 'font-weight' => '400')),

            // Navigation
            lc_general('.met_image_carousel_wrap_3 nav', 'Navigation', array('background-color' => ''))
        );

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
        $asyncScripts = "[]";
        if ( $dslc_is_admin )
            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.bxslider.min.js"]';
        else
            wp_enqueue_script('metcreative-bxslider');


        // General args
        $args = array(
            'post_type' => 'dslc_galleries'
        );

        if(!empty($options['gallery_post_id'])){ $args['p'] = $options['gallery_post_id']; }else{ $args['p'] = 1; }

        // Do the query
        $dslc_query = new WP_Query( $args );
        ?>

        <?php if ( $dslc_query->have_posts() ){ $elementID = uniqid('carousel_'); ?>
        <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
            <div class="met_image_carousel_wrap_3">
                <div class="met_image_carousel_wrap_3_caption">
                    <?php if( $dslc_is_admin ): ?>
                        <h4 class="dslca-editable-content" data-id="first_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['first_title']); ?></h4>
                    <?php elseif( !empty($options['first_title'] ) && !$dslc_is_admin): ?>
                        <h4><?php echo stripslashes($options['first_title']); ?></h4>
                    <?php endif; ?>
                    <?php if( $dslc_is_admin ): ?>
                        <h5 class="dslca-editable-content" data-id="second_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['second_title']); ?></h5>
                    <?php elseif( !empty($options['second_title'] ) && !$dslc_is_admin): ?>
                        <h5><?php echo stripslashes($options['second_title']); ?></h5>
                    <?php endif; ?>
                    <nav class="met_bgcolor">
                        <a href="#" class="previous met_vcenter"><i class="dslc-icon dslc-icon-chevron-up"></i></a>
                        <a href="#" class="next met_vcenter"><i class="dslc-icon dslc-icon-chevron-down"></i></a>
                    </nav>
                </div>
                <?php
                $gallery_images = get_post_meta( get_the_ID(), 'dslc_gallery_images', true );
                $gallery_images_count = 0;

                if ( $gallery_images )
                    $gallery_images = explode( ' ', trim( $gallery_images ) );

                $images = array();
                foreach ( $gallery_images as $gallery_image ) :
                    $imageURL = wp_get_attachment_image_src( $gallery_image, 'full' );
                    $imageURL = $imageURL[0];
                    $resized = imageResizing($imageURL,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                    $images[] = $resized['url'];
                endforeach;
                ?>
                <div class="met_image_carousel">
                    <div id="<?php echo $elementID ?>" data-mode="vertical" data-width="<?php echo $options['thumb_resize_width_manual'] ?>" data-speed="<?php echo $options['speed'] ?>" data-startslide="<?php echo $options['start_slide'] ?>" data-randomstart="<?php echo $options['random_start'] ?>" data-infiniteloop="<?php echo $options['infinite_loop'] ?>" data-autoslide="<?php echo $options['auto_slide'] ?>" data-pause="<?php echo $options['pause'] ?>" data-slidedirection="<?php echo $options['slide_direction'] ?>" data-hoveroverstop"<?php echo $options['hover_over_stop'] ?>" data-moveslides="<?php echo $options['move_slides'] ?>" data-minimumvisible="<?php echo $options['minimum_visible'] ?>" data-maximumvisible="<?php echo $options['maximum_visible'] ?>">
                        <?php foreach ( $images as $image ) : ?>
                        <figure><img src="<?php echo $image ?>" alt="" /></figure>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["imageCarousel|<?php echo $elementID ?>"]);});</script>
        <?php endwhile; }else{
            if ( $dslc_is_admin ) :
                ?><div class="dslc-notification dslc-red">You do not have any galleries at the moment. Go to <strong>WP Admin &rarr; Galleries</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
            endif;
        } ?>

        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }
}
