<?php
// Register Module
function register_staffgrid_module() {
    return dslc_register_module( "MET_StaffGrid" );
}
add_action('dslc_hook_register_modules','register_staffgrid_module');

class MET_StaffGrid extends DSLC_Module {

    var $module_id = 'MET_StaffGrid';
    var $module_title = 'Simple';
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
            array(
                'label' => __( 'Staff Amount', 'dslc_string' ),
                'id' => 'columns',
                'std' => '5',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => '5',
                        'value' => '5',
                    ),
                    array(
                        'label' => '4',
                        'value' => '4',
                    ),
                    array(
                        'label' => '3',
                        'value' => '3',
                    ),
                    array(
                        'label' => '2',
                        'value' => '2',
                    ),
                    array(
                        'label' => '1',
                        'value' => '1',
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
            array(
                'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
                'id' => 'excerpt_length',
                'std' => '40',
                'type' => 'text'
            ),

            /**
             * Image Options
             */
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '226',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '222',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '222',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,
            // Name
            lc_general('h3', 'Name', array('color' => '#000000', 'font-size' => '24', 'line-height' => '35', 'font-weight' => '400')),

            // Work
            lc_general('h4', 'Work', array('color' => '', 'font-size' => '12', 'line-height' => '35', 'font-weight' => '400')),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400')),

            // Social Icons
            lc_general('.met_teamlist_socials a', 'Social Icons', array('color' => '', 'color:hover' => '', 'font-size' => '20', 'line-height' => '22'))
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

        // General args
        $args = array(
            'post_type' => 'dslc_staff',
            'posts_per_page' => $options['columns'],
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

        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 40;

        $elementID = uniqid('staffgrid_');
        if ( $dslc_query->have_posts() ){

            $staff_grid = array();
            $i = 0;

            while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
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

                $staff_grid[$i]['position'] = $position;
                $staff_grid[$i]['socials'] = $socials;

                $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                $thumb_url = $thumb_url[0];
                $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                if( !empty($resizedImage) ):
                    $staff_grid[$i]['image'] = $resizedImage['url'];
                else:
                    $staff_grid[$i]['image'] = $thumb_url;
                endif;

                $staff_grid[$i]['name'] = get_the_title();
                $staff_grid[$i]['content'] = wp_trim_words( get_the_excerpt(), $options['excerpt_length'] );
            $i++;
            endwhile; ?>
            <div id="<?php echo $elementID; ?>">
                <div class="met_teamlist columns_<?php echo $options['columns']; ?> clearfix">
                    <?php foreach($staff_grid as $k => $staff_item): ?>
                    <div class="met_teamlist_member <?php echo $k === 0 ? 'on' : ''; ?>">
                        <img src="<?php echo $staff_item['image']; ?>" alt="<?php echo $staff_item['name']; ?>" />
                        <div class="met_teamlist_member_overlay met_bgcolor"></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="met_teamlist_details clearfix">
                    <?php foreach($staff_grid as $staff_item): ?>
                        <div>
                            <header class="met_title_with_subtitle">
                                <h3><?php echo $staff_item['name']; ?></h3>
                                <h4 class="met_color2"><?php echo $staff_item['position']; ?></h4>
                            </header>
                            <div class="met_p"><?php echo $staff_item['content']; ?></div>
                            <div class="met_teamlist_socials">
                                <?php foreach($staff_item['socials'] as $k => $v): ?><a href="<?php echo $v; ?>" target="_blank" class="met_color_transition"><i class="dslc-icon dslc-icon-<?php echo $k; ?>"></i></a><?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <script>jQuery(document).ready(function(){CoreJS.teamlistHoverControls('<?php echo $elementID; ?>');});</script>
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