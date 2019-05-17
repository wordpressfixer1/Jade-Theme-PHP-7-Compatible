<?php

function get_met_option($type = ''){
    if( empty($type) ) return '';

    $met_option = met_option($type);

    if( empty( $met_option ) ):
        if( $type == 'met_color' ) $met_option = '#FFCA07';
        else if( $type == 'met_color2' && empty( $met_option ) )  $met_option = '#9F4641';
    endif;

    return $met_option;
}

function font_size($type = ''){
    $type = empty($type) ? 'body' : $type;
	$font_size_option = met_option($type.'_font','font-size');
    return null !== $font_size_option || empty($font_size_option) ? '14' : $font_size_option;
}

function line_height($type = ''){
    if(empty($type)){
		$body_font_size_option = met_option('body_font','font-size');
		$body_line_height_option = met_option('body_font','line-height');

        return null !== $body_font_size_option || empty($body_line_height_option) ? '22' : $body_line_height_option;
    }else{

    }
}

function imageResizing($url, $height = '', $width = '', $crop = true){
    $imageSize = '';
    if(!empty($width)){
        $imageSize = 'width: '.$width.'px;';
    }elseif(!empty($height)){
        $imageSize = 'height: '.$height.'px;';
    }

	//if sizing params empty -mrtkrcm
	$res_img = $url;

    if(!empty($width) && !empty($height)){
        $res_img = dslc_aq_resize( $url, $width, $height, $crop );
    }elseif(!empty($width)){
        $res_img = dslc_aq_resize( $url, $width, null, $crop );
    }elseif(!empty($height)){
        $res_img = dslc_aq_resize( $url, null, $height, $crop );
    }

	//if aq_resize failed -mrtkrcm
	if($res_img === false) $res_img = $url;

    $placeholderSize = filter_var($imageSize, FILTER_SANITIZE_NUMBER_INT);
    $placeholderSize = !empty($placeholderSize) ? $placeholderSize : 800;
    if(empty($res_img)) $res_img = 'http://placehold.it/'.$placeholderSize.'x'.$placeholderSize.'&text=Image+Area';


    return array('url' => $res_img, 'sizing' => $imageSize);
}

// get taxonomies terms links
function custom_taxonomies_terms_links($pid, $customLinkAdditions = '', $namesOnly = false){
    // get post by post id
    $post = get_post( $pid );

    // get post type by post
    $post_type = $post->post_type;

    // get post type taxonomies
    $taxonomies = get_object_taxonomies( $post_type, 'objects' );

    $out = array();
    foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy_slug );

        if ( !empty( $terms ) ) {
            foreach ( $terms as $term ) {
                if(!$namesOnly)
                $out[] =
                    '  <a '.$customLinkAdditions.' href="'
                    .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
                    .    $term->name
                    . "</a>";
                else
                    $out[] = $term->name;
            }
        }
    }

    return $out;
}

/**
 * @param $applyTo      Styles to be applied element
 * @param string $tab   LC Tab Name
 * @param array $areas  Areas will be added paddings
 * @return array
 */
function lc_paddings($applyTo, $tab = '', $areas = array('t' => '0', 'r' => '0', 'b' => '0', 'l' => '0')){
    $paddings = array();

    $id = cleanID($applyTo);

    if(!is_array($areas)): $areas = array('t' => $areas, 'r' => $areas, 'b' => $areas, 'l' => $areas); endif;

    foreach($areas as $k => $v){
        switch($k):
            case 't': $k = 'top'; break;
            case 'r': $k = 'right'; break;
            case 'b': $k = 'bottom'; break;
            case 'l': $k = 'left'; break;
        endswitch;

        $returnArray = array(
            'label' => 'Padding '.ucfirst($k),
            'id' => $id.'_padding_'.$k,
            'std' => $v,
            'type' => 'slider',
            'section' => 'styling',
            'refresh_on_change' => false,
            'affect_on_change_el' => $applyTo,
            'affect_on_change_rule' => 'padding-'.$k,
            'ext' => 'px',
            'min' => 0,
            'max' => 300
        );

        if($tab != ''): $returnArray['tab'] = $tab; endif;

        array_push($paddings, $returnArray);
    }
    return $paddings;
}

/**
 * @param $applyTo      Styles to be applied element
 * @param string $tab   LC Tab Name
 * @param array $areas  Areas will be added paddings
 * @return array
 */
function lc_margins($applyTo, $tab = '', $areas = array('t' => '0', 'r' => '0', 'b' => '0', 'l' => '0')){
	$paddings = array();

	$id = cleanID($applyTo);

	if(!is_array($areas)): $areas = array('t' => $areas, 'r' => $areas, 'b' => $areas, 'l' => $areas); endif;

	foreach($areas as $k => $v){
        switch($k):
            case 't': $k = 'top'; break;
            case 'r': $k = 'right'; break;
            case 'b': $k = 'bottom'; break;
            case 'l': $k = 'left'; break;
        endswitch;

		$returnArray = array(
			'label' => 'Margin '.ucfirst($k),
			'id' => $id.'_margin_'.$k,
			'std' => $v,
			'type' => 'slider',
			'section' => 'styling',
			'refresh_on_change' => false,
			'affect_on_change_el' => $applyTo,
			'affect_on_change_rule' => 'margin-'.$k,
			'ext' => 'px',
            'min' => 0,
            'max' => 300
		);

		if($tab != ''): $returnArray['tab'] = $tab; endif;

		array_push($paddings, $returnArray);
	}
	return $paddings;
}

/**
 * @param string $applyTo   Styles to be applied element
 * @param string $tab       LC Tab Name
 * @param array $areas      Create borders by hand,
 *                          !Do not use this if you will use below @params
 *                          Example: array('t' => array('width' => '0', 'color' => '#E8E6E1', 'style' => 'solid'))
 *
 * @param array $exclude    Areas to be excluded
 *                          Example: array('t','r','b','l')
 *
 * @param string $width     Border width value
 * @param string $color     Border color value
 * @param string $style     Border style value
 * @return array
 */
