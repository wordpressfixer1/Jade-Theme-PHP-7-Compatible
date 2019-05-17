<?php

// Register Module
function register_onepost_module() {
    return dslc_register_module( "MET_OnePost" );
}
add_action('dslc_hook_register_modules','register_onepost_module');

class MET_OnePost extends DSLC_Module {

    var $module_id = 'MET_OnePost';
    var $module_title = 'Single with Image';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'Title', 'dslc_string' ),
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

            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'head head_title view_all icon image response_bar title date categories content',
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
                        'label' => __( 'Response Bar', 'dslc_string' ),
                        'value' => 'response_bar'
                    ),
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Date', 'dslc_string' ),
                        'value' => 'date'
                    ),
                    array(
                        'label' => __( 'Categories', 'dslc_string' ),
                        'value' => 'categories'
                    ),
                    array(
                        'label' => __( 'Content', 'dslc_string' ),
                        'value' => 'content'
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
                'label' => __( 'View All Link', 'dslc_string' ),
                'id' => 'view_all_link',
                'std' => '#',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
                'id' => 'excerpt_length',
                'std' => '20',
                'type' => 'text'
            ),

            /**
             * Image Options
             */
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
             * Response Bar
             */
            array(
                'label' => __( 'Position Top', 'dslc_string' ),
                'id' => 'bar_pos_top',
                'std' => '',
                'type' => 'text',
                'section' => 'styling',
                'tab' => __( 'Response Bar', 'dslc_string' )
            ),
            array(
                'label' => __( 'Position Right', 'dslc_string' ),
                'id' => 'bar_pos_right',
                'std' => '5',
                'type' => 'text',
                'section' => 'styling',
                'tab' => __( 'Response Bar', 'dslc_string' )
            ),
            array(
                'label' => __( 'Position Bottom', 'dslc_string' ),
                'id' => 'bar_pos_bottom',
                'std' => '19',
                'type' => 'text',
                'section' => 'styling',
                'tab' => __( 'Response Bar', 'dslc_string' )
            ),
            array(
                'label' => __( 'Position Left', 'dslc_string' ),
                'id' => 'bar_pos_left',
                'std' => '',
                'type' => 'text',
                'section' => 'styling',
                'tab' => __( 'Response Bar', 'dslc_string' )
            ),

        );

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_content_box', '', array('background-color' => ''), 'Box'),

            // Head Background Color
            lc_general('.met_content_box header', 'Head', array('background-color' => '')),

            // Head Fonts
            lc_general('.met_content_box header span', 'Head', array('color' => '','font-size' => '19','line-height' => '25'), 'Title'),

            // Head View All Fonts
            lc_general('.met_content_box header a', 'Head', array('color' => '', 'color:hover' => '','font-size' => '12','line-height' => '25'), 'View All'),

            // Head Paddings
            lc_paddings('.met_content_box header', 'Head', array('t' => '15', 'r' => '30', 'b' => '15', 'l' => '30')),

            // Icon
            lc_general('.met_content_box header i', 'Icon', array('icon' => 'html5', 'color' => '','font-size' => '25', 'line-height' => '25')),

            // Image Borders
            lc_borders('.met_content_box section>a>img', 'Image', array(), array(), '10', '#E8E6E1', 'solid' ),

            // Image Border Radius
            lc_borderRadius('.met_content_box section>a>img', 'Image'),

            // Response Bar
            lc_general('.met_content_box_image_overlay', 'Response Bar', array('background-color' => '', 'color' => '', 'font-size' => '12', 'line-height' => '35')),

            // Title
            lc_general('.met_h4_title', 'Title', array('color' => '', 'color:hover' => '', 'font-size' => '18', 'line-height' => '19')),

            // Date
            lc_general('.p_date', 'Date', array('color' => '', 'color:hover' => '', 'font-size' => '12', 'line-height' => '14')),

            // Categories
            lc_general('.p_cats', 'Categories', array('color' => '', 'color:hover' => '', 'font-size' => '12', 'line-height' => '14')),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '#FFFFFF')),

            // Content Paddings
            lc_paddings('.met_content_box_contents', 'Content', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30'))
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

        $responseBarPos = '';
        if( empty($options['bar_pos_top'])      ): $responseBarPos .= 'top: auto;';     else: $responseBarPos .= 'top: '.$options['bar_pos_top'].'px;'; endif;
        if( empty($options['bar_pos_right'])    ): $responseBarPos .= 'right: auto;';   else: $responseBarPos .= 'right: '.$options['bar_pos_right'].'px;'; endif;
        if( empty($options['bar_pos_bottom'])   ): $responseBarPos .= 'bottom: auto;';  else: $responseBarPos .= 'bottom: '.$options['bar_pos_bottom'].'px;'; endif;
        if( empty($options['bar_pos_left'])     ): $responseBarPos .= 'left: auto;';    else: $responseBarPos .= 'left: '.$options['bar_pos_left'].'px;'; endif;
        if( $responseBarPos != '' ) $responseBarPos = 'style="'.$responseBarPos.'"';

        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

        $args = array(
            'posts_per_page' => 1,
            'p' => $options['pid'],
            'post_type' => 'any');
        $dslc_query = new WP_Query($args);

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
            <?php
                if ( $dslc_query->have_posts() ){
                    while ( $dslc_query->have_posts() ) : $dslc_query->the_post();

                        $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                        $thumb_url = $thumb_url[0];

                        if( in_array( 'image', $elements ) && !empty($thumb_url) ) :
                            $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']); ?>
                            <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>

                        <?php if( in_array( 'response_bar', $elements ) ) : ?>
                            <span <?php echo $responseBarPos; ?> class="met_content_box_image_overlay"><?php comments_number( 'No Responses', 'One Response', '% Responses' ); ?></span>
                        <?php endif; ?>

                        <?php echo isset($resizedImage['url']) ? '</a>' : ''; ?>

                        <div class="met_content_box_contents">
                            <?php if( in_array( 'title', $elements ) ) : ?>
                                <a href="<?php the_permalink(); ?>" class="met_h4_title met_color_transition2"><?php the_title(); ?></a>
                            <?php endif; ?>

                            <?php if( in_array( 'date', $elements ) || in_array( 'categories', $elements ) ) : ?>
                                <div class="met_blog_misc_subtitle">
                                    <?php if( in_array( 'date', $elements ) ) : ?>
                                    <a href="#" class="met_color2 p_date"><?php the_time( get_option( 'date_format' ) ); ?></a>
                                    <?php endif; ?>
                                    <?php if( in_array( 'date', $elements ) && in_array( 'categories', $elements ) ) : ?>
                                    on
                                    <?php endif; ?>
                                    <?php if( in_array( 'categories', $elements ) ) :
                                        $categories = custom_taxonomies_terms_links(get_the_ID(), 'class="met_color2 p_cats"');
                                        echo implode(',',$categories);
                                    endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if( in_array( 'content', $elements ) ) : ?>
                                <div class="met_p" style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>"><?php echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ); ?></div>
                            <?php endif; ?>
                        </div>
            </section>
            <?php
                    endwhile;
                }else{

                    if ( $dslc_is_admin ) :
                        ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any post associated with this ID at the moment. Go to <strong>WP Admin</strong> to add some or make sure you get the right ID number. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
                    endif;

                }
            ?>
        </div>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}