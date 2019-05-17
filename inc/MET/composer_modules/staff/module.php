<?php
// Register Module
function register_staff_module() {
    return dslc_register_module( "MET_Staff" );
}
add_action('dslc_hook_register_modules','register_staff_module');

if ( dslc_is_module_active( 'MET_Staff' ) )
    include get_template_directory() . '/inc/MET/composer_modules/staff/functions.php';

class MET_Staff extends DSLC_Module {

    var $module_id = 'MET_Staff';
    var $module_title = 'Clean';
    var $module_icon = 'info';
    var $module_category = 'met - staff';

    function options() {

        $cats = get_terms( 'dslc_staff_cats' );
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
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'socials name position',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Socials', 'dslc_string' ),
                        'value' => 'socials'
                    ),
                    array(
                        'label' => __( 'Name', 'dslc_string' ),
                        'value' => 'name'
                    ),
                    array(
                        'label' => __( 'Position', 'dslc_string' ),
                        'value' => 'position'
                    ),
                )
            ),
            array(
                'label' => __( 'Black & White Effect', 'dslc_string' ),
                'id' => 'black_white',
                'std' => 'no',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => 'Don\'t Apply',
                        'value' => 'no',
                    ),
                    array(
                        'label' => 'Apply',
                        'value' => 'yes',
                    ),
                ),
            ),

            array(
                'label' => __( 'Staff Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '4',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Staff Per Row', 'dslc_string' ),
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
                'label' => __( 'Categories', 'dslc_string' ),
                'id' => 'categories',
                'std' => '',
                'type' => 'checkbox',
                'choices' => $cats_choices
            ),
            array(
                'label' => __( 'Staff IDs [Seperate with "," Comma]', 'dslc_string' ),
                'id' => 'staff_ids',
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
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Background Color
            lc_general('section', '', array('background-color' => '')),

            // Content Paddings
            lc_paddings('section', '', array('t' => '20', 'r' => '10', 'b' => '20', 'l' => '10')),

            // Content Borders
            lc_borders('section', '', array(), array(), '0', '', 'solid' ),

            // Name
            lc_general('.title', 'Name', array('color' => '', 'color:hover' => '', 'font-size' => '18', 'line-height' => '20', 'font-weight' => '600', 'text-align' => 'center')),

            // Position
            lc_general('.position', 'Sub Title', array('color' => '', 'font-size' => '14', 'line-height' => '16', 'font-weight' => '400', 'text-align' => 'center')),

            // Social Icons Bg
            lc_general('.met_staff_member_preview_bg', 'Social Icons', array('background-color' => '')),

            // Social Icons
            lc_general('.met_staff_member_socials a', 'Social Icons', array('color' => '', 'color:hover' => '', 'font-size' => '17', 'line-height' => '45'))
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
            'post_type' => 'dslc_staff',
            'posts_per_page' => $options['amount'],
            'order' => $options['order'],
            'orderby' => $options['orderby'],
            'offset' => $options['offset']
        );

        // Category args
        if( !empty( $options['staff_ids'] ) )
            $args['p'] = $options['staff_ids'];

        else if ( isset( $options['categories'] ) && $options['categories'] != '' ) {

            $cats_array = explode( ' ', trim( $options['categories'] ));

            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'dslc_staff_cats',
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


        $elementID = uniqid('staff_');
        if ( $dslc_query->have_posts() ){
        ?>
        <div id="<?php echo $elementID; ?>" class="met_staff_members row <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
            <?php
            $social = $socials = array();
            $position = get_post_meta( get_the_ID(), 'dslc_staff_position', true );
            $social['twitter']         = get_post_meta( get_the_ID(), 'dslc_staff_social_twitter', true );
            $social['facebook']        = get_post_meta( get_the_ID(), 'dslc_staff_social_facebook', true );
            $social['google-plus']     = get_post_meta( get_the_ID(), 'dslc_staff_social_googleplus', true );
            $social['linkedin']        = get_post_meta( get_the_ID(), 'dslc_staff_social_linkedin', true );
            $social['dribbble']        = get_post_meta( get_the_ID(), 'dslc_staff_social_dribbble', true );
            $social['github']          = get_post_meta( get_the_ID(), 'dslc_staff_social_github', true );
            $social['stackexchange']   = get_post_meta( get_the_ID(), 'dslc_staff_social_stackexchange', true );
            $social['vk']              = get_post_meta( get_the_ID(), 'dslc_staff_social_vk', true );
            $social['weibo']           = get_post_meta( get_the_ID(), 'dslc_staff_social_weibo', true );
            $social['xing']            = get_post_meta( get_the_ID(), 'dslc_staff_social_xing', true );
            $social['renren']          = get_post_meta( get_the_ID(), 'dslc_staff_social_renren', true );
            $social['foursquare']      = get_post_meta( get_the_ID(), 'dslc_staff_social_foursquare', true );
            $social['instagram']       = get_post_meta( get_the_ID(), 'dslc_staff_social_instagram', true );
            $social['pinterest']       = get_post_meta( get_the_ID(), 'dslc_staff_social_pinterest', true );
            $social['skype']           = get_post_meta( get_the_ID(), 'dslc_staff_social_skype', true );
            $social['tumblr']          = get_post_meta( get_the_ID(), 'dslc_staff_social_tumblr', true );
            $social['pagelines']       = get_post_meta( get_the_ID(), 'dslc_staff_social_pagelines', true );
            $social['youtube']         = get_post_meta( get_the_ID(), 'dslc_staff_social_youtube', true );
            $social['flickr']          = get_post_meta( get_the_ID(), 'dslc_staff_social_flickr', true );
            $social['vimeo-square']    = get_post_meta( get_the_ID(), 'dslc_staff_social_vimeo', true );
            $social['envelope']        = get_post_meta( get_the_ID(), 'dslc_staff_social_envelope', true );

            foreach($social as $k => $v):
                if(!empty($v)):
                    $socials[$k] = $v;
                endif;
            endforeach;
            ?>
            <div class="met_staff_member col-md-<?php echo $options['columns']; ?> <?php if($options['black_white'] == 'yes'): echo 'black_white';  endif; ?>">
            <?php
                $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                $thumb_url = $thumb_url[0];
                $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                if(!empty($thumb_url)): ?>
                <div class="met_staff_member_preview">
                    <img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>"/>
                    <?php if( !empty($socials) && (empty($elements) || in_array('socials', $elements)) ): ?>
                        <div class="met_staff_member_socials_wrap">
                            <div class="met_staff_member_socials">
                            <?php foreach($socials as $k => $v): if(!empty($v)): ?>
                            <a href="<?php echo $v; ?>"><i class="dslc-icon dslc-icon-<?php echo $k; ?>"></i></a>
                            <?php endif; endforeach; ?>
                            </div>
                        </div>
                        <div class="met_staff_member_preview_bg met_bgcolor"></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if( empty($elements) || in_array('name', $elements) || in_array('position', $elements) ): ?>
                <section class="met_bgcolor">
                <?php if( empty($elements) || in_array('name', $elements) ): ?>
                    <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                <?php endif; ?>

                    <?php if( (!empty($position) && (empty($elements) || in_array('position', $elements))) ): ?><span class="position"><?php echo $position; ?></span><?php endif; ?>
                </section>
                <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
            <?php echo $met_shared_options['script']; ?>
        <?php }else{
            if ( $dslc_is_admin ) :
                ?><div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any staff at the moment. Go to <strong>WP Admin &rarr; Staff</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
            endif;
        } ?>
        <?php

        /* Module output ends here */
        wp_reset_query();
        $this->module_end( $options );

    }

}