function lc_borders($applyTo, $tab = '', $areas = array(), $exclude = array(), $width = '', $color = '', $style = ''){
    $borders = array();
    $id = cleanID($applyTo);

    $needs = array(
        'type' => array('width' => 'slider', 'color' => 'color', 'style' => 'select'),
        'select' => array('choices' => borderStyles()),
        'slider' => array('ext' => 'px')
    );

    if(empty($areas)){
        $areas =
            array(
                't' => array('width' => '', 'color' => '', 'style' => ''),
                'r' => array('width' => '', 'color' => '', 'style' => ''),
                'b' => array('width' => '', 'color' => '', 'style' => ''),
                'l' => array('width' => '', 'color' => '', 'style' => ''),
            );

        if(!empty($exclude)):
            foreach($exclude as $excluding): unset($areas[$excluding]); endforeach;
        endif;

        foreach($areas as $area => $values){
            foreach($values as $k => $v){
                if(${$k} == '0' || !empty(${$k})):
                    $areas = array_replace_recursive($areas, array($area => array($k => ${$k})));
                endif;
            }
        }
    }

    foreach($areas as $area => $values){
        switch($area):
            case 't': $actualAreaName = 'top'; break;
            case 'r': $actualAreaName = 'right'; break;
            case 'b': $actualAreaName = 'bottom'; break;
            case 'l': $actualAreaName = 'left'; break;
        endswitch;

        foreach($values as $k => $v):
            if(isset($v)){
                $returnArray = array(
                    'label' => 'Border '.ucfirst($actualAreaName).' '.ucfirst($k),
                    'id' => $id.'_border_'.$actualAreaName.'_'.$k,
                    'std' => empty($v) && $k == 'width' ? 0 : $v,
                    'type' => $needs['type'][$k],
                    'section' => 'styling',
                    'refresh_on_change' => false,
                    'affect_on_change_el' => $applyTo,
                    'affect_on_change_rule' => 'border-'.$actualAreaName.'-'.$k,
                );

                switch($needs['type'][$k]):
                    case 'select': $returnArray['choices'] = $needs[$needs['type'][$k]]['choices']; break;
                    case 'slider': $returnArray['ext'] = $needs[$needs['type'][$k]]['ext']; break;
                endswitch;

                if($tab != ''): $returnArray['tab'] = $tab; endif;

                array_push($borders, $returnArray);
            }

        endforeach;
    }

    return $borders;
}

/**
 * @param $applyTo      Styles to be applied element
 * @param string $tab   LC Tab Name
 * @param array $areas  Areas will be applied radius'
 * @return array
 */
function lc_borderRadius($applyTo, $tab = '', $areas = array('tl' => '0', 'tr' => '0', 'br' => '0', 'bl' => '0')){
    $radius = array();

    $id = cleanID($applyTo);

    if(!is_array($areas)): $areas = array('tl' => $areas, 'tr' => $areas, 'br' => $areas, 'bl' => $areas); endif;

    foreach($areas as $k => $v){
        switch($k):
            case 'tl': $k = 'top-left'; break;
            case 'tr': $k = 'top-right'; break;
            case 'br': $k = 'bottom-right'; break;
            case 'bl': $k = 'bottom-left'; break;
        endswitch;

		$border_radius_label = explode('-', $k);

        $returnArray = array(
            'label' => ucfirst($border_radius_label[0]).' '.ucfirst($border_radius_label[1]).' Radius',
            'id' => $id.'_'.str_replace('-','_',$k).'_radius',
            'std' => $v,
            'min' => 0,
            'max' => 100,
            'type' => 'slider',
            'section' => 'styling',
            'refresh_on_change' => false,
            'affect_on_change_el' => $applyTo,
            'affect_on_change_rule' => 'border-'.$k.'-radius',
            'ext' => '%',
        );

        if($tab != ''): $returnArray['tab'] = $tab; endif;

        array_push($radius, $returnArray);
    }
    return $radius;
}

