<?php
wp_enqueue_script('metcreative-bxslider');
global $dslc_post_id;

$args = array(
    'paged' => 1,
    'post_type' => 'dslc_projects',
    'posts_per_page' => 6,
    'order' => 'DESC',
    'orderby' => 'date',
    'post__not_in' => array($dslc_post_id)
);

// Do the query
$query = new WP_Query( $args );
?>
<!-- Recent Works Starts -->
<div class="met_recent_portfolio_nav clearfix">
	<span><?php _e('Recent Works','Jade') ?></span>
</div>

<div class="met_recent_portfolio_wrap">
<?php
if ( $query->have_posts() ) {

    $taxonomyStack = array();
?>
	<div class="met_recent_portfolio clearfix crsl-wrap">
    <?php while ( $query->have_posts() ) : $query->the_post();
        $taxonomies = array();
        $taxCats = get_the_terms(get_the_ID(), end(get_object_taxonomies( get_post()->post_type, 'names' )));
        if($taxCats){
            foreach( get_the_terms(get_the_ID(), end(get_object_taxonomies( get_post()->post_type, 'names' ))) as $k => $v ):
                $taxonomies[$k] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
                if(!array_key_exists($k,$taxonomyStack)) $taxonomyStack[$k] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
            endforeach;
        } ?>


		<!-- Image Post Starts -->
		<div class="met_portfolio_item crsl-item">
            <?php
            $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
            $thumb_url = $thumb_url[0];
            $res_img = aq_resize( $thumb_url, 370, 300, true );

            if( empty($res_img) ) $res_img = $thumb_url;
            ?>
			<a href="<?php the_permalink(); ?>" class="met_portfolio_item_preview"><img src="<?php echo $res_img; ?>" alt="<?php the_title(); ?>" /></a>
			<div class="met_portfolio_item_details">
				<a href="<?php the_permalink(); ?>" class="met_portfolio_item_title"><h3><?php the_title(); ?></h3></a>
				<div class="met_portfolio_item_categories">
                    <?php
                    $categories = array();
                    foreach($taxonomies as $category)
                        $categories[] = '<a href="'.(array_key_exists('link',$category) ? $category['link'] : get_term_link( $category["slug"], $category["taxonomy"] )).'" class="met_color2">'.$category["name"].'</a>';

                    echo implode(', ',$categories);
                    ?>
				</div>

                <?php
                $lbBox = $media_file = '';
                $mfp_src = uniqid('u_');
                $media_type = rwmb_meta('met_content_media_type');
                $linkBox = '<a href="'.get_permalink().'" class="met_bgcolor first_icon_link"><i class="fa fa-link"></i></a>';

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

                        $lbBox = '<a href="#" class="met_bgcolor second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'"><i class="fa fa-play-circle"></i></a>'; ?>

                        <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php do_action('met_wp_video_shortcode', $media_file); ?></div><?php
                        break;

                    case 'html5_audio':
                        $mp3     = rwmb_meta('met_html5_audio_file_mp3','type=file_advanced');
                        $loop    = rwmb_meta('met_html5_media_loop');
                        $autoplay= rwmb_meta('met_html5_media_autoplay');

                        $media_file['mp3']      = !empty($mp3)      ? $mp3[key($mp3)]['url']   : '';
                        $media_file['loop']     = !empty($loop)     ? $loop : 'false';
                        $media_file['autoplay'] = !empty($autoplay) ? $autoplay : 'false';

                        $lbBox = '<a href="#" class="met_bgcolor second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'"><i class="fa fa-volume-up"></i></a>'; ?>

                        <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php do_action('met_wp_audio_shortcode', $media_file); ?></div><?php
                        break;

                    case 'slider':
                        $slider_images = rwmb_meta('met_slider_images','type=plupload_image');

                        if(count($slider_images) > 0) $firstItem = reset($slider_images);

                        $lbBox = '<a href="'.$firstItem['full_url'].'" class="met_bgcolor second_icon_link" rel="lb_portfolio_'.$mfp_src.'"><i class="fa fa-picture-o"></i></a>'; ?>

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
                        $lbBox = '<a href="#" class="met_bgcolor second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'"><i class="fa fa-play"></i></a>'; ?>

                        <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php echo wp_oembed_get(rwmb_meta('met_oembed_link')); ?></div><?php
                        break;
                endswitch;

                if( empty($media_type) && !empty($thumb_url) ){
                    $lbBox = '<a href="'.$thumb_url.'" class="met_bgcolor second_icon_link" rel="lb_portfolio_'.$mfp_src.'" title="'.esc_attr(get_the_title()).'"><i class="fa fa-search"></i></a>';
                }
                if( $linkBox != '' || $lbBox != '' ){ ?><div class="met_portfolio_item_links"><?php echo $linkBox.$lbBox; ?></div><!-- .met_portfolio_item_links --><?php } ?>
			</div>
		</div><!-- Image Post Ends -->
    <?php endwhile;wp_reset_query(); ?>
	</div>
    <script>
        jQuery(function(){CoreJS.lightbox();CoreJS.recentPortfolioWorks();});
    </script>
<?php } ?>
</div>