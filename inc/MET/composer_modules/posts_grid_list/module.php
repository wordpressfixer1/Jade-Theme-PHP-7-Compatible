<?php

// Register Module
function register_postgridlist_module() {
    return dslc_register_module( "MET_PostsGridList" );
}
add_action('dslc_hook_register_modules','register_postgridlist_module');

class MET_PostsGridList extends DSLC_Module {

    var $module_id = 'MET_PostsGridList';
    var $module_title = 'Simple List';
    var $module_icon = 'pencil';
    var $module_category = 'met - post grids';

    function options() {

        $post_type_categoryArgs = categoryArgs('', '', 1);

        $dslc_options = array(
            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'head_title head_sub_title image title sub_title',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Image', 'dslc_string' ),
                        'value' => 'image'
                    ),
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Sub Title', 'dslc_string' ),
                        'value' => 'sub_title'
                    ),
                )
            ),

            array(
                'label' => __( 'Posts Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '5',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Posts Per Row', 'dslc_string' ),
                'id' => 'columns',
                'std' => '3',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => '6',
                        'value' => '2',
                    ),
                    array(
                        'label' => '4',
                        'value' => '3',
                    ),
                    array(
                        'label' => '3',
                        'value' => '4',
                    ),
                    array(
                        'label' => '2',
                        'value' => '6',
                    ),
                    array(
                        'label' => '1',
                        'value' => '12',
                    ),
                ),
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
                'std' => '25',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '210',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '210',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '210',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Title
            lc_general('.met_posts_grid_item_title', 'Title', array('color' => '', 'color:hover' => '', 'font-size' => '20', 'line-height' => '22', 'font-weight' => '')),

            // Sub Title
            lc_general('.met_posts_grid_item_sub_title', 'Sub Title', array('color' => '', 'font-size' => '18', 'line-height' => '20', 'font-weight' => ''))
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

        <div class="met_posts_grid_list">
            <?php if ( $dslc_query->have_posts() ): ?>
                <div class="met_posts_grid row clearfix">
                    <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
                        <div class="met_posts_grid_item col-md-<?php echo $options['columns']; ?>">
                            <?php
                            $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                            $thumb_url = $thumb_url[0];

                            if( in_array( 'image', $elements ) && !empty($thumb_url) ) :
                                $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                                ?>
                                <a href="<?php the_permalink(); ?>" class="met_posts_grid_item_preview" title="<?php the_title(); ?>"><img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>"></a>
                            <?php endif; ?>
                            <?php if( in_array( 'title', $elements ) ) : ?>
                                <a href="<?php the_permalink(); ?>" class="met_posts_grid_item_title"><?php the_title(); ?></a>
                            <?php endif; ?>
                            <?php if( in_array( 'sub_title', $elements ) ) : ?>
                                <span class="met_color met_posts_grid_item_sub_title"><?php echo do_shortcode( wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ) ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}