function met_lc_shadows($applyTo, $tab = '', $areas = array(), $options = false){
	$return = array();

	if( !$options ){
		$defaults = array(
			'state' => 'disabled',
			'inset' => '',
			'angle' => 50,
			'distance' => 1,
			'blur' => '4',
			'color' => 'rgba(0,0,0,0.05)'
		);

		if( empty($areas) ){
			$areas = $defaults;
		}else{
			foreach( $defaults as $default => $v ){
				if( !isset( $areas[$default] ) ) $areas[$default] = $v;
			}
		}

		array_push($return, array(
			'label' => __('Status', 'dslc_string' ),
			'id' => 'shadow_state_'.$applyTo,
			'std' => $areas['state'],
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Disabled', 'dslc_string' ),
					'value' => 'disabled'
				),
				array(
					'label' => __( 'Enabled', 'dslc_string' ),
					'value' => 'enabled'
				)
			),
			'section' => 'styling',
			'tab' => $tab,
			'refresh_on_change' => false,
			'affect_on_change_el' => '',
			'affect_on_change_rule' => ''
		));

		array_push($return, array(
			'label' => __('Inset', 'dslc_string' ),
			'id' => 'shadow_inset_'.$applyTo,
			'std' => $areas['inset'],
			'type' => 'select',
			'choices' => array(
				array(
					'label' => __( 'Outer Shadow', 'dslc_string' ),
					'value' => ''
				),
				array(
					'label' => __( 'Inner Shadow', 'dslc_string' ),
					'value' => 'inset'
				)
			),
			'section' => 'styling',
			'tab' => $tab,
			'refresh_on_change' => false,
			'affect_on_change_el' => '',
			'affect_on_change_rule' => ''
		));

		array_push($return, array(
			'label' => __('Angle (Degree)', 'dslc_string' ),
			'id' => 'shadow_angle_'.$applyTo,
			'std' => $areas['angle'],
			'min' => 0,
			'max' => 360,
			'type' => 'slider',
			'section' => 'styling',
			'tab' => $tab,
			'refresh_on_change' => false,
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
			'ext' => 'deg'
		));

		array_push($return, array(
			'label' => __('Distance', 'dslc_string' ),
			'id' => 'shadow_distance_'.$applyTo,
			'std' => $areas['distance'],
			'min' => 0,
			'max' => 100,
			'type' => 'slider',
			'section' => 'styling',
			'tab' => $tab,
			'refresh_on_change' => false,
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
			'ext' => 'px'
		));

		array_push($return, array(
			'label' => __('Blur', 'dslc_string' ),
			'id' => 'shadow_blur_'.$applyTo,
			'std' => $areas['blur'],
			'min' => 0,
			'max' => 100,
			'type' => 'slider',
			'section' => 'styling',
			'tab' => $tab,
			'refresh_on_change' => false,
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
			'ext' => 'px'
		));

		array_push($return, array(
			'label' => __('Color', 'dslc_string' ),
			'id' => 'shadow_color_'.$applyTo,
			'std' => $areas['color'],
			'type' => 'color',
			'section' => 'styling',
			'tab' => $tab,
			'refresh_on_change' => false,
			'affect_on_change_el' => '',
			'affect_on_change_rule' => ''
		));

	}else{

		if( $options['shadow_state_'.$applyTo] == 'disabled' ) return '';

		$angle = str_replace('deg','', $options['shadow_angle_'.$applyTo]);
		$distance = str_replace('px','', $options['shadow_distance_'.$applyTo]);
		$blur = str_replace('px','', $options['shadow_blur_'.$applyTo]);
		$color = $options['shadow_color_'.$applyTo];
		$inset = $options['shadow_inset_'.$applyTo];

		$angle   = $angle*((pi())/180);
		$x       = round($distance * cos($angle));
		$y       = round($distance * sin($angle));
		$blur    = round($blur);
		$spread  = 0;
		$return = 'box-shadow: '.$inset.' ' . $x .'px '. $y .'px '. $blur .'px '. $spread .'px '. $color.';';

	}

	return $return;
}

function lc_general($applyTo, $tab = '', $areas = array(), $label = ''){
    $css = array();

    foreach($areas as $k => $v){

        $id = cleanID($applyTo.'|'.$k);

        $name = str_replace('-',' ',$k);

        if( is_numeric(strpos($k,':')) && strpos($k,':') !== false ):
			$state_k = explode(':',$k);
            $state = $state_k[1];

            $onChangeEl = $applyTo.':'.$state;

            if( is_numeric(strpos($onChangeEl, ',')) )
                $onChangeEl = str_replace(',', ':'.$state.',', $onChangeEl);

            $k = $state_k[0];

			$name_explode = explode(':', $name);

            $name = $state.' '.$name_explode[0];
        else:
            $onChangeEl = $applyTo;
        endif;

        $name = ucwords($name);

        if(!empty($label) && $k != 'icon'):
            $name = $label.' '.$name;
        elseif(!empty($label) && $k == 'icon'):
            $name = $label;
        endif;

        $ext = 'px';
        if( strpos($v, '_%') !== false ){
            $ext = '%';
            $v = str_replace( '_%', '', $v );
        }

        if( is_numeric(strpos($k,'color')) || $k == 'text-shadow' ){
            $type = 'color';
        }elseif( strpos($k, 'width') !== false || strpos($k, 'height') !== false || strpos($k, 'font-size') !== false || $ext == '%' ){
            $type = 'slider';
        }else{
            switch($k):
                case 'icon'           : $type = 'icon';   break;
                case 'font-family'    : $type = 'font';   break;
                case 'text-align'   ||
                      'float'       ||
                      'font-weight'   : $type = 'select'; break;
                default               : $type = 'text';   break;
            endswitch;
        }

        $returnArray = array(
            'label' => $name,
            'id' => $id,
            'std' => $v == '' ? '!' : $v,
            'type' => $type,
            'section' => 'styling',
            'refresh_on_change' => false,
            'affect_on_change_el' => $onChangeEl,
            'affect_on_change_rule' => $k,
        );

        switch($k):
            case 'text-align':
                $returnArray['choices'] = array(
                    array(
                        'label' => __( 'Left', 'dslc_string' ),
                        'value' => 'left',
                    ),
                    array(
                        'label' => __( 'Center', 'dslc_string' ),
                        'value' => 'center'
                    ),
                    array(
                        'label' => __( 'Right', 'dslc_string' ),
                        'value' => 'right'
                    ),
                );
            break;
            case 'float':
                $returnArray['choices'] = array(
                    array(
                        'label' => __( 'Left', 'dslc_string' ),
                        'value' => 'left',
                    ),
                    array(
                        'label' => __( 'Right', 'dslc_string' ),
                        'value' => 'right'
                    ),
                );
            break;
            case 'font-weight':
                $returnArray['choices'] = array(
                    array(
                        'label' => __( 'Thinner', 'dslc_string' ),
                        'value' => '100',
                    ),
                    array(
                        'label' => __( 'Thin', 'dslc_string' ),
                        'value' => '300',
                    ),
                    array(
                        'label' => __( 'Normal', 'dslc_string' ),
                        'value' => '400'
                    ),
                    array(
                        'label' => __( 'Bold', 'dslc_string' ),
                        'value' => '600'
                    ),
                    array(
                        'label' => __( 'Bolder', 'dslc_string' ),
                        'value' => '700'
                    ),
                );
            break;
        endswitch;

        switch($type):
            case 'icon':
                unset($returnArray['affect_on_change_el'],$returnArray['affect_on_change_rule'],$returnArray['refresh_on_change']);
            break;
            case 'slider':
                $returnArray['ext'] = $ext; $returnArray['max'] = 200;
            break;
        endswitch;

        if($tab != ''): $returnArray['tab'] = $tab; endif;

        array_push($css, $returnArray);
    }
    return $css;
}

