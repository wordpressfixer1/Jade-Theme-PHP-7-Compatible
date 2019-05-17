<?php
    global $preview_data;

    if( !$preview_data['featured_img']['error'] ){
        echo '<a href="'.$preview_data['featured_img']['url'].'" rel="lb_post_id_'.get_the_ID().'"><img class="img-responsive" src="'.$preview_data['featured_img']['thumb'].'" alt="'.esc_attr(get_the_title()).'" /></a>';
        echo '<script>jQuery().ready(function(){CoreJS.lightbox()});</script>';
    }

    $is_on_image = !$preview_data['featured_img']['error'] ? 'met_special_post_detail_on_image' : '';
    echo '<div class="met_special_post_detail '.$is_on_image.'">'.get_the_content().'</div>';