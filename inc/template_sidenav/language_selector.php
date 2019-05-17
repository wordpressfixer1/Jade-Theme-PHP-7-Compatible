<?php
$languages = icl_get_languages('skip_missing=0&orderby=code');
if(!empty($languages)):

	//Get active language
	foreach($languages as $l){
		if($l['active']){
			$activeLang = $l;
		}
	}
	?>

	<div class="met_header_language pull-right">
		<a href="<?php echo $activeLang['url'] ?>" class="met_active_language">
			<img src="<?php echo $activeLang['country_flag_url'] ?>" alt="<?php echo $activeLang['language_code'] ?>" /> <span><?php echo icl_disp_language($activeLang['native_name'], $activeLang['translated_name']) ?></span> <i class="fa fa-sort-down"></i>
		</a>

		<?php
		echo '<ul class="met_clean_list">';
		foreach($languages as $l){
			echo '<li>';
			if(!$l['active']) echo '<a href="'.$l['url'].'">';
			echo icl_disp_language($l['native_name'], $l['translated_name']);

			if($l['country_flag_url']){
				echo '<img src="'.$l['country_flag_url'].'" alt="'.$l['language_code'].'" />';
			}

			if(!$l['active']) echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
		?>
	</div>
<?php endif; ?>