<?php
    global $preview_data, $dslc_active;
    if( !empty( $preview_data[$preview_data['media_type']] ) ){
        switch($preview_data['media_type']):
            case 'html5_video':
                do_action('met_wp_video_shortcode', $preview_data[$preview_data['media_type']]);
                break;

            case 'html5_audio':
                do_action('met_wp_audio_shortcode', $preview_data[$preview_data['media_type']]);
                break;

            case 'slider':
                $elementID = uniqid('postSlider_');
                wp_enqueue_script('metcreative-bxslider'); ?>
                <div class="met_blog_block_slider_container">
                    <div class="met_blog_block_slider_wrapper">
                        <div id="<?php echo $elementID ?>" class="met_blog_block_slider" data-mode="<?php echo $preview_data[$preview_data['media_type']]['mode'] ?>" data-randomstart="false" data-infiniteloop="true" data-auto="true" data-sliderautohover="true" data-sliderpause="<?php echo $preview_data[$preview_data['media_type']]['time'] ?>" data-speed="<?php echo $preview_data[$preview_data['media_type']]['speed'] ?>">
                            <?php
                            $slider_images = $preview_data[$preview_data['media_type']]['images'];
                            if( $slider_images ){
                                foreach($slider_images as $slider_image){
                                    echo '<a href="'.$slider_image['full_url'].'" rel="lb_'.$elementID.'"><img src="'.$slider_image['thumb_url'].'" alt="'.esc_attr($slider_image['title']).'" /></a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <nav>
                        <a href="#" class="met_blog_block_slider_prev met_bgcolor_transition previous"><i class="fa fa-angle-left"></i></a>
                        <a href="#" class="met_blog_block_slider_next met_bgcolor_transition next"><i class="fa fa-angle-right"></i></a>
                    </nav>
                </div>
                <script>jQuery().ready(function(){CoreJS.blogBlockSlider('<?php echo $elementID ?>')});</script><?php
                break;

            case 'oembed':
                echo $preview_data[$preview_data['media_type']];

                $asyncScripts = "[]";
                if ( isset($dslc_active) && $dslc_active ){
                    $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.fitVids.js"]';
                }else{
                    wp_enqueue_script('metcreative-fitVids');
                }

				$pageType = is_single() ? 'dslc-content' : 'post-'.get_the_ID();

                echo '<script>jQuery(document).ready(function(){CoreJS.loadAsync('.$asyncScripts.',["fittingVids|'.$pageType.'"])});</script>';
                break;

        endswitch;

        echo '<script>jQuery().ready(function(){CoreJS.lightbox()});</script>';
    }elseif( !$preview_data['featured_img']['error'] ){
        echo '<a href="'.$preview_data['featured_img']['url'].'" rel="lb_post_id_'.get_the_ID().'"><img class="img-responsive" src="'.$preview_data['featured_img']['thumb'].'" alt="'.esc_attr(get_the_title()).'" /></a>';
        echo '<script>jQuery().ready(function(){CoreJS.lightbox()});</script>';
    }