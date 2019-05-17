<?php
    $socials_wrapper_class = '';
	if(met_option('header_layout') == 1){
		$socials_wrapper_class = 'met_vcenter met_header_box_right hidden-768';
	}elseif(met_option('header_layout') != 4){
		$socials_wrapper_class = 'pull-left';
	}

?>
<div class="met_header_socials <?php echo $socials_wrapper_class ?>"><?php echo met_option('header_socials') ?></div>