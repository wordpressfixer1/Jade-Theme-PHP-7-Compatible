<?php printf(__('by <a href="%2$s" class="met_color2 met_color_transition">%1$s</a>','Jade'),get_the_author(),esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )) ?>