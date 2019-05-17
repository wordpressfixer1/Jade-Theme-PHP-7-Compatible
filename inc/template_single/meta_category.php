<?php
$categories_list = get_the_category_list( __( ', ', 'Jade' ) );
if ( $categories_list ) :
	$categories_list = str_replace('<a','<a class="met_blog_detail_info_category met_color_transition2" ',$categories_list);
	printf( __('on %1$s','Jade'), $categories_list );
endif; // End if categories
?>