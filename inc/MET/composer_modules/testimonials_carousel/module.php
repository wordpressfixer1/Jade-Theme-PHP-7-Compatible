<?php

// Register Module
function register_testicara_module() {
    return dslc_register_module( "MET_TestimonialsCarousel" );
}
add_action('dslc_hook_register_modules','register_testicara_module');

class MET_TestimonialsCarousel extends DSLC_Module {

    var $module_id = 'MET_TestimonialsCarousel';
    var $module_title = 'Simple Carousel';
    var $module_icon = 'info';
    var $module_category = 'met - testimonials';

    function options() {

        $cats = get_terms( 'dslc_testimonials_cats' );
        $cats_choices = array();

        if ( $cats ) {
            foreach ( $cats as $cat ) {
                $cats_choices[] = array(
                    'label' => $cat->name,
                    'value' => $cat->slug
                );
            }
        }

        $dslc_options = array(
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'quote nav',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Quote', 'dslc_string' ),
                        'value' => 'quote'
                    ),
                    array(
                        'label' => __( 'Navigation', 'dslc_string' ),
                        'value' => 'nav'
                    ),
                )
            ),
            array(
                'label' => __( 'Testimonials Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '10',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Categories', 'dslc_string' ),
                'id' => 'categories',
                'std' => '',
                'type' => 'checkbox',
                'choices' => $cats_choices
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
        );

       $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_paddings('.met_testimonials_item', '', array('t' => '10', 'r' => '0', 'b' => '100', 'l' => '0')),

            // Content
            lc_general('article', 'Content', array('color' => '#333333', 'font-size' => '18', 'line-height' => '24', 'font-weight' => '400')),

           // Work
           lc_general('.met_testimonials_item_id', 'Work', array('color' => '#333333', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400')),

           // Name
           lc_general('.met_testimonials_item_id span', 'Name', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400'))
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

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();

        // General args
        $args = array(
            'post_type' => 'dslc_testimonials',
            'posts_per_page' => $options['amount'],
            'order' => $options['order'],
            'orderby' => $options['orderby'],
            'offset' => $options['offset']
        );

        // Category args
        if ( isset( $options['categories'] ) && $options['categories'] != '' ) {

            $cats_array = explode( ' ', trim( $options['categories'] ));

            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'dslc_testimonials_cats',
                    'field' => 'slug',
                    'terms' => $cats_array
                )
            );

        }

        // Do the query
        $dslc_query = new WP_Query( $args );

        $elementID = uniqid('testimonialscarousel_');
        if ( $dslc_query->have_posts() ){ ?>
        <!-- Testimonials Starts -->
        <div id="<?php echo $elementID; ?>" class="met_testimonials met_testimonials_carousel clearfix">
            <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
                <div class="met_testimonials_item met_textcenter">
                <?php if( in_array( 'quote', $elements ) ) : ?>
                    <span class="quote">“</span>
                <?php endif; ?>
                    <article><?php the_content(); ?></article>
                    <p>&nbsp;</p>
                    <div class="met_testimonials_item_id"><span class="met_color"><?php the_title(); ?></span> / <?php echo get_post_meta( get_the_ID(), 'dslc_testimonial_author_pos', true ); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php if( in_array( 'nav', $elements ) ) : ?>
        <nav class="met_testimonials_controls"><a href="#"><i class="dslc-icon dslc-icon-angle-left"></i></a><a href="#"><i class="dslc-icon dslc-icon-angle-right"></i></a></nav>
        <?php endif; ?>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["testimonialsRotator|<?php echo $elementID ?>"]);});</script>
    <?php }else{
            if ( $dslc_is_admin ) : ?>
                <div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any testimonials at the moment. Go to <strong>WP Admin &rarr; Testimonials</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div>
            <?php endif;
        }
        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}
