<ul class="met_footer_socials met_clean_list">
	<?php
	$footer_social_codes =  met_option('footer_socials');
	if(count($footer_social_codes) > 0){
		foreach($footer_social_codes as $social_code_item){
			if($social_code_item_data = explode('|',$social_code_item,2)){
				printf('<li><a href="%2$s" class="met_transition met_color_transition2" target="_blank"><i class="fa %1$s"></i></a></li>',$social_code_item_data[0],$social_code_item_data[1]);
			}
		}
	}
	?>
</ul>