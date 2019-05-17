<?php
// Register Module
function register_staffwithskill_module() {
    return dslc_register_module( "MET_StaffWithSkills" );
}
add_action('dslc_hook_register_modules','register_staffwithskill_module');

class MET_StaffWithSkills extends DSLC_Module {

    var $module_id = 'MET_StaffWithSkills';
    var $module_title = 'Detailed';
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
                'label' => __( 'Skills Title', 'dslc_string' ),
                'id' => 'skills_title',
                'std' => 'Skills Title',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'image skills_title skills name work content socials',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Image', 'dslc_string' ),
                        'value' => 'image'
                    ),
                    array(
                        'label' => __( 'Skills Title', 'dslc_string' ),
                        'value' => 'skills_title'
                    ),
                    array(
                        'label' => __( 'Skills', 'dslc_string' ),
                        'value' => 'skills'
                    ),
                    array(
                        'label' => __( 'Name', 'dslc_string' ),
                        'value' => 'name'
                    ),
                    array(
                        'label' => __( 'Work', 'dslc_string' ),
                        'value' => 'work'
                    ),
                    array(
                        'label' => __( 'Content', 'dslc_string' ),
                        'value' => 'content'
                    ),
                    array(
                        'label' => __( 'Socials', 'dslc_string' ),
                        'value' => 'socials'
                    ),
                )
            ),
            array(
                'label' => __( 'Grayscale', 'dslc_string' ),
                'id' => 'grayscale',
                'std' => 'off',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Off', 'dslc_string' ),
                        'value' => 'off'
                    ),
                    array(
                        'label' => __( 'On', 'dslc_string' ),
                        'value' => 'on'
                    ),
                )
            ),
            array(
                'label' => __( 'Staff Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '3',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Staff Per Row', 'dslc_string' ),
                'id' => 'columns',
                'std' => '4',
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
            array(
                'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
                'id' => 'excerpt_length',
                'std' => '20',
                'type' => 'text'
            ),

            /**
             * Image Options
             */
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '330',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '370',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '370',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Border Radius
            lc_borderRadius('.met_team_member', ''),

            // Borders
            lc_borders('.met_team_member', '', array(), array(), '0', '', 'solid' ),

            // Overlay Background Color
            lc_general('.met_team_member_overlay', 'Overlay', array('background-color' => 'rgba(0,0,0,0.6)')),

            // Overlay Title
            lc_general('h5', 'Overlay', array('color' => '#FFFFFF', 'font-size' => '24', 'line-height' => '22', 'font-weight' => '400')),

            // Skills
            lc_general('.met_team_member_overlay span', 'Skill', array('color' => '#FFFFFF', 'font-size' => '12', 'line-height' => '30', 'font-weight' => '400')),

            // Skill Bar
            lc_general('li div.met_bgcolor2', 'Skill Bar', array('background-color' => '')),

            // Name
            lc_general('h3', 'Name', array('color' => '#000000', 'font-size' => '19', 'line-height' => '22', 'font-weight' => '400')),

            // Name
            lc_general('.met_title_with_subtitle', 'Name', array('text-align' => 'left')),

            // Work
            lc_general('h4', 'Work', array('color' => '', 'font-size' => '12', 'line-height' => '22', 'font-weight' => '400')),

            // Content Background Color
            lc_general('.met_team_member_details', 'Content', array('background-color' => '#F8F7F5')),

            // Content Paddings
            lc_paddings('.met_team_member_details', 'Content', '20'),

            // Content
            lc_general('.met_p', 'Content', array('color' => '', 'font-size' => '12', 'line-height' => '22', 'font-weight' => '400', 'text-align' => 'left')),

            // Socials Background Color
            lc_general('.met_team_member_socials', 'Socials', array('background-color' => '')),

            // Socials Border
            lc_borders('.met_team_member_socials', 'Socials', array(
                't' => array('width' => '0', 'color' => '', 'style' => 'solid'),
                'r' => array('width' => '0', 'color' => '', 'style' => 'solid'),
                'b' => array('width' => '5', 'color' => 'rgba(0,0,0,0.11)', 'style' => 'solid'),
                'l' => array('width' => '0', 'color' => '', 'style' => 'solid'),
            ), array(), '', '', '' ),

            // Phone Number
            lc_general('.met_team_member_phone', 'Phone Number', array('color' => '', 'color:hover' => '', 'font-size' => '12', 'line-height' => '50', 'font-weight' => '400')),

            // Social Icons
            lc_general('.met_team_member_social', 'Social Icons', array('color' => '', 'color:hover' => '', 'font-size' => '16', 'line-height' => '49')),

            // Mail Icon
            lc_general('.met_team_member_mail', 'Mail Icon', array('background-color' => 'rgba(0,0,0,0.11)', 'color' => '', 'color:hover' => '', 'font-size' => '16', 'line-height' => '50'))
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

        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;


        $elementID = uniqid('staff2_');
        if ( $dslc_query->have_posts() ){
            ?>
            <div id="<?php echo $elementID; ?>" class="met_staff_members row <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
                <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
                    <?php
						$social = $socials = $staff_skill_items = array();

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
						$social['phone']           = get_post_meta( get_the_ID(), 'dslc_staff_social_phone', true );

						foreach($social as $k => $v):
							if(!empty($v)):
								$socials[$k] = $v;
							endif;
						endforeach;

						$staff_skill_items = rwmb_meta('met_staff_skills', '', get_the_ID());
                    ?>
                    <div class="met_staff_member col-md-<?php echo $options['columns']; ?>">
                        <div class="met_team_member">
                            <?php
                            $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                            $thumb_url = $thumb_url[0];
                            $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                            if(!empty($thumb_url)): ?>
                                <div class="met_team_member_preview">
                                    <img class="met_grayscale_<?php echo $options['grayscale'] ?>" src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>"/>
                                    <?php if( empty($elements) || in_array('skills_title', $elements) || in_array('skills', $elements) ): ?>
                                    <div class="met_team_member_overlay met_vcenter">
                                        <div>
                                        <?php if( $dslc_is_admin ): ?>
                                            <h5 class="dslca-editable-content" data-id="skills_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['skills_title']); ?></h5>
                                        <?php elseif( !empty($options['skills_title'] ) && !$dslc_is_admin): ?>
                                            <h5><?php echo stripslashes($options['skills_title']); ?></h5>
                                        <?php endif; ?>


                                            <?php if( empty($elements) || in_array('skills', $elements) ): ?>
												<?php
													if( is_array($staff_skill_items) AND count($staff_skill_items) > 0){
														echo '<ul class="met_clean_list">';
														foreach($staff_skill_items as $skill_item){
															$skill_item_data = explode('|', $skill_item, 2);
															if($skill_item_data){
																$skill_perc = $skill_item_data[0];
																$skill_title = $skill_item_data[1];
															}else{
																$skill_perc = 100;
																$skill_title = $skill_item_data[0];
															}
															echo '<li>
																<span>'.$skill_title.'</span>
																<div><div style="width: '.$skill_perc.'%"><div class="met_bgcolor2"></div></div></div>
															</li>';
														}
														echo '</ul>';
													}
												?>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if( empty($elements) || in_array('name', $elements) || in_array('position', $elements) || in_array('content', $elements) ): ?>
                            <div class="met_team_member_details">
                                <?php if( empty($elements) || in_array('name', $elements) || in_array('position', $elements) ): ?>
                                <header class="met_title_with_subtitle">
                                    <?php if( empty($elements) || in_array('name', $elements) ): ?><h3><?php the_title(); ?></h3><?php endif; ?>

                                    <?php if( (!empty($position) && (empty($elements) || in_array('work', $elements))) ): ?><h4 class="met_color2"><?php echo $position; ?></h4><?php endif; ?>
                                </header>
                                <?php endif; ?>
                                <?php $the_content = wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ); if( ( empty($elements) || in_array('content', $elements) ) && !empty($the_content) ): ?><div class="met_p"><?php echo $the_content; ?></div><?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if( !empty($socials) && in_array('socials', $elements) ): ?>
                            <div class="met_team_member_socials met_bgcolor2 clearfix">
                                <?php if( isset($socials['phone']) ): ?><a class="met_team_member_phone met_color_transition" href="tel:<?php echo $socials['phone']; ?>"><?php echo $socials['phone']; ?></a><?php unset($socials['phone']); endif; ?>

                                <?php if( isset($socials['envelope']) ): ?><a href="mailto:<?php echo $socials['envelope']; ?>" class="met_team_member_mail met_color_transition"><i class="dslc-icon dslc-icon-envelope"></i></a><?php unset($socials['envelope']); endif; ?>
                                <?php foreach($socials as $k => $v): ?><a href="<?php echo $v; ?>" class="met_team_member_social met_color_transition"><i class="dslc-icon dslc-icon-<?php echo $k; ?>"></i></a><?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
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