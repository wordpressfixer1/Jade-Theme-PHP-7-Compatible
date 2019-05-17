<?php

// Register Module
function register_quotetestrotate_module() {
    return dslc_register_module( "MET_QuoteTestimonialsRotator" );
}
add_action('dslc_hook_register_modules','register_quotetestrotate_module');

class MET_QuoteTestimonialsRotator extends DSLC_Module {

    var $module_id = 'MET_QuoteTestimonialsRotator';
    var $module_title = 'Quote Rotator';
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

            lc_general('.met_content', '', array('background-color' => '')),

			lc_paddings('.met_content', 'Paddings', array('t' => '100', 'r' => '50', 'b' => '100', 'l' => '50')),

			lc_margins('.met_content', 'Margins', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

            // Quote
            lc_general('.met_quote_testimonials_quote', 'Comment', array('color' => '','font-size' => '30','line-height' => '35','font-weight' => '400', 'text-align' => 'center')),

            // Misc
            lc_general('.met_quote_testimonials_misc', 'Misc', array('color' => '','font-size' => '18','line-height' => '45','font-weight' => '400', 'text-align' => 'center'))
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

        $elementID = uniqid('quotetestimonialsrotator_');

        if ( $dslc_query->have_posts() ){
        ?>
        <div id="<?php echo $elementID; ?>" class="met_quote_testimonials_wrapper met_content">
            <div class="met_quote_testimonials_wrapper">
                <?php
                while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
                    ?>
                    <div class="met_quote_testimonials_item">
                        <div class="met_quote_testimonials_quote"><?php the_content(); ?></div>
                        <div class="met_quote_testimonials_misc met_color">- <?php the_title(); ?> / <?php echo get_post_meta( get_the_ID(), 'dslc_testimonial_author_pos', true ); ?></div>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
        </div>
        <a href="#" class="met_quote_testimonials_wrapper_nav prev"><i class="dslc-icon dslc-icon-chevron-left"></i></a>
        <a href="#" class="met_quote_testimonials_wrapper_nav next"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["quote_testimonials|<?php echo $elementID ?>"]);});</script>
        <?php }else{
            if ( $dslc_is_admin ) :
                ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any testimonials at the moment. Go to <strong>WP Admin &rarr; Testimonials</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
            endif;
        }

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}