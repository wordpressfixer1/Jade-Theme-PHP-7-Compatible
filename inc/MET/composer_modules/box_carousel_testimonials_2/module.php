<?php

// Register Module
function register_boxcaratestitwo_module() {
    return dslc_register_module( "MET_BoxCarouselTestimonials2" );
}
add_action('dslc_hook_register_modules','register_boxcaratestitwo_module');

class MET_BoxCarouselTestimonials2 extends DSLC_Module {

    var $module_id = 'MET_BoxCarouselTestimonials2';
    var $module_title = 'Box Carousel 2';
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
                'std' => 'head head_title view_all navigation image title date content',
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
                        'label' => __( 'Navigation', 'dslc_string' ),
                        'value' => 'navigation'
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
                )
            ),
			array(
				'label' => __( 'Categories', 'dslc_string' ),
				'id' => 'categories',
				'std' => '',
				'type' => 'checkbox',
				'choices' => $cats_choices
			),
			array(
				'label' => __( 'Testimonial Limit', 'dslc_string' ),
				'id' => 'amount',
				'std' => '5',
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
				'std' => '30',
				'type' => 'text',
				'tab' => 'Excerpt'
			),

			array(
				'label' => __( 'Resize - Height', 'dslc_string' ),
				'id' => 'thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail'
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
				'visibility' => 'hidden'
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
            lc_general('.met_content_box header a', 'Head', array('color' => '','color:hover' => '','font-size' => '12','line-height' => '25'), 'View All'),

            // Head Paddings
            lc_paddings('.met_content_box header', 'Head', array('t' => '15', 'r' => '30', 'b' => '15', 'l' => '30')),

            // Navigation Prev
            lc_general('.met_upcoming_events_prev', 'Navigation', array('background-color' => '', 'color' => '', 'color:hover' => '', 'font-size' => '12', 'width' => '50'), 'Previous'),

            // Navigation Next
            lc_general('.met_upcoming_events_next', 'Navigation', array('background-color' => '', 'color' => '', 'color:hover' => '', 'font-size' => '12', 'width' => '50'), 'Next'),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '#FFFFFF'))
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

        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

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

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();


        $elementID = uniqid('carousel_');
        ?>

        <div id="<?php echo $elementID ?>" class="met_content_box">
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
                    <?php if( in_array( 'navigation', $elements ) ) : ?>
                        <nav class="met_carousel_nav_on_header">
                            <a href="#" class="met_upcoming_events_prev met_transition previous"><i class="dslc-icon dslc-icon-chevron-left"></i></a>
                            <a href="#" class="met_upcoming_events_next met_transition next"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
                        </nav>
                    <?php endif; ?>
                </header>
            <?php endif; ?>

            <section class="met_content_box_slider met_content_box_slider_2" data-speed="500" data-pause="5000">
				<?php
					while ( $dslc_query->have_posts() ) : $dslc_query->the_post();

					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$thumb_url = $thumb_url[0];
                    $resizedImage['url'] = '';

                    if ( ! empty( $thumb_url ) ) :
                        $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                    endif;
				?>
					<div class="met_content_box_contents clearfix">
                        <?php if(! empty( $thumb_url )): ?>
                            <div class="met_overlay_wrapper">
                                <img src="<?php echo $resizedImage['url'] ?>" alt="<?php echo esc_attr(get_the_title()) ?>">
                            </div>
                        <?php endif; ?>

						<div class="met_content_box_contents_text clearfix" <?php if(empty( $thumb_url )): ?> style="margin-left: 0;" <?php endif; ?>>
							<h4 class="met_color2"><?php the_title() ?></h4>
							<h5><?php echo get_post_meta( get_the_ID(), 'dslc_testimonial_author_pos', true ); ?></h5>
						</div>
                        <div class="met_p"><?php echo do_shortcode( wp_trim_words( get_the_content(), $options['excerpt_length'] ) ); ?></div>
					</div>
				<?php
					endwhile;
				?>
            </section>
        </div>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["boxTestimonials|<?php echo $elementID ?>"]);});</script>
        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}