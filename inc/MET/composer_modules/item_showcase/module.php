<?php
// Register Module
function register_itemshowcase_module() {
    return dslc_register_module( "MET_ItemShowcase" );
}
add_action('dslc_hook_register_modules','register_itemshowcase_module');

class MET_ItemShowcase extends DSLC_Module {

    var $module_id = 'MET_ItemShowcase';
    var $module_title = 'Item Showcase';
    var $module_icon = 'camera-retro';
    var $module_category = 'met - general';

    function options() {

        // Options
        $dslc_options = array(
            /**
             * Image Options
             */
            array(
                'label' => __( 'Button Text', 'dslc_string' ),
                'id' => 'see-more-text',
                'std' => 'See More',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Link', 'dslc_string' ),
                'id' => 'see-more-link',
                'std' => 'http://#',
                'type' => 'text'
            ),
            array(
                'label' => __( 'Read More Text', 'dslc_string' ),
                'id' => 'read_more_text',
                'std' => 'Read More',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Item Picture', 'dslc_string' ),
                'id' => 'thumbnail_image',
                'std' => '',
                'type' => 'image'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '269',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '269',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '170',
                'type' => 'text'
            ),

            /* Styling */

            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'button',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Button', 'dslc_string' ),
                        'value' => 'button'
                    ),
                ),
                'section' => 'styling',
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Button
            lc_general('.btn', '', array('color' => '', 'color:hover' => '', 'background-color' => '', 'background-color:hover' => '', 'font-size' => '16','line-height' => '40'))
        );

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
        /* CUSTOM START */
        /**
         * Elements to show
         */

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = 'all';
        ?>
        <div class="met_item_showcase_mockup_wrapper clearfix">
            <?php $resizedImage = imageResizing($options['thumbnail_image'],$options['thumb_resize_height'],$options['thumb_resize_width_manual']); ?>

            <a href="<?php echo $options['see-more-link'] ?>" class="met_item_showcase_mockup" target="_blank">
                <img class="met_item_showcase_image" src="<?php echo $resizedImage['url']; ?>" alt="<?php echo stripslashes($options['see-more-text']); ?>" />
            </a>
            <div class="met_item_showcase_btn_wrap"><a href="<?php echo $options['see-more-link'] ?>" target="_blank" class="btn btn-sm btn-primary dslca-editable-content" <?php if ( $dslc_is_admin ) echo 'contenteditable data-id="see-more-text" data-type="simple"'; ?>><?php echo stripslashes($options['see-more-text']); ?></a></div>

        </div><!-- .met_portfolio_item -->
        <?php
        $this->module_end( $options );
    }

}