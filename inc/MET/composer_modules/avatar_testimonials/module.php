<?php

// Register Module
function register_avatartesti_module() {
    return dslc_register_module( "MET_AvatarTestimonials" );
}
add_action('dslc_hook_register_modules','register_avatartesti_module');

class MET_AvatarTestimonials extends DSLC_Module {

    var $module_id = 'MET_AvatarTestimonials';
    var $module_title = 'Avatar List';
    var $module_icon = 'info';
    var $module_category = 'met - testimonials';

    function options() {

        $dslc_options = array(
            array(
                'label' => __( 'Testimonials Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '17',
                'type' => 'text',
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
				'std' => '35',
				'type' => 'text',
				'tab' => 'Excerpt'
			),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Image
            lc_general('.met_testimonial_3:after', 'Image', array('background-color' => '')),

            // Title
            lc_general('.met_testimonial_3_messages h4', 'Title', array('color' => '','font-size' => '18','line-height' => '19')),

            // Content
            lc_general('.met_testimonial_3_message', 'Content', array('color' => '','font-size' => '14','line-height' => '22')),

            // Foot
            lc_general('.met_testimonial_3_messages h5', 'Name', array('color' => '','font-size' => '14','line-height' => '17'))
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

        // General args
        $args = array(
            'post_type' => 'dslc_testimonials',
            'posts_per_page' => $options['amount'],
            'order' => $options['order'],
            'orderby' => $options['orderby'],
            'offset' => $options['offset'],
            'tax_query' => array(
                'taxonomy' => 'dslc_testimonials_cat',
                'field' => 'id',
                'terms' => $options['category_ids'],
                'operator' => 'IN'
            ),
        );

        // Do the query
        $dslc_query = new WP_Query( $args );


        $elementID = uniqid('met_avatar_testimonial_');

        if ( $dslc_query->have_posts() ){
        ?>
        <div id="<?php echo $elementID; ?>" class="met_testimonials_3 <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <div class="met_testimonial_3_photos clearfix">
                <?php
                while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
                    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    $thumb_url = $thumb_url[0];
                    $resizedImage = imageResizing($thumb_url,60,60);
                    if(!empty($thumb_url)):
                    ?>
                        <div class="met_testimonial_3">
                            <div class="met_testimonial_3_photo">
                                <img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>"/>
                            </div>
                        </div>
                    <?php
                    endif;
                endwhile;
                ?>
            </div>
            <div class="met_testimonial_3_messages">
            <?php
            while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
                ?>
                <div style="">
                    <h4><?php echo get_post_meta( get_the_ID(), 'dslc_testimonial_author_pos', true ); ?></h4>
					<span class="met_testimonial_3_message"><?php echo do_shortcode( wp_trim_words( get_the_content(), $options['excerpt_length'] ) ); ?></span>
                    <h5 class="met_color"><?php the_title(); ?></h5>
                </div>
                <?php
            endwhile;
            ?>
            </div>
        </div>
        <script>jQuery(document).ready(function(){CoreJS.avatar_testimonials('<?php echo $elementID; ?>');});</script>
            <?php echo $met_shared_options['script']; ?>
        <?php }else{
            if ( $dslc_is_admin ) :
                ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any testimonials at the moment. Go to <strong>WP Admin &rarr; Testimonials</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
            endif;
        } ?>
        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}