<?php

// Register Module
function register_gallerycaratwo_module() {
    return dslc_register_module( "MET_GalleryCarousel2" );
}
add_action('dslc_hook_register_modules','register_gallerycaratwo_module');

class MET_GalleryCarousel2 extends DSLC_Module {

    var $module_id = 'MET_GalleryCarousel2';
    var $module_title = 'Navigational Carousel';
    var $module_icon = 'info';
    var $module_category = 'met - gallery';

    function options() {

        $dslc_options = array(
            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'nav',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Navigation', 'dslc_string' ),
                        'value' => 'nav'
                    ),
                )
            ),
            array(
                'label' => __( 'Gallery Post ID', 'dslc_string' ),
                'id' => 'gallery_post_id',
                'std' => '',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '390',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '390',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'g_thumb_resize_height',
                'std' => '300',
                'type' => 'text'
            ),

            array(
                'label' => __( 'Column Size', 'dslc_string' ),
                'id' => 'column_size',
                'std' => '3',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => '6',
                        'value' => '6',
                    ),
                    array(
                        'label' => '5',
                        'value' => '5',
                    ),
                    array(
                        'label' => '4',
                        'value' => '4',
                    ),
                    array(
                        'label' => '3',
                        'value' => '3',
                    ),
                ),
            ),

            array(
                'label' => __( 'Speed', 'dslc_string' ),
                'id' => 'speed',
                'std' => '500',
                'type' => 'text',
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
            ),
            array(
                'label' => __( 'Pause', 'dslc_string' ),
                'id' => 'pause',
                'std' => '5000',
                'type' => 'text',
            ),

            array(
                'label' => __( 'Lightbox Support', 'dslc_string' ),
                'id' => 'lightbox',
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
            ),

        );

        $dslc_options = array_merge(
            $dslc_options,

            // Nav
            lc_general('.met_gallery_carousel_2_wrap > a', '', array('background-color' => '', 'background-color:hover' => '', 'color' => '','color:hover' => '', 'font-size' => '14'), 'Navigation')

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
        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.bxslider.min.js"]';
        }else{
            wp_enqueue_script('metcreative-bxslider');
        }


        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();

        $elementID = uniqid('gallerycarousel2_');

        // General args
        $args = array(
            'post_type' => 'dslc_galleries'
        );

        if(!empty($options['gallery_post_id'])) $args['p'] = $options['gallery_post_id'];

        // Do the query
        $dslc_query = new WP_Query( $args );
        $have_posts = false;
        ?>

        <?php if ( $dslc_query->have_posts() ) $have_posts = true; ?>

        <?php if($have_posts): ?>
            <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
                <?php
                $gallery_images = get_post_meta( get_the_ID(), 'dslc_gallery_images', true );
                $gallery_images_count = 0;

                if ( $gallery_images )
                    $gallery_images = explode( ' ', trim( $gallery_images ) );

                $images = array();
                foreach ( $gallery_images as $gallery_image ) :
                    $imageURL = wp_get_attachment_image_src( $gallery_image, 'full' );
                    $imageURL = $imageURL[0];

                    $resized = imageResizing($imageURL,$options['g_thumb_resize_height'],$options['thumb_resize_width_manual']);
                    if($resized == false) $resized = $imageURL;
                    $images[] = array('thumb' => $resized['url'], 'full' => $imageURL);
                endforeach;
                ?>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>

            <div id="<?php echo $elementID; ?>" class="met_gallery_carousel_2_wrap clearfix" data-columns="<?php echo $options['column_size'] ?>" data-auto="<?php echo $options['auto_slide'] ?>" data-speed="<?php echo $options['speed'] ?>" data-pause="<?php echo $options['pause'] ?>">

            <?php if( in_array( 'nav', $elements ) ) : ?>
                <a href="#" class="prev met_vcenter"><i class="dslc-icon dslc-icon-chevron-left"></i></a>
                <a href="#" class="next met_vcenter"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
            <?php endif; ?>

                <?php if(count($images) > 0): ?>
                    <div class="met_gallery_carousel_2 clearfix">
                        <?php foreach($images as $image): ?>
                            <a class="met_gallery_carousel_2_item" href="<?php echo $image['full'] ?>" rel="lb_<?php echo $elementID; ?>"><img src="<?php echo $image['thumb'] ?>" alt="" /></a>
                            <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["postsCarousel2|<?php echo $elementID ?>"]);});</script>
        <?php endif; ?>

        <?php if ( $dslc_is_admin AND !$have_posts ) : ?>
            <div class="dslc-notification dslc-red">You do not have any galleries at the moment. Go to <strong>WP Admin &rarr; Galleries</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div>
        <?php endif; ?>


        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}