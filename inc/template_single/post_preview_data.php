<?php
/**
 * Prepare
 */
    global $preview_data;

    $preview_data['featured_img'] =
    $preview_data['html5_video']  =
    $preview_data['html5_auido']  =
    $preview_data['slider']       =
    $preview_data['oembed']       =
    $basket                       = '';

    $preview_data['media_type']   = rwmb_meta('met_content_media_type'); // "" 0 empty

/**
 * Take Post Preview Featured Image
 */
    $preview_data['featured_img']['error'] = false;
    $preview_data['featured_img']['id']    = get_post_thumbnail_id(get_the_ID());

    if($preview_data['featured_img']['id'] > 0){
        $preview_data['featured_img']['url']   = wp_get_attachment_url($preview_data['featured_img']['id'],'full');
        $preview_data['featured_img']['thumb'] = aq_resize( $preview_data['featured_img']['url'], $preview_data['width'], $preview_data['height'], $preview_data['hardcrop'] );
        $preview_data['featured_img']['thumb'] = empty( $preview_data['featured_img']['thumb'] ) ? $preview_data['featured_img']['url'] : $preview_data['featured_img']['thumb'];

    }else{ $preview_data['featured_img']['error'] = true; }

/**
 * Check for media type and build preview
 */
    if( !empty( $preview_data['media_type'] ) ):
        switch($preview_data['media_type']):
            case 'html5_video':
                $mp4     = rwmb_meta('met_html5_video_file_mp4','type=file_advanced');
                $webm    = rwmb_meta('met_html5_video_file_webm','type=file_advanced');
                $ogg     = rwmb_meta('met_html5_video_file_ogv','type=file_advanced');
                $loop    = rwmb_meta('met_html5_media_loop');
                $autoplay= rwmb_meta('met_html5_media_autoplay');

                $basket['mp4']      = !empty($mp4)      ? $mp4[key($mp4)]['url']   : '';
                $basket['webm']     = !empty($webm)     ? $webm[key($webm)]['url'] : '';
                $basket['ogg']      = !empty($ogg)      ? $ogg[key($ogg)]['url']   : '';
                $basket['loop']     = !empty($loop)     ? $loop     : 'false';
                $basket['autoplay'] = !empty($autoplay) ? $autoplay : 'false';
                break;

            case 'html5_audio':
                $mp3     = rwmb_meta('met_html5_audio_file_mp3','type=file_advanced');
                $loop    = rwmb_meta('met_html5_media_loop');
                $autoplay= rwmb_meta('met_html5_media_autoplay');

                $basket['mp3']      = !empty($mp3)      ? $mp3[key($mp3)]['url']   : '';
                $basket['loop']     = !empty($loop)     ? $loop : 'false';
                $basket['autoplay'] = !empty($autoplay) ? $autoplay : 'false';
                break;

            case 'slider':
                $slider_mode        = rwmb_meta('met_slider_mode');
                $slider_pause_time  = rwmb_meta('met_slider_pause_time');
                $slider_speed       = rwmb_meta('met_slider_speed');
                $slider_images      = rwmb_meta('met_slider_images','type=plupload_image');

                $basket['mode']     = empty($slider_mode)       ? 'horizontal'  : $slider_mode;
                $basket['time']     = empty($slider_pause_time) ? 4000          : $slider_pause_time;
                $basket['speed']    = empty($slider_speed)      ? 500           : $slider_speed;
                $basket['images']   = false;

                if( !empty( $slider_images ) ):
                    foreach($slider_images as $slider_image_number => $slider_image){

                        $basket['images'][$slider_image_number]['title']      = $slider_image['title'];
                        $basket['images'][$slider_image_number]['full_url']   = $slider_image['full_url'];
                        $basket['images'][$slider_image_number]['thumb_url']  = aq_resize( $slider_image['full_url'], $preview_data['width'], $preview_data['height'], $preview_data['hardcrop'] );
                        $basket['images'][$slider_image_number]['thumb_url']  = empty( $basket['images'][$slider_image_number]['thumb_url'] ) ? $slider_image['full_url'] : $basket['images'][$slider_image_number]['thumb_url'];

                    }
                endif;
                break;

            case 'oembed': $basket = wp_oembed_get(rwmb_meta('met_oembed_link')); break;
        endswitch;

        if( !empty($basket) ) $preview_data[$preview_data['media_type']] = $basket;
    endif;