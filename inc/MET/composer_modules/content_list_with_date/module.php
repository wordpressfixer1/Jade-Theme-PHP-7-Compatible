<?php
// Register Module
function register_contentlistdate_module() {
    return dslc_register_module( "MET_ContentListWithDate" );
}
add_action('dslc_hook_register_modules','register_contentlistdate_module');

class MET_ContentListWithDate extends DSLC_Module {

    var $module_id = 'MET_ContentListWithDate';
    var $module_title = 'Calendar Like';
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
                'id' => 'title',
                'std' => 'Edit Title',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Sub Title', 'dslc_string' ),
                'id' => 'sub_title',
                'std' => 'Edit Sub Title',
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
                'std' => '20',
                'type' => 'text'
            )
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Head Title
            lc_general('h2', 'Head Title', array('color' => '#000000','font-size' => '32', 'line-height' => '40', 'font-weight' => '400')),

            // Head Sub Title
            lc_general('.met_title_with_subtitle span', 'Head Sub Title', array('color' => '#9B9B9B','font-size' => '24', 'line-height' => '40', 'font-weight' => '400')),

            // Post Title
            lc_general('h4', 'Post Title', array('color' => '','font-size' => '18', 'line-height' => '22', 'font-weight' => '400')),

            // Post Content
            lc_general('.met_p', 'Post Content', array('color' => '','font-size' => '14', 'line-height' => '22', 'font-weight' => '400'))
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

?>
        <header class="met_title_with_subtitle">
            <h2 <?php if ( $dslc_is_admin ) echo 'contenteditable class="dslca-editable-content" data-id="title" data-type="simple"'; ?>><?php echo stripslashes($options['title']); ?></h2>
            <span <?php if ( $dslc_is_admin ) echo 'contenteditable class="dslca-editable-content" data-id="sub_title" data-type="simple"'; ?>><?php echo stripslashes($options['sub_title']); ?></span>
        </header>
        <?php
        if ( $dslc_query->have_posts() ){
            while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
        ?>
            <!-- Blog Item Start -->
            <div class="clearfix met_blog_item">
                <div class="met_blog_item_date">
                    <div class="met_blog_item_date_day_month met_vcenter">
                        <div><?php the_time( 'j' ); ?><span><?php the_time( 'M' ); ?></span></div>
                    </div>
                    <div class="met_blog_item_date_year"><?php the_time( 'Y' ); ?></div>
                </div>

                <a href="<?php the_permalink(); ?>"><h4 class="met_color2"><?php the_title(); ?></h4></a>
                <div class="met_p"><?php echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ); ?></div>
            </div><!-- Blog Item End -->
        <?php
            endwhile;
        }else{
            if ( $dslc_is_admin ) :
                ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any posts at the moment. Go to <strong>WP Admin</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
            endif;
        }

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}
