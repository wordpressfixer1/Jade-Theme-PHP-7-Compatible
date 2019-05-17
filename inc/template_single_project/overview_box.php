<?php global $dslc_post_id; $project_overview_items = rwmb_meta('met_project_overview_items','',$dslc_post_id); ?>

<div class="met_gray_box">
	<?php

		if(count($project_overview_items) > 0){

			foreach($project_overview_items as $project_overview_item){
				$overview_item_data = explode(':',$project_overview_item,2);

				if( isset($overview_item_data[1]) ){
					$overview_title = $overview_item_data[0];
					$overview_text = $overview_item_data[1];
					$overview_text = str_replace('<a','<a class="met_color2 met_color_transition" ',$overview_text);
				}else{
					$overview_title = $overview_item_data[0];
					$overview_text = '';
				}

				echo '<div class="met_gray_box_line"><h4>'.$overview_title.'</h4>'.((!empty($overview_text)) ? '<span>'.$overview_text.'</span>' : '' ).'</div>';
			}

		}

	?>
</div>