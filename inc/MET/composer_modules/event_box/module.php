<?php

// Register Module
function register_eventbox_module() {
    return dslc_register_module( "MET_EventBox" );
}
add_action('dslc_hook_register_modules','register_eventbox_module');

class MET_EventBox extends DSLC_Module {

    var $module_id = 'MET_EventBox';
    var $module_title = 'Timer on Image';
    var $module_icon = 'info';
    var $module_category = 'met - events';

    function options() {

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'Title 1', 'dslc_string' ),
                'id' => 'title_1',
                'std' => 'CLICK TO EDIT',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Title 2', 'dslc_string' ),
                'id' => 'title_2',
                'std' => 'CLICK TO EDIT',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Button', 'dslc_string' ),
                'id' => 'button',
                'std' => 'CLICK TO EDIT',
                'type' => 'text',
                'visibility' => 'hidden'
            ),



            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'title_1 title_2 button',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Title 1', 'dslc_string' ),
                        'value' => 'title_1'
                    ),
                    array(
                        'label' => __( 'Title 2', 'dslc_string' ),
                        'value' => 'title_2'
                    ),
                    array(
                        'label' => __( 'Button', 'dslc_string' ),
                        'value' => 'button'
                    ),
                )
            ),

            array(
                'label' => __( 'Post ID', 'dslc_string' ),
                'id' => 'pid',
                'std' => '',
                'type' => 'text'
            ),

            /**
             * General Options
             */
            array(
                'label' => __( 'Title 1 Link', 'dslc_string' ),
                'id' => 'title_1_link',
                'std' => '',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Open In', 'dslc_string' ),
                'id' => 'title_1_target',
                'std' => '_blank',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'New Tab', 'dslc_string' ),
                        'value' => '_blank',
                    ),
                    array(
                        'label' => __( 'Same Page', 'dslc_string' ),
                        'value' => '_self'
                    ),
                )
            ),

            array(
                'label' => __( 'Title 2 Link', 'dslc_string' ),
                'id' => 'title_2_link',
                'std' => '',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Open In', 'dslc_string' ),
                'id' => 'title_2_target',
                'std' => '_blank',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'New Tab', 'dslc_string' ),
                        'value' => '_blank',
                    ),
                    array(
                        'label' => __( 'Same Page', 'dslc_string' ),
                        'value' => '_self'
                    ),
                )
            ),

            array(
                'label' => __( 'Button Link', 'dslc_string' ),
                'id' => 'button_link',
                'std' => 'http://#',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Open In', 'dslc_string' ),
                'id' => 'button_target',
                'std' => '_blank',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'New Tab', 'dslc_string' ),
                        'value' => '_blank',
                    ),
                    array(
                        'label' => __( 'Same Page', 'dslc_string' ),
                        'value' => '_self'
                    ),
                )
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
            lc_general('.met_event_box', '', array('background-color' => ''), 'Box'),

            // Image Borders
            lc_borders('.met_event_box', '', array(), array(), '10', 'rgba(0,0,0,0.19)', 'solid' ),

            // Title 1
            lc_general('.met_event_box_title_1', 'Title 1', array('left' => '0_%','top' => '0_%','color' => '','color:hover' => '','background-color' => '','background-color:hover' => '','font-size' => '36','line-height' => '60','font-weight' => '600')),

            // Title 2
            lc_general('.met_event_box_title_2', 'Title 2', array('left' => '0_%','top' => '25_%','color' => '','color:hover' => '','background-color' => '','background-color:hover' => '','font-size' => '36','line-height' => '60','font-weight' => '600')),

            // Button
            lc_general('.btn.btn-primary', 'Button', array('left' => '7_%','top' => '72_%','color' => '','color:hover' => '','background-color' => '','background-color:hover' => '','font-size' => '14','line-height' => '40','font-weight' => '400')),

            // Countdown
            lc_general('.met_event_box_remaining', 'Countdown Box', array('left' => '0_%','bottom' => '0_%')),

            // Countdown Boxes
            lc_general('figure', 'Countdown Box', array('background-color' => 'rgba(0,0,0,0.75)')),

            // Countdown Boxes Border Radius
            lc_borderRadius('figure', 'Countdown Box', '5'),

            // Countdown Numbers
            lc_general('figcaption > span:first-child', 'Countdown Numbers', array('color' => '','font-size' => '36','line-height' => '40','font-weight' => '600')),

            // Countdown Labels
            lc_general('figcaption > span:last-child', 'Countdown Labels', array('color' => '','font-size' => '14','line-height' => '22','font-weight' => '600'))
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

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();

        $postInfo = array();

        if( !empty($options['pid']) ){
            $args = array(
                'posts_per_page' => 1,
                'p' => $options['pid'],
                'post_type' => 'any');
            $dslc_query = new WP_Query($args);

            if ( $dslc_query->have_posts() ){
                while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
                    $postInfo['title'] = get_the_title();

                    $postInfo['end'] = tribe_get_end_date(null,true,'Y-m-d H:i:s');

                    if( !empty($postInfo['end']) ){
                        if ( $dslc_is_admin ){
                            echo '<script src="'.get_template_directory_uri().'/js/jquery.counteverest.min.js'.'"></script>';
                        }else{
                            wp_enqueue_script('metcreative-counteverest');
                        }

                        $countDownID = uniqid('countdown_');

                        $parts = explode(' ', $postInfo['end']);

                        $year = explode('-', $parts[0]);
                        $days = explode(':', $parts[1]);

                        ?>
                        <script type="text/javascript">
                            var arr = new Array();
                            arr['day'] = <?php echo $year[2]; ?>;
                            arr['month'] = <?php echo $year[1]; ?>;
                            arr['year'] = <?php echo $year[0]; ?>;

                            arr['hour'] = <?php echo $days[0]; ?>;
                            arr['minute'] = <?php echo $days[1]; ?>;
                            arr['second'] = <?php echo $days[2]; ?>;
                        </script>
                        <?php
                    }
                endwhile;
            }
        }
        ?>
        <div class="met_event_box met_bgcolor">
            <?php
                if( !empty($options['pid']) ){
                    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    $options['thumbnail_image'] = $thumb_url[0];
                }

                $resizedImage = imageResizing($options['thumbnail_image'],$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
            ?>
            <img src="<?php echo $resizedImage['url']; ?>" alt="" />

            <?php if( in_array( 'title_1', $elements ) || in_array( 'title_2', $elements ) || in_array( 'button', $elements ) ) : ?>
            <div class="met_event_box_overlay">
                <?php if( in_array( 'title_1', $elements ) ) : ?>
                    <?php
                    $openTag = 'span';
                    $closeTag = 'span';
                    if( !empty($options['title_1_link']) ){
                        $openTag = 'a href="'.$options['title_1_link'].'" target="'.$options['title_1_target'].'"';
                        $closeTag = 'a';
                    }
                    ?>
                    <?php
                    if( isset($postInfo['title']) ){
                    ?>
                        <a href="<?php the_permalink(); ?>" class="met_event_box_title_1"><?php the_title(); ?></a>
                    <?php
                    }else{
                    ?>
                        <<?php echo $openTag; ?> class="met_event_box_title_1 dslca-editable-content" data-id="title_1" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title_1']); ?></<?php echo $closeTag; ?>>
                    <?php } ?>
                <?php endif; ?>

                <?php if( in_array( 'title_2', $elements ) ) : ?>
                    <?php
                    $openTag = 'span';
                    $closeTag = 'span';
                    if(!empty($options['title_2_link'])){
                        $openTag = 'a href="'.$options['title_2_link'].'" target="'.$options['title_2_target'].'"';
                        $closeTag = 'a';
                    }
                    ?>
                    <<?php echo $openTag; ?> class="met_event_box_title_2 dslca-editable-content" data-id="title_2" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title_2']); ?></<?php echo $closeTag; ?>>
                <?php endif; ?>

                <?php if( !isset($year) && in_array( 'button', $elements ) ) : ?>
                    <a href="<?php echo $options['button_link']; ?>" target="<?php echo $options['button_target']; ?>" class="btn btn-primary btn-sm dslca-editable-content" data-id="button" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['button']); ?></a>
                <?php endif; ?>

                <?php if( isset($countDownID) ): ?>
                    <div class="met_event_box_remaining countdown" id="<?php echo $countDownID; ?>">
                        <figure class="met_vcenter">
                            <figcaption>
                                <span class="ce-days"></span> <span class="ce-days-label met_color2"></span>
                            </figcaption>
                        </figure>
                        <figure class="met_vcenter">
                            <figcaption>
                                <span class="ce-hours"></span> <span class="ce-hours-label met_color2"></span>
                            </figcaption>
                        </figure>
                        <figure class="met_vcenter">
                            <figcaption>
                                <span class="ce-minutes"></span> <span class="ce-minutes-label met_color2"></span>
                            </figcaption>
                        </figure>
                        <figure class="met_vcenter">
                            <figcaption>
                                <span class="ce-seconds"></span> <span class="ce-seconds-label met_color2"></span>
                            </figcaption>
                        </figure>
                    </div>
                <script>jQuery(document).ready(function(){CoreJS.setCountDown('<?php echo $countDownID; ?>',arr);});</script>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <?php
        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}