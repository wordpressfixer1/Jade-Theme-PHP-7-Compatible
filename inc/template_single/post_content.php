<?php
global $dslc_active, $met_options;

$content_restraint_formats = array('quote', 'link');
$get_post_format = get_post_format();
$blog_listing_content_type = met_option('blog_listing_content_type');

if( in_array( $get_post_format, $content_restraint_formats ) ) return false;

/* ### - content type ( the_content OR get_the_excerpt ) - ### */
$mb_blog_listing_content_type = rwmb_meta(MET_MB_PREFIX.'blog_listing_content_type','', get_the_ID());
if( !empty($mb_blog_listing_content_type) AND $mb_blog_listing_content_type != '0' AND !is_single() ){
	$blog_listing_content_type = $mb_blog_listing_content_type;
}

if( $get_post_format != 'gallery' && ( is_single() || $get_post_format == 'aside' || $get_post_format == 'video' || $get_post_format == 'audio' || $get_post_format == 'chat' || ( $get_post_format == 'image' && !is_single() ) ) ){

    if( !is_single() ){
        if( $blog_listing_content_type == 'content' ){
            the_content();
        }else{
            echo get_the_excerpt();
        }
    }else{
        the_content();
    }
    
}elseif( $get_post_format == 'gallery' && get_post_gallery() ){
    echo get_post_gallery();
}else{
    if( !is_single() ){
        if( $blog_listing_content_type == 'content' ){
            the_content();
        }else{
            echo get_the_excerpt();
        }
    }else{
        the_content();
    }
}

$asyncScripts = "[]";
if ( isset($dslc_active) && $dslc_active && ( $get_post_format == 'video' || $get_post_format == 'audio' ) ){
    $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.fitVids.js"]';
}else if( $get_post_format == 'video' || $get_post_format == 'audio' ){
    wp_enqueue_script('metcreative-fitVids');
}

if( $get_post_format == 'video' || $get_post_format == 'audio' ) :
    wp_enqueue_style('metcreative-mediaelement');?>
    <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["fittingVids|post-<?php the_ID() ?>"]);});</script>
<?php endif ?>