function cleanID($applyTo){

    $tail = '';
    if( is_numeric(strpos($applyTo,'|')) ){
		$applyTo_explode = explode('|',$applyTo);
		$tail = $applyTo_explode[1];
	}


    if( is_numeric(strpos($applyTo,',')) ){
		$applyTo_explode = explode(',', $applyTo);
        $applyTo = $applyTo_explode[0];

        if(!empty($tail))
            $applyTo = $applyTo.'_'.$tail;
    }else{
        $applyTo = str_replace('|','_',$applyTo);
    }

    $id = substr($applyTo,1);
    $id = str_replace(' ','_',$id);
    $id = str_replace(array('>', '.', '#', ':', '-'), '_',$id);

    return $id;
}

function categoryArgs($type = 'post', $categories = '', $forListing = 0){

    $stack = array(
        'post' => array(
            'label' => 'Posts',
            'cat' => ''
        ),
        'dslc_projects' => array(
            'label' => 'Projects',
            'cat' => 'dslc_projects_cats'
        ),/*
        'dslc_galleries' => array(
            'label' => 'Galleries',
            'cat' => 'dslc_galleries_cats'
        ),*/
        'dslc_staff' => array(
            'label' => 'Staff',
            'cat' => 'dslc_staff_cats'
        ),
        'dslc_downloads' => array(
            'label' => 'Downloads',
            'cat' => 'dslc_downloads_cats'
        ),
        'dslc_testimonials' => array(
            'label' => 'Testimonials',
            'cat' => 'dslc_testimonials_cats'
        ),
        'dslc_partners' => array(
            'label' => 'Partners',
            'cat' => 'dslc_partners_cats'
        ),
        'tribe_events' => array(
            'label' => 'Events',
            'cat' => 'tribe_events_cat'
        ),
    );

    if($forListing === 1){
        $listingStack = [];
        foreach($stack as $k => $v) $listingStack[] = array('label' => $v['label'], 'value' => $k);

		$stack = ($categories == 'single') ? $stack[$type] : $listingStack;
    }else{
        if(strpos($categories, ',') > 0)
            $categories = explode(',', $categories);

        if($stack[$type]['cat'] == ''){

            $stack = [];
            $stack['category__in'] = $categories;

        }elseif(!empty($categories)){

            $tax_query['tax_query'][0] = array(
                'taxonomy' => $stack[$type]['cat'],
                'field' => 'id',
                'terms' => $categories,
                'operator' => 'IN'
            );
            $stack = '';
            $stack = $tax_query;

        }else{$stack = array();}
    }

    return $stack;
}

function borderStyles(){
    return array(
	    array(
		    'label' => 'None',
		    'value' => 'none'
	    ),
        array(
            'label' => 'Solid',
            'value' => 'solid',
        ),
        array(
            'label' => 'Dotted',
            'value' => 'dotted'
        ),
        array(
            'label' => 'Dashed',
            'value' => 'dashed'
        ),
        array(
            'label' => 'Double',
            'value' => 'double'
        ),
        array(
            'label' => 'Groove',
            'value' => 'groove'
        ),
        array(
            'label' => 'Ridge',
            'value' => 'ridge'
        ),
        array(
            'label' => 'Inset',
            'value' => 'inset'
        ),
        array(
            'label' => 'Outset',
            'value' => 'outset'
        ),
    );
}

