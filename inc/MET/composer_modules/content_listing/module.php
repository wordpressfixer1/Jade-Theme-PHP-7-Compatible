<?php

// Register Module
function register_contentlisting_module() {
    return dslc_register_module( "MET_ContentListing" );
}
add_action('dslc_hook_register_modules','register_contentlisting_module');

class MET_ContentListing extends DSLC_Module {

    var $module_id = 'MET_ContentListing';
    var $module_title = 'Vertical List with Image';
    var $module_icon = 'pencil';
    var $module_category = 'met - post grids';

    function options() {

		$post_type_categoryArgs = categoryArgs('', '', 1);

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
            array(
                'label' => __( 'Posts Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '3',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Post Type', 'dslc_string' ),
                'id' => 'post_type',
                'std' => $post_type_categoryArgs[0]['value'],
                'type' => 'select',
                'choices' => categoryArgs('', '', 1)
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
                'std' => '10',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '70',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '70',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '70',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Read More Text', 'dslc_string' ),
                'id' => 'read_more_text',
                'std' => 'Read More',
                'type' => 'text'
            ),

            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'head head_title view_all icon image title date content read_more',
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
                        'label' => __( 'Date', 'dslc_string' ),
                        'value' => 'date'
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
             * Head
             */
            array(
                'label' => __( 'View All Link', 'dslc_string' ),
                'id' => 'view_all_link',
                'std' => '#',
                'type' => 'text'
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Box Paddings
            lc_paddings('.met_latest_blog_box', '', '30'),

            // Box
            lc_general('.met_content_box', '', array('background-color' => ''), 'Box'),

            // Image
            lc_general('.met_latest_blog_box_preview,.met_latest_blog_box_preview img', '', array('float' => 'left'), 'Image'),

            // Head Background Color
            lc_general('.met_content_box header', 'Head', array('background-color' => '')),

            // Head Fonts
            lc_general('.met_content_box header span', 'Head', array('color' => '','font-size' => '19', 'line-height' => '25'), 'Title'),

            // Head View All Fonts
            lc_general('.met_content_box header a', 'Head', array('color' => '','color:hover' => '','font-size' => '12','line-height' => '25'), 'View All'),

            // Head Paddings
            lc_paddings('.met_content_box header', 'Head', array('t' => '15', 'r' => '30', 'b' => '15', 'l' => '30')),

            // Icon
            lc_general('.met_content_box header i', 'Icon', array('icon' => 'html5', 'color' => '','font-size' => '25', 'line-height' => '25')),

            // Image Borders
            lc_borders('.met_content_box section img', 'Image', array(), array(), '0', '#E8E6E1', 'solid' ),

            // Image Border Radius
            lc_borderRadius('.met_content_box section img', 'Image'),

            // Date
            lc_general('.met_latest_blog_box_date', 'Date', array('color' => '', 'font-size' => '11', 'line-height' => '18')),

            // Title
            lc_general('.met_latest_blog_box_title', 'Title', array('color' => '', 'color:hover' => '', 'font-size' => '14', 'line-height' => '16')),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '12', 'line-height' => '18', 'text-shadow' => '#FFFFFF')),

            // Read More
            lc_general('.met_latest_blog_box_readmore', 'Read More', array('color' => '', 'color:hover' => '','font-size' => '12','line-height' => '22'))
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

        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

        // Fix for pagination
        if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

        // General args
        $args = array(
            'paged' => $paged,
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

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();
?>

        <div class="met_content_box">
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
                ?>
                        <div class="met_latest_blog_box clearfix">
                            <?php
                                $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                                $thumb_url = $thumb_url[0];

                                if( in_array( 'image', $elements ) && !empty($thumb_url) ) :
                                    $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                            ?>
                            <a href="<?php the_permalink(); ?>" class="met_latest_blog_box_preview"><img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>"></a>
                                <?php endif; ?>
                            <div class="met_latest_blog_contents clearfix" <?php if(!empty($thumb_url)): ?>style="margin-<?php echo $options['met_latest_blog_box_preview_float'] == 'right' ? 'right:' : 'left:'; echo $options["thumb_resize_width_manual"] + 10 ?>px;"<?php endif; ?>>
                                <?php if( in_array( 'title', $elements ) ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="met_latest_blog_box_title met_color2"><?php the_title(); ?> </a>
                                <?php endif; ?>
                                <?php if( in_array( 'content', $elements ) ) : ?>
                                    <div class="met_p" style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow']; ?>"><?php echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ); ?></div>
                                <?php endif; ?>
                                <?php if( in_array( 'date', $elements ) ) : ?>
                                    <span class="met_latest_blog_box_date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                                <?php endif; ?>
                                <?php if( in_array( 'read_more', $elements ) ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="met_latest_blog_box_readmore"><?php echo $options['read_more_text'] ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                <?php
                    endwhile;
                }else{
                    if ( $dslc_is_admin ) :
                        ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any blog posts at the moment. Go to <strong>WP Admin &rarr; Posts</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
                    endif;
                }
                ?>
            </section>
        </div>

        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}