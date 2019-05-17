<div class="met_share_line met_bgcolor2">
	<span><?php _e('Share','Jade') ?></span>
	<div class="met_share_line_socials">
		<?php
        global $dslc_post_id;

		if(get_post_type() == 'dslc_projects'){
			$social_codes_output =  met_option('project_detail_meta_socials_code');
		}else{
			$social_codes_output =  met_option('blog_detail_meta_socials_code');
		}

		if($social_codes_markup = explode("\n",$social_codes_output)){
			foreach($social_codes_markup as $social_code_item){
				if($social_code_item_data = explode('|',$social_code_item,2)){
					$social_code_item_data[1] = str_replace('[post-title]',get_the_title($dslc_post_id),$social_code_item_data[1]);
					$social_code_item_data[1] = str_replace('[permalink]',get_permalink($dslc_post_id),$social_code_item_data[1]);

					printf('<a href="%2$s" class="met_color_transition"><i class="fa %1$s"></i></a>',$social_code_item_data[0],$social_code_item_data[1]);
				}
			}
		}
		?>
	</div>
</div>