function met_lc_animations(){
	return array(
		array(
			'label'   => 'On Load Animation',
			'id'      => 'met_css_anim',
			'std'     => 'none',
			'type'    => 'select',
			'section' => 'styling',
			'tab'     => 'animation',
			'choices' => array(
				array(
					'label' => 'None',
					'value' => 'none'
				),
				array(
					'label' => 'bounce',
					'value' => 'bounce'
				),
				array(
					'label' => 'flash',
					'value' => 'flash'
				),
				array(
					'label' => 'pulse',
					'value' => 'pulse'
				),
				array(
					'label' => 'rubberBand',
					'value' => 'rubberBand'
				),
				array(
					'label' => 'shake',
					'value' => 'shake'
				),
				array(
					'label' => 'swing',
					'value' => 'swing'
				),
				array(
					'label' => 'tada',
					'value' => 'tada'
				),
				array(
					'label' => 'wobble',
					'value' => 'wobble'
				),
				array(
					'label' => 'bounceIn',
					'value' => 'bounceIn'
				),
				array(
					'label' => 'bounceInDown',
					'value' => 'bounceInDown'
				),
				array(
					'label' => 'bounceInLeft',
					'value' => 'bounceInLeft'
				),
				array(
					'label' => 'bounceInRight',
					'value' => 'bounceInRight'
				),
				array(
					'label' => 'bounceInUp',
					'value' => 'bounceInUp'
				),
				array(
					'label' => 'fadeIn',
					'value' => 'fadeIn'
				),
				array(
					'label' => 'fadeInDown',
					'value' => 'fadeInDown'
				),
				array(
					'label' => 'fadeInDownBig',
					'value' => 'fadeInDownBig'
				),
				array(
					'label' => 'fadeInLeft',
					'value' => 'fadeInLeft'
				),
				array(
					'label' => 'fadeInLeftBig',
					'value' => 'fadeInLeftBig'
				),
				array(
					'label' => 'fadeInRight',
					'value' => 'fadeInRight'
				),
				array(
					'label' => 'fadeInRightBig',
					'value' => 'fadeInRightBig'
				),
				array(
					'label' => 'fadeInUp',
					'value' => 'fadeInUp'
				),
				array(
					'label' => 'fadeInUpBig',
					'value' => 'fadeInUpBig'
				),
				array(
					'label' => 'flip',
					'value' => 'flip'
				),
				array(
					'label' => 'flipInX',
					'value' => 'flipInX'
				),
				array(
					'label' => 'flipInY',
					'value' => 'flipInY'
				),
				array(
					'label' => 'lightSpeedIn',
					'value' => 'lightSpeedIn'
				),
				array(
					'label' => 'rotateIn',
					'value' => 'rotateIn'
				),
				array(
					'label' => 'rotateInDownLeft',
					'value' => 'rotateInDownLeft'
				),
				array(
					'label' => 'rotateInDownRight',
					'value' => 'rotateInDownRight'
				),
				array(
					'label' => 'rotateInUpLeft',
					'value' => 'rotateInUpLeft'
				),
				array(
					'label' => 'rotateInUpRight',
					'value' => 'rotateInUpRight'
				),
				array(
					'label' => 'hinge',
					'value' => 'hinge'
				),
				array(
					'label' => 'rollIn',
					'value' => 'rollIn'
				),
				array(
					'label' => 'zoomIn',
					'value' => 'zoomIn'
				),
				array(
					'label' => 'zoomInDown',
					'value' => 'zoomInDown'
				),
				array(
					'label' => 'zoomInLeft',
					'value' => 'zoomInLeft'
				),
				array(
					'label' => 'zoomInRight',
					'value' => 'zoomInRight'
				),
				array(
					'label' => 'zoomInUp',
					'value' => 'zoomInUp'
				)
			)
		),
		array(
			'label'   => 'On Load Animation - Speed ( ms )',
			'id'      => 'met_css_anim_duration',
			'std'     => '1000',
			'type'    => 'text',
			'section' => 'styling',
			'tab'     => 'animation'
		),
		array(
			'label'   => 'On Load Animation - Delay ( ms )',
			'id'      => 'met_css_anim_delay',
			'std'     => '0',
			'type'    => 'text',
			'section' => 'styling',
			'tab'     => 'animation'
		),
		array(
			'label'   => 'Delay Increment ( ms )',
			'id'      => 'met_css_anim_delay_increment',
			'std'     => '0',
			'type'    => 'text',
			'section' => 'styling',
			'help'    => 'Only Available for Some Modules',
			'tab'     => 'animation'
		),
		array(
			'label'   => 'On Load Animation - Offset ( px )',
			'id'      => 'met_css_anim_offset',
			'std'     => '250',
			'type'    => 'text',
			'section' => 'styling',
			'tab'     => 'animation'
		),
		array(
			'label'   => __( 'Activation', 'dslc_string' ),
			'id'      => 'parallax_activation',
			'std'     => 'disabled',
			'type'    => 'select',
			'section' => 'styling',
			'tab'     => 'Parallax',
			'choices' => array(
				array(
					'label' => __( 'Disabled', 'dslc_string' ),
					'value' => 'disabled'
				),
				array(
					'label' => __( 'Enabled', 'dslc_string' ),
					'value' => 'enabled'
				),
			),
			'help'    => __( 'Please click Confirm when you change this or you may not see your changes.', 'dslc_string' )
		),
		array(
			'label'             => __( 'Parallax Speed', 'dslc_string' ),
			'id'                => 'parallax_speed',
			'std'               => '1',
			'type'              => 'select',
			'section'           => 'styling',
			'tab'               => 'Parallax',
			'choices'           => array(
				array('label' => '0.1 (Slowest)', 'value' => '0.1'),
				array('label' => '0.2', 'value' => '0.2'),
				array('label' => '0.3', 'value' => '0.3'),
				array('label' => '0.4', 'value' => '0.4'),
				array('label' => '0.5 (Half-Speed)', 'value' => '0.5'),
				array('label' => '0.6', 'value' => '0.6'),
				array('label' => '0.7', 'value' => '0.7'),
				array('label' => '0.8', 'value' => '0.8'),
				array('label' => '0.9', 'value' => '0.9'),
				array('label' => '1.0 (Natural)', 'value' => '1'),
				array('label' => '1.1', 'value' => '1.1'),
				array('label' => '1.2', 'value' => '1.2'),
				array('label' => '1.3', 'value' => '1.3'),
				array('label' => '1.4', 'value' => '1.4'),
				array('label' => '1.5', 'value' => '1.5'),
				array('label' => '1.6', 'value' => '1.6'),
				array('label' => '1.7', 'value' => '1.7'),
				array('label' => '1.8', 'value' => '1.8'),
				array('label' => '1.9', 'value' => '1.9'),
				array('label' => '2 (Fastest)', 'value' => '2'),
			),
			'refresh_on_change' => true,
			'help'              => __( 'Moving speed of the element is relative to the scroll speed.', 'dslc_string' ),
		),
		array(
			'label'   => __( 'Vertical Offset', 'dslc_string' ),
			'id'      => 'parallax_vertical_offset',
			'std'     => '0',
			'type'    => 'text',
			'section' => 'styling',
			'tab'     => 'Parallax',
			'help'    => __( 'All elements will return to their original positioning when their offset parent meets the edge of the screen plus or minus your own optional offset.', 'dslc_string' ),
		),
		array(
			'label'   => __( 'Horizontal Position', 'dslc_string' ),
			'id'      => 'parallax_horizontal_position',
			'std'     => '0',
			'type'    => 'text',
			'section' => 'styling',
			'tab'     => 'Parallax',
			'refresh_on_change' => true,
			'affect_on_change_el' => '',
			'affect_on_change_rule' => '',
			//'ext'     => 'px'
		),
	);
}

function met_lc_hover_effects($return_type = ''){
	$return = array();
	$values = array('mixed','lily','sadie','roxy','bubba','romeo','layla','honey','oscar','marley','ruby','milo','dexter','sarah','chico');

	if( empty($return_type) )
		 foreach($values as $v) $return[] = array('label' => ucfirst($v),'value' => $v);
	else{ foreach($values as $v) $return[] = $v; array_shift($return);}

	return $return;
}

