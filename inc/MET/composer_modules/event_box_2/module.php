<?php
// Register Module
function register_eventboxtwo_module() {
    return dslc_register_module( "MET_EventBox2" );
}
add_action('dslc_hook_register_modules','register_eventboxtwo_module');

class MET_EventBox2 extends DSLC_Module {

    var $module_id = 'MET_EventBox2';
    var $module_title = 'Info Box';
    var $module_icon = 'info';
    var $module_category = 'met - events';

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
                'label' => __( 'Sub Title', 'dslc_string' ),
                'id' => 'sub_title',
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
                'std' => 'image image_overlay title sub_title content',
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
                        'label' => __( 'Sub Title', 'dslc_string' ),
                        'value' => 'sub_title'
                    ),
                    array(
                        'label' => __( 'Content', 'dslc_string' ),
                        'value' => 'content'
                    ),
                    array(
                        'label' => __( 'Countdown', 'dslc_string' ),
                        'value' => 'countdown'
                    ),
                )
            ),
            array(
                'label' => __( 'Post ID', 'dslc_string' ),
                'id' => 'pid',
                'std' => '',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
                'id' => 'excerpt_length',
                'std' => '20',
                'type' => 'text'
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
                'label' => __( 'Thumbnail Position', 'dslc_string' ),
                'id' => 'thumbnail_position',
                'std' => 'left',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Left', 'dslc_string' ),
                        'value' => 'left'
                    ),
                    array(
                        'label' => __( 'Right', 'dslc_string' ),
                        'value' => 'right'
                    ),
                )
            ),
            array(
                'label' => __( 'Thumbnail Size', 'dslc_string' ),
                'id' => 'thumbnail_size',
                'std' => 39,
                'type' => 'slider',
                'min' => 0,
                'max' => 100,
                'section' => 'styling',
                'ext' => '%',
                'refresh_on_change' => true,
                'affect_on_change_el' => '.met_overlay_wrapper',
                'affect_on_change_rule' => 'width',
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
            lc_general('.met_content_box', '', array('background-color' => ''), 'Box'),

            // Box Paddings
            lc_paddings('.met_content_box_contents', '', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

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

            // Content Paddings
            lc_paddings('.met_content_box_contents_text', 'Content', array('t' => '', 'r' => '', 'b' => '', 'l' => '30')),

            // Title
            lc_general('.met_content_box_contents h4', 'Title', array('color' => '','font-size' => '36','line-height' => '39','font-weight' => '')),

            // Sub Title
            lc_general('.met_content_box_contents h5', 'Sub Title', array('color' => '','font-size' => '18','line-height' => '19','font-weight' => '')),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '#FFFFFF')),

            // Image Borders
            lc_borders('.met_content_box_contents > img', 'Image', array(), array(), '0', '#E8E6E1', 'solid' ),

            // Border Radius
            lc_borderRadius('.met_content_box_contents > img', 'Image'),

            // Icons
            lc_general('.met_overlay a', 'Icons', array('background-color' => '', 'background-color:hover' => '', 'color' => '', 'color:hover' => '', 'font-size' => '20', 'width,height,line-height' => '50')),

            // Icons Border Radius
            lc_borderRadius('.met_overlay a', 'Icons', '100'),

            // Countdown Boxes
            lc_general('figure', 'Countdown Box', array('background-color' => '')),

            // Countdown Boxes Border Radius
            lc_borderRadius('figure', 'Countdown Box', '5'),

            // Countdown Numbers
            lc_general('figcaption > span:first-child', 'Countdown Numbers', array('color' => '','font-size' => '29','line-height' => '30','font-weight' => '600')),

            // Countdown Labels
            lc_general('figcaption > span:last-child', 'Countdown Labels', array('color' => '','font-size' => '11','line-height' => '12','font-weight' => '600'))
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

        $args = array(
            'posts_per_page' => 1,
            'p' => $options['pid'],
            'post_type' => 'any');
        $dslc_query = new WP_Query($args);

        $postInfo = array();

        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

        if ( $dslc_query->have_posts() ){
            while ( $dslc_query->have_posts() ) : $dslc_query->the_post();

                $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                $thumb_url = $thumb_url[0];
                $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);

                if( empty($thumb_url) || !in_array( 'image', $elements )){$thumbnail_size = 0;}else{$thumbnail_size = intval($options['thumbnail_size']);}
                $lbExists = !empty($thumb_url);

                $postInfo['end'] = tribe_get_start_date(null,true,'Y-m-d H:i:s');

                $asyncScripts = "[]";
                if( !empty($postInfo['end']) ){
                    if ( $dslc_is_admin ){
                        $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.counteverest.min.js"]';
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

                $elID = uniqid('eventbox2_'); ?>

                <div id="<?php echo $elID; ?>" class="met_content_box <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
                    <?php if( in_array( 'head_title', $elements ) || in_array( 'view_all', $elements ) || in_array( 'icon', $elements ) ) : ?>
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

                        <div class="met_content_box_contents clearfix">
                            <?php if( in_array( 'image', $elements ) && $options['thumbnail_position'] == 'left' ) : ?>
                                <div class="met_overlay_wrapper">
                                    <img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>">
                                    <?php if( in_array( 'image_overlay', $elements ) ) : ?>
                                        <div class="met_overlay">
                                            <div>
                                                <?php if( $lbExists ): ?>
                                                    <a href="<?php echo $thumb_url; ?>" rel="lb_<?php echo $elID; ?>"><i class="dslc-icon dslc-icon-<?php echo $options['lightbox_icon']; ?>"></i></a>
                                                <?php endif; ?>

                                                <a href="<?php the_permalink(); ?>"><i class="dslc-icon dslc-icon-<?php echo $options['link_icon']; ?>"></i></a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if( in_array( 'title', $elements ) || in_array( 'content', $elements ) ) : ?>
                            <div class="met_content_box_contents_text clearfix" style="width: <?php echo 100 - $thumbnail_size;  ?>%;">
                                <?php if( in_array( 'title', $elements ) ) : ?>
                                    <h4 style="<?php echo !in_array( 'sub_title', $elements ) ? 'margin-bottom: 15px' : ''; ?>"><?php the_title(); ?></h4>
                                <?php endif; ?>
                                <?php if( in_array( 'sub_title', $elements ) ) : ?>
                                    <h5 class="dslca-editable-content met_color" style="margin-bottom: 15px" <?php if ( $dslc_is_admin ) echo 'contenteditable data-id="sub_title" data-type="simple"'; ?>><?php echo stripslashes($options['sub_title']); ?></h5>
                                <?php endif; ?>

                                <?php if( in_array( 'content', $elements ) ) : ?>
                                    <div style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>" class="met_p">
                                        <?php echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if( isset($countDownID) && in_array( 'countdown', $elements ) ): ?>
                                    <div class="met_event_box_remaining countdown clearfix" id="<?php echo $countDownID; ?>">
                                        <figure class="met_bgcolor met_vcenter">
                                            <figcaption>
                                                <span class="ce-days"></span> <span class="ce-days-label"></span>
                                            </figcaption>
                                        </figure>
                                        <figure class="met_bgcolor met_vcenter">
                                            <figcaption>
                                                <span class="ce-hours"></span> <span class="ce-hours-label"></span>
                                            </figcaption>
                                        </figure>
                                        <figure class="met_bgcolor met_vcenter">
                                            <figcaption>
                                                <span class="ce-minutes"></span> <span class="ce-minutes-label"></span>
                                            </figcaption>
                                        </figure>
                                        <figure class="met_bgcolor met_vcenter">
                                            <figcaption>
                                                <span class="ce-seconds"></span> <span class="ce-seconds-label"></span>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["setCountDown|<?php echo $countDownID ?>"],arr);});</script>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <?php if( in_array( 'image', $elements ) && $options['thumbnail_position'] == 'right' ) : ?>
                                <div style="float: right;" class="met_overlay_wrapper">
                                    <img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>">
                                    <?php if( in_array( 'image_overlay', $elements ) ) : ?>
                                        <div class="met_overlay">
                                            <div>
                                                <?php if( $lbExists ): ?>
                                                    <a href="<?php echo $thumb_url; ?>" rel="lb_<?php echo $elID; ?>"><i class="dslc-icon dslc-icon-<?php echo $options['lightbox_icon']; ?>"></i></a>
                                                <?php endif; ?>

                                                <a href="<?php the_permalink(); ?>"><i class="dslc-icon dslc-icon-<?php echo $options['link_icon']; ?>"></i></a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
                <?php if( $lbExists ): ?><script>jQuery(document).ready(function(){<?php if( $dslc_is_admin ): ?>CoreJS.lightbox();<?php endif; ?>});</script><?php endif; ?>
                <?php echo $met_shared_options['script']; ?>
            <?php endwhile;
        }else{

            if ( $dslc_is_admin ) :
                ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any post associated with this ID at the moment. Go to <strong>WP Admin</strong> to add some or make sure you get the right ID number. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
            endif;

        }
        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}