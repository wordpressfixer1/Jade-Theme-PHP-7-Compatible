<?php
// Register Module
function register_windmillcara_module() {
    return dslc_register_module( "MET_WindmillCarousel" );
}
add_action('dslc_hook_register_modules','register_windmillcara_module');

class MET_WindmillCarousel extends DSLC_Module {

    var $module_id = 'MET_WindmillCarousel';
    var $module_title = 'Windmill';
    var $module_icon = 'info';
    var $module_category = 'met - post carousels';

    function options() {

        $post_type_categoryArgs = categoryArgs('', '', 1);

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'Title', 'dslc_string' ),
                'id' => 'title',
                'std' => 'Edit Title',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Content', 'dslc_string' ),
                'id' => 'content',
                'std' => 'Integer id tincidunt diam. Cras massa dui, lobortis vel nulla viverra, porttitor facilisis turpis.',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Posts Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '9',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Post Type', 'dslc_string' ),
                'id' => 'post_type',
                'std' => $post_type_categoryArgs[0]['value'],
                'type' => 'select',
                'choices' => $post_type_categoryArgs
            ),
            array(
                'label' => __( 'Category IDs [Seperate with "," Comma]', 'dslc_string' ),
                'id' => 'category_ids',
                'std' => '',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Order By', 'dslc_string' ),
                'id' => 'orderby',
                'std' => 'date',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Publish Date', 'dslc_string' ),
                        'value' => 'date'
                    ),
                    array(
                        'label' => __( 'Modified Date', 'dslc_string' ),
                        'value' => 'modified'
                    ),
                    array(
                        'label' => __( 'Random', 'dslc_string' ),
                        'value' => 'rand'
                    ),
                    array(
                        'label' => __( 'Alphabetic', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Comment Count', 'dslc_string' ),
                        'value' => 'comment_count'
                    ),
                )
            ),
            array(
                'label' => __( 'Order', 'dslc_string' ),
                'id' => 'order',
                'std' => 'DESC',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Ascending', 'dslc_string' ),
                        'value' => 'ASC'
                    ),
                    array(
                        'label' => __( 'Descending', 'dslc_string' ),
                        'value' => 'DESC'
                    )
                )
            ),
            array(
                'label' => __( 'Offset', 'dslc_string' ),
                'id' => 'offset',
                'std' => '0',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
                'id' => 'excerpt_length',
                'std' => '20',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '185',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '268',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '286',
                'type' => 'text',
                'visibility' => 'hidden'
            ),



            /**
             * Carousel Options
             */
            array(
                'label' => __( 'Autoplay time in Milliseconds', 'dslc_string' ),
                'id' => 'autoplay_time',
                'std' => '0',
                'type' => 'text',
                'section' => 'styling',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Autoplay Direction', 'dslc_string' ),
                'id' => 'autoplay_direction',
                'std' => 'next',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Next',
                        'value' => 'next',
                    ),
                    array(
                        'label' => 'Previous',
                        'value' => 'previous',
                    ),
                ),
                'section' => 'styling',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
            array(
                'label' => __( 'Text Content Position', 'dslc_string' ),
                'id' => 'text_content_position',
                'std' => 'BR',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Top Left',
                        'value' => 'TL',
                    ),
                    array(
                        'label' => 'Top Right',
                        'value' => 'TR',
                    ),
                    array(
                        'label' => 'Bottom Left',
                        'value' => 'BL',
                    ),
                    array(
                        'label' => 'Bottom Right',
                        'value' => 'BR',
                    ),
                ),
                'section' => 'styling',
                'tab' => __( 'Carousel Options', 'dslc_string' ),
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_windmill_carousel', '', array('background-color' => '')),

			// Content Paddings
			lc_paddings('article', 'Content Box', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

            // Head Fonts
            lc_general('article h4', 'Title', array('color' => '','font-size' => '18','line-height' => '19'), 'Title'),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '#FFFFFF'),'Content'),
			lc_paddings('.met_p', 'Content', array('t' => '0', 'r' => '0', 'b' => '10', 'l' => '0')),

            // Lightbox Icon
            lc_general('.met_lb_icon>i', 'Lightbox Icon', array('icon' => 'search')),

            lc_general('.met_lb_icon', 'Lightbox Icon', array('background-color' => '', 'background-color:hover' => '', 'color' => '', 'color:hover' => '', 'font-size' => '20', 'line-height,width,height' => '50')),

            // Lightbox Icon Border Radius
            lc_borderRadius('.met_lb_icon', 'Lightbox Icon', '100'),

            // Link Icon
            lc_general('.met_link_icon>i', 'Link Icon', array('icon' => 'link')),

            lc_general('.met_link_icon', 'Link Icon', array('background-color' => '', 'background-color:hover' => '', 'color' => '', 'color:hover' => '', 'font-size' => '20', 'line-height,width,height' => '50')),

            // Link Icon Border Radius
            lc_borderRadius('.met_link_icon', 'Link Icon', '100'),

            // Navigation Prev
            lc_general('nav a:first-child', 'Navigation', array('background-color' => '', 'background-color:hover' => '', 'color' => '', 'color:hover' => '', 'font-size' => '12', 'line-height,width,height' => '35'), 'Previous'),

            // Navigation Next
            lc_general('nav a:last-child', 'Navigation', array('background-color' => '', 'background-color:hover' => '', 'color' => '', 'color:hover' => '', 'font-size' => '12', 'line-height,width,height' => '35'), 'Next')

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
        if ( $dslc_is_admin ){
            $asyncScripts = '["'.get_template_directory_uri().'/js/imagesLoaded.js","'.get_template_directory_uri().'/js/jquery.windmillCarousel.js"]';

            echo '<link rel="stylesheet" id="metcreative-windmillCarousel-css"  href="'.get_template_directory_uri().'/css/jquery.windmillCarousel.css'.'" type="text/css" media="all" />';
        }else{
            wp_enqueue_script('metcreative-imagesLoaded');
            wp_enqueue_script('metcreative-windmillCarousel');
            wp_enqueue_style('metcreative-windmillCarousel');
        }


        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

        // General args
        $args = array(
            'post_type' => $options['post_type'],
            'posts_per_page' => $options['amount'],
            'order' => $options['order'],
            'orderby' => $options['orderby'],
            'offset' => $options['offset']
        );

        // Category args
        $args = array_merge($args, categoryArgs($options['post_type'], $options['category_ids']));

        // Do the query
        $dslc_query = new WP_Query( $args );
        ?>

        <?php if ( $dslc_query->have_posts() ){ $elementID = uniqid('carousel_'); ?>
            <div id="<?php echo $elementID ?>" class="met_windmill_carousel clearfix" data-textcontentposition="<?php echo $options['text_content_position'] ?>" data-autoplaytime="<?php echo $options['autoplay_time'] ?>" data-autoplaydirection="<?php echo $options['autoplay_direction'] ?>">
                <?php
                while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
                    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    $thumb_url = $thumb_url[0];
                    if(!empty($thumb_url)):
                        ?>
                        <div class="met_windmill_carousel_item met_overlay_wrapper">
                            <?php $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']); ?>
                            <img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>"/>
                            <div class="met_overlay">
                                <div>
                                    <a class="met_lb_icon" href="<?php echo $thumb_url; ?>" rel="lb_recentworks" title="<?php the_title(); ?> <?php echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ); ?>"><i class="dslc-icon dslc-icon-<?php echo $options['met_lb_icon_i_icon']; ?>"></i></a>
                                    <a class="met_link_icon" href="<?php the_permalink(); ?>"><i class="dslc-icon dslc-icon-<?php echo $options['met_link_icon_i_icon']; ?>"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endif;
                endwhile;
                ?>

            <article>
                <?php if( $dslc_is_admin ): ?>
                    <h4 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></h4>
                <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                    <h4><?php echo stripslashes($options['title']); ?></h4>
                <?php endif; ?>

                <?php if( $dslc_is_admin ): ?>
                    <div style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>" class="met_p hidden-360 dslca-editable-content" data-type="simple" data-id="content" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['content']); ?></div>
                <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                    <div style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>" class="met_p hidden-360"><?php echo stripslashes($options['content']); ?></div>
                <?php endif; ?>

                <nav>
                    <a href="#" class="met_windmill_carousel_prev"><i class="dslc-icon dslc-icon-chevron-left"></i></a>
                    <a href="#" class="met_windmill_carousel_next"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
                </nav>
            </article>
        </div>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["windmillCarouselTrigger|<?php echo $elementID ?>"]);});</script>
        <?php }else{
            if ( $dslc_is_admin ) :
                ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any posts at the moment. Go to <strong>WP Admin</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
            endif;
        }
        ?>
        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}