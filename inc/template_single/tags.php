<?php
$posttags = get_the_tags();
if ($posttags) {
	echo '<div class="met_tag_line"><span><strong>'. __('Tags','Jade') .'</strong></span>';
	echo "\r\n";

	foreach($posttags as $tag) {
		echo '<a href="'.get_tag_link($tag->term_id).'" class="met_bgcolor_transition2" rel="tag">'.$tag->name.'</a>';
		echo "\r\n";
	}

	echo '</div>';
}
?>