/**
 * @param $admin_state          Is Live Composer Active?
 * @param $animation            Chosen Animation Name
 * @param $duration             Animation Duration
 * @param $offset               Animation Offset
 * @param bool $appendJs        Some other fuction will include file and fire function with another control
 * @param bool $appendCss       Same as $appendJs
 * @param bool $externalRun     Some other function will make animation
 * @param bool $thisIsGrid      Isotope Grid needs some special treatment
 * @return array                Gathered data will be used in modules
 */
function oldanim( $pac, $pas, $pav, $admin_state, $animation, $duration, $delay, $offset, $appendJs = false, $appendCss = false, $externalRun = false, $thisIsGrid = false ){
    $return             = array();
    $template_dir       = get_template_directory_uri();
    $return['animation']= $animation;
    $return['activity'] = $animation != 'none';
    $return['js']       = $appendJs ? '' : '[]';
    $return['class']    = $return['classes'] = $return['css'] = $return['script'] = $return['data-'] = $return['grid_check'] = $return['uniqueClass'] = '';

    // Prepare Classes
    $return['class']        = (!$externalRun && !$admin_state ? 'met_run_animations' :
                              (!$appendJs  ? uniqid('met_animate_single_') : ''));
    $return['grid_check']   = $thisIsGrid ? '' : 'met_css_anim_show_first';
    $return['uniqueClass']  = $thisIsGrid ? uniqid('met_') : '';
    $return['classes']      = $return['activity'] ? $return['class'].' '.$return['grid_check'].' '.$return['animation'] : '';

    // Prepare Files
    if( $admin_state && $return['activity'] ){

        $return['js'] = $template_dir.'/js/wow.min.js';
        $return['js'] = !$appendJs ? '["'.$return['js'].'"]' : ',"'.$return['js'].'"';

        $return['css'] = $template_dir.'/css/animate.min.css|metcreative-animate-css';
        $return['css'] = !$appendCss ? '["'.$return['css'].'"]' : ',"'.$return['css'].'"';

        // Prepare Script Tag
        $return['script'] = $return['css'] != '' ? 'CoreJS.loadStylesheet('.$return['css'].');' : '';
    }

    if( $return['activity'] ){

        $return['grid_check'] = $return['grid_check'] == '' && $thisIsGrid ? 'met_anim_grid' : '';

        if( $return['class'] != 'met_run_animations' ){
            $return['script'] .= !empty($return['class']) ? 'CoreJS.loadAsync('.$return['js'].',["wowAnimate|'.$return['class'].'"]);' : '';
            $return['script'] = !empty($return['script']) ? '<script>jQuery(function(){'.$return['script'].'});</script>' : '';

        }

        // Prepare Data Attributes
        $return['data-'] = 'data-wow-iteration="1"';
        $return['data-'] .= ' data-wow-duration="'.( empty($duration) ? 0 : $duration / 1000 ).'s"';
        $return['data-'] .= ' data-wow-delay="'.( empty($delay) ? 0 : $delay / 1000 ).'s"';
        $return['data-'] .= ' data-wow-offset="'.( empty($offset) ? 0 : preg_replace("/[^0-9]/","",$offset) ).'"';
        $return['data-'] .= ' data-wow-animation="'.$return['animation'].'"';

    }

    if( $pac == 'enabled' && !$thisIsGrid ){
        $return['data-'] .= ' data-met-core-parallax-element data-stellar-element data-stellar-ratio="'.$pas.'"';
        $return['data-'] .= 'data-stellar-vertical-offset="'.$pav.'"';
    }

    return $return;
}
	function met_lc_shared_options($option_group = null){

		$shared_options = array(
			'animation' => array(
				array(
					'label'   => 'On Load Animation',
					'id'      => 'met_css_anim',
					'std'     => 'none',
					'type'    => 'select',
					'section' => 'styling',
					'tab'     => 'animation',
					'choices' => array(
						array(
							'label' => 'None',
							'value' => 'none'
						),
						array(
							'label' => 'bounce',
							'value' => 'bounce'
						),
						array(
							'label' => 'flash',
							'value' => 'flash'
						),
						array(
							'label' => 'pulse',
							'value' => 'pulse'
						),
						array(
							'label' => 'rubberBand',
							'value' => 'rubberBand'
						),
						array(
							'label' => 'shake',
							'value' => 'shake'
						),
						array(
							'label' => 'swing',
							'value' => 'swing'
						),
						array(
							'label' => 'tada',
							'value' => 'tada'
						),
						array(
							'label' => 'wobble',
							'value' => 'wobble'
						),
						array(
							'label' => 'bounceIn',
							'value' => 'bounceIn'
						),
						array(
							'label' => 'bounceInDown',
							'value' => 'bounceInDown'
						),
						array(
							'label' => 'bounceInLeft',
							'value' => 'bounceInLeft'
						),
						array(
							'label' => 'bounceInRight',
							'value' => 'bounceInRight'
						),
						array(
							'label' => 'bounceInUp',
							'value' => 'bounceInUp'
						),
						array(
							'label' => 'fadeIn',
							'value' => 'fadeIn'
						),
						array(
							'label' => 'fadeInDown',
							'value' => 'fadeInDown'
						),
						array(
							'label' => 'fadeInDownBig',
							'value' => 'fadeInDownBig'
						),
						array(
							'label' => 'fadeInLeft',
							'value' => 'fadeInLeft'
						),
						array(
							'label' => 'fadeInLeftBig',
							'value' => 'fadeInLeftBig'
						),
						array(
							'label' => 'fadeInRight',
							'value' => 'fadeInRight'
						),
						array(
							'label' => 'fadeInRightBig',
							'value' => 'fadeInRightBig'
						),
						array(
							'label' => 'fadeInUp',
							'value' => 'fadeInUp'
						),
						array(
							'label' => 'fadeInUpBig',
							'value' => 'fadeInUpBig'
						),
						array(
							'label' => 'flip',
							'value' => 'flip'
						),
						array(
							'label' => 'flipInX',
							'value' => 'flipInX'
						),
						array(
							'label' => 'flipInY',
							'value' => 'flipInY'
						),
						array(
							'label' => 'lightSpeedIn',
							'value' => 'lightSpeedIn'
						),
						array(
							'label' => 'rotateIn',
							'value' => 'rotateIn'
						),
						array(
							'label' => 'rotateInDownLeft',
							'value' => 'rotateInDownLeft'
						),
						array(
							'label' => 'rotateInDownRight',
							'value' => 'rotateInDownRight'
						),
						array(
							'label' => 'rotateInUpLeft',
							'value' => 'rotateInUpLeft'
						),
						array(
							'label' => 'rotateInUpRight',
							'value' => 'rotateInUpRight'
						),
						array(
							'label' => 'hinge',
							'value' => 'hinge'
						),
						array(
							'label' => 'rollIn',
							'value' => 'rollIn'
						),
						array(
							'label' => 'zoomIn',
							'value' => 'zoomIn'
						),
						array(
							'label' => 'zoomInDown',
							'value' => 'zoomInDown'
						),
						array(
							'label' => 'zoomInLeft',
							'value' => 'zoomInLeft'
						),
						array(
							'label' => 'zoomInRight',
							'value' => 'zoomInRight'
						),
						array(
							'label' => 'zoomInUp',
							'value' => 'zoomInUp'
						)
					)
				),
				array(
					'label'   => 'On Load Animation - Speed ( ms )',
					'id'      => 'met_css_anim_duration',
					'std'     => '1000',
					'type'    => 'text',
					'section' => 'styling',
					'tab'     => 'animation'
				),
				array(
					'label'   => 'On Load Animation - Delay ( ms )',
					'id'      => 'met_css_anim_delay',
					'std'     => '0',
					'type'    => 'text',
					'section' => 'styling',
					'tab'     => 'animation'
				),
				array(
					'label'   => 'Delay Increment ( ms )',
					'id'      => 'met_css_anim_delay_increment',
					'std'     => '0',
					'type'    => 'text',
					'section' => 'styling',
					'tab'     => 'animation'
				),
				array(
					'label'   => 'On Load Animation - Offset ( px )',
					'id'      => 'met_css_anim_offset',
					'std'     => '250',
					'type'    => 'text',
					'section' => 'styling',
					'tab'     => 'animation'
				)
			),

			'parallax' => array(
				array(
					'label'   => __( 'Activation', 'dslc_string' ),
					'id'      => 'parallax_activation',
					'std'     => 'disabled',
					'type'    => 'select',
					'section' => 'styling',
					'tab'     => 'Parallax',
					'choices' => array(
						array(
							'label' => __( 'Disabled', 'dslc_string' ),
							'value' => 'disabled'
						),
						array(
							'label' => __( 'Enabled', 'dslc_string' ),
							'value' => 'enabled'
						),
					),
					'help'    => __( 'Please click Confirm when you change this or you may not see your changes.', 'dslc_string' )
				),
				array(
					'label'             => __( 'Parallax Speed', 'dslc_string' ),
					'id'                => 'parallax_speed',
					'std'               => '1',
					'type'              => 'select',
					'section'           => 'styling',
					'tab'               => 'Parallax',
					'choices'           => array(
						array('label' => '0.1 (Slowest)', 'value' => '0.1'),
						array('label' => '0.2', 'value' => '0.2'),
						array('label' => '0.3', 'value' => '0.3'),
						array('label' => '0.4', 'value' => '0.4'),
						array('label' => '0.5 (Half-Speed)', 'value' => '0.5'),
						array('label' => '0.6', 'value' => '0.6'),
						array('label' => '0.7', 'value' => '0.7'),
						array('label' => '0.8', 'value' => '0.8'),
						array('label' => '0.9', 'value' => '0.9'),
						array('label' => '1.0 (Natural)', 'value' => '1'),
						array('label' => '1.1', 'value' => '1.1'),
						array('label' => '1.2', 'value' => '1.2'),
						array('label' => '1.3', 'value' => '1.3'),
						array('label' => '1.4', 'value' => '1.4'),
						array('label' => '1.5', 'value' => '1.5'),
						array('label' => '1.6', 'value' => '1.6'),
						array('label' => '1.7', 'value' => '1.7'),
						array('label' => '1.8', 'value' => '1.8'),
						array('label' => '1.9', 'value' => '1.9'),
						array('label' => '2 (Fastest)', 'value' => '2'),
					),
					'refresh_on_change' => true,
					'help'              => __( 'Moving speed of the element is relative to the scroll speed.', 'dslc_string' ),
				),
				array(
					'label'   => __( 'Vertical Offset', 'dslc_string' ),
					'id'      => 'parallax_vertical_offset',
					'std'     => '0',
					'type'    => 'text',
					'section' => 'styling',
					'tab'     => 'Parallax',
					'help'    => __( 'All elements will return to their original positioning when their offset parent meets the edge of the screen plus or minus your own optional offset.', 'dslc_string' ),
				),

				array(
					'label' => __( 'Position (X)', 'dslc_string' ),
					'id' => 'parallax_pos_x',
					'std' => '0',
					'section' => 'styling',
					'tab'     => 'Parallax',
					'type' => 'slider',
					'refresh_on_change' => true,
					'affect_on_change_el' => '',
					'affect_on_change_rule' => '',
					'min' => '0',
					'max' => '100',
					'ext' => '%',
				),
				array(
					'label' => __( 'Position (Y)', 'dslc_string' ),
					'id' => 'parallax_pos_y',
					'std' => '0',
					'section' => 'styling',
					'tab'     => 'Parallax',
					'type' => 'slider',
					'refresh_on_change' => true,
					'affect_on_change_el' => '',
					'affect_on_change_rule' => '',
					'min' => '0',
					'max' => '100',
					'ext' => '%',
				),
				array(
					'label' => __( 'Position (Z)', 'dslc_string' ),
					'id' => 'parallax_pos_z',
					'std' => '0',
					'section' => 'styling',
					'tab'     => 'Parallax',
					'type' => 'slider',
					'refresh_on_change' => true,
					'affect_on_change_el' => '',
					'affect_on_change_rule' => '',
					'min' => '0',
					'max' => '100',
					'ext' => '',
				),
			)
		);

		return $shared_options[$option_group];
	}

	function met_lc_extras( $options = array(), $vars = array(), $action = null ){
		$return = array();
		$template_dir        = get_template_directory_uri();

		switch ($action) {

			//Shared Options
			case 'shared_options':

				if( is_array($vars) ){
					$shared_options = array();

					foreach($vars as $option_group){
						foreach(met_lc_shared_options($option_group) as $option){
							$shared_options[] = $option;
						}
					}
				}

				$return = array_merge($options, $shared_options);

				break;

			//Shared Options Output
			case 'shared_options_output':
				$return['class']     = $return['classes'] = $return['css'] = $return['script'] = $return['data-'] = $return['grid_check'] = $return['uniqueClass'] = $return['data-'] = '';

				if( in_array('animation', $vars['groups']) ){
					$return['animation'] = $options['met_css_anim'];
					$return['activity']  = $options['met_css_anim'] != 'none';
					$return['js']        = $vars['params']['js'] ? '' : '[]';

					// Prepare Classes
					$return['class']       = ( !$vars['params']['external_run'] && !$vars['is_admin'] ? 'met_run_animations' : ( !$vars['params']['js'] ? uniqid( 'met_animate_single_' ) : '' ) );
					$return['grid_check']  = $vars['params']['is_grid'] ? '' : 'met_css_anim_show_first';
					$return['uniqueClass'] = $vars['params']['is_grid'] ? uniqid( 'met_' ) : '';
					$return['classes']     = $return['activity'] ? $return['class'] . ' ' . $return['grid_check'] . ' ' . $return['animation'] : '';

					// Prepare Files
					if( $vars['is_admin'] && $return['activity'] ){

						$return['js'] = $template_dir.'/js/wow.min.js';
						$return['js'] = !$vars['params']['js'] ? '["'.$return['js'].'"]' : ',"'.$return['js'].'"';

						$return['css'] = $template_dir.'/css/animate.min.css|metcreative-animate-css';
						$return['css'] = !$vars['params']['css'] ? '["'.$return['css'].'"]' : ',"'.$return['css'].'"';

						// Prepare Script Tag
						$return['script'] = $return['css'] != '' ? 'CoreJS.loadStylesheet('.$return['css'].');' : '';
					}

					if( $return['activity'] ){

						$return['grid_check'] = $return['grid_check'] == '' && $vars['params']['is_grid'] ? 'met_anim_grid' : '';

						if( $return['class'] != 'met_run_animations' ){
							$return['script'] .= !empty($return['class']) ? 'CoreJS.loadAsync('.$return['js'].',["wowAnimate|'.$return['class'].'"]);' : '';
							$return['script'] = !empty($return['script']) ? '<script>jQuery(function(){'.$return['script'].'});</script>' : '';

						}

						// Prepare Data Attributes
						$return['data-'] .= ' data-wow-iteration="1"';
						$return['data-'] .= ' data-wow-duration="'.( empty($options['met_css_anim_duration']) ? 0 : $options['met_css_anim_duration'] / 1000 ).'s"';
						$return['data-'] .= ' data-wow-delay="'.( empty($options['met_css_anim_delay']) ? 0 : $options['met_css_anim_delay'] / 1000 ).'s"';
						$return['data-'] .= ' data-wow-offset="'.( empty($options['met_css_anim_offset']) ? 0 : preg_replace("/[^0-9]/","",$options['met_css_anim_offset']) ).'"';
						$return['data-'] .= ' data-wow-animation="'.$return['animation'].'"';

					}
				}

				if( in_array('parallax', $vars['groups']) ){
					if( $options['parallax_activation'] == 'enabled' && !$vars['params']['is_grid'] ){
						$return['data-'] .= ' data-met-core-parallax-element data-stellar-element data-stellar-ratio="'.$options['parallax_speed'].'"';
						$return['data-'] .= 'data-stellar-vertical-offset="'.$options['parallax_vertical_offset'].'"';

						$return['data-'] .= 'data-pos-x="'.$options['parallax_pos_x'].'"';
						$return['data-'] .= 'data-pos-y="'.$options['parallax_pos_y'].'"';
						$return['data-'] .= 'data-pos-z="'.$options['parallax_pos_z'].'"';
					}
				}

				break;
		}

		return $return;
	}

//mrtrkcm
function lc_rgb_to_hex($rgb){

	if(substr($rgb,0,1) == '#') return $rgb; // if its already hex

	$rgb = explode(',',$rgb);
	if(!$rgb) return $rgb;

	$R = str_replace('rgb(','',$rgb[0]);
	$G = $rgb[1];
	$B = str_replace(')','',$rgb[2]);

	$R=dechex($R);
	If (strlen($R)<2)
		$R='0'.$R;

	$G=dechex($G);
	If (strlen($G)<2)
		$G='0'.$G;

	$B=dechex($B);
	If (strlen($B)<2)
		$B='0'.$B;

	return '#' . $R . $G . $B;

}

//mrtkrcm
function lc_clean_rgb ($rgb){

	if(strpos($rgb,'gb(') > 0){
		$rgb = str_replace('rgb(','',$rgb);
		$rgb = str_replace(')','',$rgb);
	}


	return $rgb;
}