<?php

// Register Module
function register_titlecara_module() {
    return dslc_register_module( "MET_TitleCarousel" );
}
add_action('dslc_hook_register_modules','register_titlecara_module');

class MET_TitleCarousel extends DSLC_Module {

    var $module_id = 'MET_TitleCarousel';
    var $module_title = 'Title Rotation';
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
                'std' => 'EDIT TITLE',
                'type' => 'text',
                'visibility' => 'hidden'
            ),

            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'title',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                )
            ),
            array(
                'label' => __( 'Carousel Speed in ms', 'dslc_string' ),
                'id' => 'carousel_speed',
                'std' => '1000',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Carousel Pause Time in ms', 'dslc_string' ),
                'id' => 'carousel_pause_time',
                'std' => '5000',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Title URL', 'dslc_string' ),
                'id' => 'title_link',
                'std' => '',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Posts Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '10',
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
                'label' => __( 'Open Links in', 'dslc_string' ),
                'id' => 'target',
                'std' => '_blank',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'New Page', 'dslc_string' ),
                        'value' => '_blank'
                    ),
                    array(
                        'label' => __( 'Same Page', 'dslc_string' ),
                        'value' => '_self'
                    )
                )
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_title_rotator', '', array('background-color' => '')),

            // Title
            lc_general('.met_title_rotator_title', 'Title', array('background-color' => '', 'background-color:hover' => '', 'color' => '', 'color:hover' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400')),

            // Title Paddings
            lc_paddings('.met_title_rotator_title', 'Title', array('t' => '', 'r' => '20', 'b' => '', 'l' => '20')),

            // Links
            lc_general('.met_title_rotator > div a', 'Links', array('color' => '', 'color:hover' => '', 'font-size' => '14', 'line-height' => '50'))
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

        $elementID = uniqid('titlecarousel_');

        $titleOpener = 'span';
        $titleClosure = 'span';
        if( !empty($options['title_link']) ){
            $titleOpener = 'a href="'.$options['title_link'].'" target="'.$options['target'].'"';
            $titleClosure = 'a';
        }
        ?>
        <div id="<?php echo $elementID ?>" class="met_title_rotator met_bgcolor clearfix" data-speed="<?php echo $options['carousel_speed'] ?>" data-pausetime="<?php echo $options['carousel_pause_time'] ?>">
            <?php if( in_array( 'title', $elements ) ) : ?>
                <?php if( $dslc_is_admin ): ?>
                    <<?php echo $titleOpener; ?> class="met_vcenter met_title_rotator_title"><span class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></span></<?php echo $titleClosure; ?>>
                <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                    <<?php echo $titleOpener; ?> class="met_vcenter met_title_rotator_title"><span><?php echo stripslashes($options['title']); ?></span></<?php echo $titleClosure; ?>>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ( $dslc_query->have_posts() ): ?>
            <div class="met_title_rotator_el_wrap">
                <div class="met_title_rotator_el">
                <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
                    <figure><a href="<?php the_permalink(); ?>" target="<?php echo $options['target']; ?>"><?php the_title(); ?></a></figure>
                <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["linkRotator|<?php echo $elementID ?>"]);});</script>
        <?php
        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );
    }

}