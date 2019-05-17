<?php
// Register Module
function register_postscaratwo_module() {
    return dslc_register_module( "MET_PostsCarousel2" );
}
add_action('dslc_hook_register_modules','register_postscaratwo_module');

class MET_PostsCarousel2 extends DSLC_Module {

    var $module_id = 'MET_PostsCarousel2';
    var $module_title = 'Multi Columned 2';
    var $module_icon = 'pencil';
    var $module_category = 'met - post carousels';

    function options() {

        $post_type_categoryArgs = categoryArgs('', '', 1);

        // Options
        $dslc_options = array(
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
                'label' => __( 'Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '12',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Visible', 'dslc_string' ),
                'id' => 'columns',
                'std' => '3',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => '6',
                        'value' => '6',
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
                'label' => __( 'Carousel Speed', 'dslc_string' ),
                'id' => 'speed',
                'std' => '500',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Carousel Pause', 'dslc_string' ),
                'id' => 'pause',
                'std' => '5000',
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

            /**
             * Image Options
             */
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
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '240',
                'type' => 'text'
            ),

            /* Styling */

            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'thumbnail title categories first_icon_link second_icon_link',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Thumbnail', 'dslc_string' ),
                        'value' => 'thumbnail'
                    ),
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Categories', 'dslc_string' ),
                        'value' => 'categories'
                    ),
                    array(
                        'label' => __( 'First Icon Link', 'dslc_string' ),
                        'value' => 'first_icon_link'
                    ),
                    array(
                        'label' => __( 'Second Icon Link', 'dslc_string' ),
                        'value' => 'second_icon_link'
                    ),
                ),
                'section' => 'styling',
            ),

        );

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_portfolio_item_details', 'Detail Box', array('background-color' => '')),

            lc_general('.met_portfolio_item_details:after', 'Detail Box', array('background-color' => ''), 'Hover'),

            // Box Paddings
            lc_paddings('.met_portfolio_item_details', 'Detail Box', array('t' => '25', 'r' => '25', 'b' => '25', 'l' => '25')),

            // Box Borders
            lc_borders('.met_portfolio_item_details', 'Detail Box', array(), array(), '0', '#000000', 'solid' ),

            // Box Border Radius
            lc_borderRadius('.met_portfolio_item_details', 'Detail Box'),


            // Title
            lc_general('.met_portfolio_item_title h3', 'Title', array('color' => '', 'color:hover' => '','font-size' => '18','line-height' => '20')),

            // Categories
            lc_general('.met_portfolio_item_categories, .met_portfolio_item_categories a', 'Category Links', array('color' => '', 'font-size' => '12','line-height' => '22')),


            // Icon Links
            lc_general('.met_portfolio_item_links', 'Icon Links', array('text-align' => 'center')),

            // Icon Links
            lc_general('.met_portfolio_item_links a', 'Icon Links', array('color' => '', 'color:hover' => '', 'font-size' => '18', 'width,height,line-height' => '45')),

            // Icon Links
            lc_general('.first_icon_link', 'Icon Links', array('background-color' => ''), 'First Icon'),

            lc_general('.second_icon_link', 'Icon Links', array('background-color' => ''), 'Second Icon')

        );

        $dslc_options = met_lc_extras($dslc_options, array('animation'), 'shared_options');
        
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
		    'groups'   => array('animation'),
		    'params'   => array(
			    'js'           => false,
			    'css'          => false,
			    'external_run' => false,
			    'is_grid'      => false,
		    ),
		    'is_admin' => $dslc_is_admin,
	    ), 'shared_options_output' );
        
        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.bxslider.min.js"]';
        }else{
            wp_enqueue_script('metcreative-bxslider');
            
            if( $met_shared_options['activity'] ){
                wp_enqueue_script('metcreative-wow');
                wp_enqueue_style('metcreative-animate');
            }
        }
        /* CUSTOM START */

        if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

        /**
         * Query
         */

        // Fix for pagination

        $options['amount'] = $options['amount'] == '' ? -1 : $options['amount'];
        // General args
        $args = array(
            'paged' => 1,
            'post_type' => $options['post_type'],
            'posts_per_page' => $options['amount'],
            'order' => $options['order'],
            'orderby' => $options['orderby'],
            'offset' => $options['offset']
        );

        // Category args
        if($options['post_type'] != 'post'){
            $args = array_merge($args, categoryArgs($options['post_type'], $options['category_ids']));
        }else{
            if(!empty($options['category_ids'])) $args['category__in'] = explode(' ', $options['category_ids']);
        }

        // Do the query
        $dslc_query = new WP_Query( $args );

        /**
         * Elements to show
         */

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = 'all';

        /**
         * Posts ( output )
         */

        if ( $dslc_query->have_posts() ) {

            $taxonomyStack = array();
            $elementID = uniqid('postscarousel2_');
            ?>
            <div id="<?php echo $elementID; ?>" class="met_portfolio_carousel_wrapper <?php echo $met_shared_options['classes'].' '.$met_shared_options['uniqueClass']; ?>" <?php echo $met_shared_options['data-']; ?> data-columns="<?php echo $options['columns']; ?>" data-speed="<?php echo $options['speed']; ?>" data-pause="<?php echo $options['pause']; ?>">

	            <a href="#" class="met_portfolio_carousel_nav prev met_bgcolor met_vcenter"><i class="dslc-icon dslc-icon-chevron-left"></i></a>
	            <a href="#" class="met_portfolio_carousel_nav next met_bgcolor met_vcenter"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
	
	            <div class="met_portfolio clearfix met_portfolio_carousel columns_<?php echo $options['columns']; ?>">
	                <?php
	            while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
	                $taxonomies = array();
	                if($options['post_type'] != 'post'){
	                    $taxCats = get_the_terms(get_the_ID(), end(get_object_taxonomies( get_post()->post_type, 'names' )));
	                    if($taxCats){
	                        foreach( get_the_terms(get_the_ID(), end(get_object_taxonomies( get_post()->post_type, 'names' ))) as $k => $v ):
	                            $taxonomies[$k] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
	                            if(!array_key_exists($k,$taxonomyStack)) $taxonomyStack[$k] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
	                        endforeach;
	                    }
	                }else{
	                    foreach( get_the_category( get_the_ID() ) as $v ):
	                        $taxonomies[$v->term_id] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
	                        if(!array_key_exists($v->term_id,$taxonomyStack)) $taxonomyStack[$v->term_id] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy, 'link' => get_category_link( $v->term_id ));
	                    endforeach;
	                }
	                ?>
	
	                <div class="met_portfolio_item">
	                    <?php
	                    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
	                    $thumb_url = $thumb_url[0];
	                    $resizedImage['url'] = $thumb_url;
	
	                    if( !empty($thumb_url) )
	                        $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);?>
	
	                    <?php if ( ($elements == 'all' || in_array( 'thumbnail', $elements )) && !empty($thumb_url) ) : ?>
	                        <a href="<?php the_permalink(); ?>" class="met_portfolio_item_preview"><img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>" /></a>
	                    <?php endif; ?>
	
	                    <?php if ( $elements == 'all' || in_array( 'title', $elements ) || in_array( 'categories', $elements ) ) : ?>
	                    <div class="met_portfolio_item_details">
	                        <?php if ( $elements == 'all' || in_array( 'title', $elements ) ) : ?>
	                            <a href="<?php the_permalink(); ?>" class="met_portfolio_item_title"><h3><?php the_title(); ?></h3></a>
	                        <?php endif; ?>
	                        <?php if( ($elements == 'all' || in_array( 'categories', $elements )) && !empty($taxonomies) ) : ?>
	                            <div class="met_portfolio_item_categories">
	                                <?php
	                                $categories = array();
	                                foreach($taxonomies as $category)
	                                    $categories[] = '<a href="'.(array_key_exists('link',$category) ? $category['link'] : get_term_link( $category["slug"], $category["taxonomy"] )).'" class="met_color2">'.$category["name"].'</a>';
	
	                                echo implode(', ',$categories);
	                                ?>
	                            </div>
	                        <?php endif; ?>
	
	                        <?php
	                        $lbBox = $media_file = '';
	                        $mfp_src = uniqid('u_');
	                        $media_type = rwmb_meta('met_content_media_type');
	
	                        $linkBox = ( $elements == 'all' || in_array( 'first_icon_link', $elements ) ) ? '<a href="'.get_permalink().'" class="met_bgcolor first_icon_link"><i class="dslc-icon dslc-icon-link"></i></a>' : '';
	                        $secondLinkIf = ( $elements == 'all' || in_array( 'second_icon_link', $elements ) );
	
	
	                        switch($media_type):
	                            case 'html5_video':
	                                $mp4     = rwmb_meta('met_html5_video_file_mp4','type=file_advanced');
	                                $webm    = rwmb_meta('met_html5_video_file_webm','type=file_advanced');
	                                $ogg     = rwmb_meta('met_html5_video_file_ogv','type=file_advanced');
	                                $loop    = rwmb_meta('met_html5_media_loop');
	                                $autoplay= rwmb_meta('met_html5_media_autoplay');
	
	                                $media_file['mp4']      = !empty($mp4)      ? $mp4[key($mp4)]['url']   : '';
	                                $media_file['webm']     = !empty($webm)     ? $webm[key($webm)]['url'] : '';
	                                $media_file['ogg']      = !empty($ogg)      ? $ogg[key($ogg)]['url']   : '';
	                                $media_file['loop']     = !empty($loop)     ? $loop : 'false';
	                                $media_file['autoplay'] = !empty($autoplay) ? $autoplay : 'false';
	
	                                $lbBox = '<a href="#" class="met_bgcolor second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'"><i class="dslc-icon dslc-icon-play-circle"></i></a>'; ?>
	
	                                <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php do_action('met_wp_video_shortcode', $media_file); ?></div><?php
	                                break;
	
	                            case 'html5_audio':
	                                $mp3     = rwmb_meta('met_html5_audio_file_mp3','type=file_advanced');
	                                $loop    = rwmb_meta('met_html5_media_loop');
	                                $autoplay= rwmb_meta('met_html5_media_autoplay');
	
	                                $media_file['mp3']      = !empty($mp3)      ? $mp3[key($mp3)]['url']   : '';
	                                $media_file['loop']     = !empty($loop)     ? $loop : 'false';
	                                $media_file['autoplay'] = !empty($autoplay) ? $autoplay : 'false';
	
	                                $lbBox = '<a href="#" class="met_bgcolor second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'"><i class="dslc-icon dslc-icon-volume-up"></i></a>'; ?>
	
	                                <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php do_action('met_wp_audio_shortcode', $media_file); ?></div><?php
	                                break;
	
	                            case 'slider':
	                                $slider_images = rwmb_meta('met_slider_images','type=plupload_image');
	
	                                if(count($slider_images) > 0) $firstItem = reset($slider_images);
	
	                                $lbBox = '<a href="'.$firstItem['full_url'].'" class="met_bgcolor second_icon_link" rel="lb_portfolio_'.$mfp_src.'"><i class="dslc-icon dslc-icon-picture-o"></i></a>'; ?>
	
	                                <div class="met_portfolio_item_lightbox_content">
	                                <?php
	                                if(count($slider_images) > 0){
	                                    $g='f';
	                                    foreach($slider_images as $slider_image){
	                                        if($g != 'f') echo '<a href="'.$slider_image['full_url'].'" title="'.esc_attr($slider_image['title']).'" rel="lb_portfolio_'.$mfp_src.'"></a>';
	                                        $g = 'z';
	                                    }
	                                }
	                                ?>
	                                </div><?php
	                                break;
	
	                            case 'oembed':
	                                $lbBox = '<a href="#" class="met_bgcolor second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'"><i class="dslc-icon dslc-icon-play"></i></a>'; ?>
	
	                                <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php echo wp_oembed_get(rwmb_meta('met_oembed_link')); ?></div><?php
	                                break;
	                        endswitch;
	
	                        if( empty($media_type) && !empty($thumb_url) && $secondLinkIf ){
	                            $lbBox = '<a href="'.$thumb_url.'" class="met_bgcolor second_icon_link" rel="lb_portfolio_'.$mfp_src.'" title="'.esc_attr(get_the_title()).'"><i class="dslc-icon dslc-icon-search"></i></a>';
	                        }
	                        if( $linkBox != '' || $lbBox != '' ){ ?><div class="met_portfolio_item_links"><?php echo $linkBox.$lbBox; ?></div><!-- .met_portfolio_item_links --><?php } ?>
	                    </div><!-- .met_portfolio_item_details -->
	                    <?php endif; ?>
	                </div><!-- .met_portfolio_item -->
	
	            <?php
	
	            endwhile;?>
	            </div>
            </div><!-- .dslc-cpt-posts -->
            <script>
                jQuery(function(){
                    <?php if( $dslc_is_admin ): ?>CoreJS.lightbox();<?php endif; ?>
                    CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["postsCarousel2|<?php echo $elementID ?>"]);
                });
            </script>
            <?php echo $met_shared_options['script']; ?>
        <?php
        } else {

            if ( $dslc_is_admin ) :
                ?><div class="dslc-notification dslc-red">You do not have any posts of that post type at the moment. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
            endif;

        }
        wp_reset_query();
        $this->module_end( $options );

    }

}