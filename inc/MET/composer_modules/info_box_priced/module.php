<?php
// Register Module
function register_iboxpriced_module() {
    return dslc_register_module( "MET_InfoBoxPriced" );
}
add_action('dslc_hook_register_modules','register_iboxpriced_module');

class MET_InfoBoxPriced extends DSLC_Module {

    var $module_id = 'MET_InfoBoxPriced';
    var $module_title = 'Standalone Product';
    var $module_icon = 'info';
    var $module_category = 'met - info boxes';

    function options() {

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'Title', 'dslc_string' ),
                'id' => 'title',
                'std' => 'CLICK TO EDIT',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Price Header', 'dslc_string' ),
                'id' => 'price_header',
                'std' => 'Only',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Price', 'dslc_string' ),
                'id' => 'price',
                'std' => '$50',
                'type' => 'text',
                'visibility' => 'hidden'
            ),


            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'image title price_header price',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Image', 'dslc_string' ),
                        'value' => 'image'
                    ),
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Price Header', 'dslc_string' ),
                        'value' => 'price_header'
                    ),
                    array(
                        'label' => __( 'Price', 'dslc_string' ),
                        'value' => 'price'
                    ),
                )
            ),

            /**
             * General Options
             */
			array(
				'label' => __( 'Box Link URL', 'dslc_string' ),
				'id' => 'box_link_url',
				'std' => '#',
				'type' => 'text'
			),
			array(
				'label' => __( 'Open in', 'dslc_string' ),
				'id' => 'box_link_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Same Tab', 'dslc_string' ),
						'value' => '_self',
					),
					array(
						'label' => __( 'New Tab', 'dslc_string' ),
						'value' => '_blank',
					),
				)
			),

            /**
             * Image Options
             */
            array(
                'label' => __( 'Thumbnail', 'dslc_string' ),
                'id' => 'thumbnail_image',
                'std' => '',
                'type' => 'image'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '240',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
        );


        $dslc_options = array_merge(
            $dslc_options,

            // Content Box Background Color
            lc_general('section', '', array('background-color' => ''), 'Box'),

            // Content Box Paddings
            lc_paddings('section', '', array('t' => '25', 'r' => '15', 'b' => '25', 'l' => '15')),

            // Content Image Borders
            lc_borders('section', '', array(), array(), '', '', '' ),

            // Image Borders
            lc_borders('img', 'Image', array(), array(), '', '', '' ),

            // Title
            lc_general('.price_title', 'Title', array('color' => '#FFFFFF','color:hover' => '#000000','font-size' => '30','line-height' => '33', 'font-weight' => '600')),

            // Price Header
            lc_general('.price_header', 'Price Header', array('color' => '#FFFFFF','font-size' => '14','line-height' => '14', 'font-weight' => '400','text-align' => 'center')),

            // Price
            lc_general('.price', 'Price', array('color' => '#FFFFFF','font-size' => '24','line-height' => '24', 'font-weight' => '600','text-align' => 'center'))

        );

        $dslc_options = met_lc_extras($dslc_options, array('animation','parallax'), 'shared_options');

        $dslc_options = array_merge( $dslc_options, $this->presets_options() );
		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

    }

    function output( $options ) {

        global $dslc_active;

        if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
            $dslc_is_admin = true;
        else
            $dslc_is_admin = false;

        $this->module_start( $options );

        $resizedImage = imageResizing($options['thumbnail_image'],$options['thumb_resize_height'],$options['thumb_resize_width_manual']);

        $lbExists = !empty($resizedImage['url']);

        /* Animation */
        

        $met_shared_options = met_lc_extras( $options, array(
            'groups'   => array('animation', 'parallax'),
            'params'   => array(
                'js'           => false,
                'css'          => false,
                'external_run' => false,
                'is_grid'      => false,
            ),
            'is_admin' => $dslc_is_admin,
        ), 'shared_options_output' );

        if ( !$dslc_is_admin && $met_shared_options['activity'] ){
            wp_enqueue_style('metcreative-animate');
            wp_enqueue_script('metcreative-wow');
        }

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();

        $elID = uniqid('infoboxpriced_');

		$boxTagOpen = '<div id="'.$elID.'" class="met_infobox_priced '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].'>';
		$boxTagClose = '</div>';

		if( !empty($options['box_link_url']) ){
			$boxTagOpen = '<a id="'.$elID.'" href="'.$options['box_link_url'].'" class="met_infobox_priced '.$met_shared_options['classes'].'"'.$met_shared_options['data-'].' target="'.$options['box_link_target'].'">';
			$boxTagClose = '</a>';
		}

        ?>

        <?php echo $boxTagOpen ?>
            <?php if( in_array( 'image', $elements ) && $lbExists ) : ?>
                <img src="<?php echo $resizedImage['url'] != '' ? $resizedImage['url'] : $options['thumbnail_image']; ?>" alt="<?php echo stripslashes($options['title']); ?>">
            <?php endif; ?>


            <?php if( in_array( 'title', $elements ) || in_array( 'price_header', $elements ) || in_array( 'price', $elements ) ) : ?>
                <section class="clearfix met_bgcolor">
                    <?php if( in_array( 'title', $elements ) ) : ?>
                        <?php if( $dslc_is_admin ): ?>
                            <span class="price_title pull-left dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></span>
                        <?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
                            <span class="price_title pull-left"><?php echo stripslashes($options['title']); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if( in_array( 'price_header', $elements ) || in_array( 'price', $elements ) ) : ?>
                        <div class="pull-right met_infobox_priced_pricebox">

                            <?php if( in_array( 'price_header', $elements ) ) : ?>
                                <?php if( $dslc_is_admin ): ?>
                                    <span class="price_header dslca-editable-content" data-id="price_header" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['price_header']); ?></span>
                                <?php elseif( !empty($options['price_header'] ) && !$dslc_is_admin): ?>
                                    <span class="price_header"><?php echo stripslashes($options['price_header']); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if( in_array( 'price', $elements ) ) : ?>
                                <?php if( $dslc_is_admin ): ?>
                                    <span class="price dslca-editable-content" data-id="price" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['price']); ?></span>
                                <?php elseif( !empty($options['price'] ) && !$dslc_is_admin): ?>
                                    <span class="price"><?php echo stripslashes($options['price']); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>
		<?php echo $boxTagClose ?>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}