<?php
$content_restraint_formats = array('quote', 'link');

if( in_array( get_post_format(), $content_restraint_formats ) ) return false;

the_title('<h2 class="entry-title"><a href="'.get_permalink().'" title="'.sprintf( esc_attr__( 'Permalink to %s', 'Jade' ), get_the_title() ).'" class="met_color_transition" rel="bookmark">','</a></h2>')
?>