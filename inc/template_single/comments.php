<?php
// If comments are open or we have at least one comment, load up the comment template

$pid = null;
if(get_post_type() == 'dslc_projects'){
    global $dslc_post_id;
    $pid = $dslc_post_id;
}

if ( comments_open() || '0' != get_comments_number() ){
    echo '<div class="met_hard_line_split"></div>';
	comments_template();
}