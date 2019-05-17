<?php

// Register Module
function register_prodlists_module() {
	return dslc_register_module( "MET_ProductsList" );
}
add_action('dslc_hook_register_modules','register_prodlists_module');

class MET_ProductsList extends DSLC_Module {

    var $module_id = 'MET_ProductsList';
    var $module_title = 'Products List';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

		$cats = get_terms( 'product_cat' );
		$cats_choices = array();

		if ( $cats ) {
			foreach ( $cats as $cat ) {
				$cats_choices[] = array(
					'label' => $cat->name,
					'value' => $cat->slug
				);
			}
		}

        $dslc_options = array(
			array(
				'label' => __( 'Categories', 'dslc_string' ),
				'id' => 'categories',
				'std' => '',
				'type' => 'checkbox',
				'choices' => $cats_choices
			),
			array(
				'label' => __( 'Product Limit', 'dslc_string' ),
				'id' => 'amount',
				'std' => '3',
				'type' => 'text',
			),
			array(
				'label' => __( 'Order By', 'dslc_string' ),
				'id' => 'orderby',
				'std' => 'date',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Publish Date', 'dslc_string' ),
						'value' => 'date'
					),
					array(
						'label' => __( 'Modified Date', 'dslc_string' ),
						'value' => 'modified'
					),
					array(
						'label' => __( 'Random', 'dslc_string' ),
						'value' => 'rand'
					),
					array(
						'label' => __( 'Alphabetic', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Comment Count', 'dslc_string' ),
						'value' => 'comment_count'
					),
					array(
						'label' => __( 'Price', 'dslc_string' ),
						'value' => 'price'
					),
				)
			),
			array(
				'label' => __( 'Order', 'dslc_string' ),
				'id' => 'order',
				'std' => 'DESC',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Ascending', 'dslc_string' ),
						'value' => 'ASC'
					),
					array(
						'label' => __( 'Descending', 'dslc_string' ),
						'value' => 'DESC'
					)
				)
			),
			array(
				'label' => __( 'Offset', 'dslc_string' ),
				'id' => 'offset',
				'std' => '0',
				'type' => 'text',
			),
			array(
				'label' => __( 'Excerpt or Content', 'dslc_string' ),
				'id' => 'excerpt_or_content',
				'std' => 'excerpt',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Excerpt', 'dslc_string' ),
						'value' => 'excerpt'
					),
					array(
						'label' => __( 'Content', 'dslc_string' ),
						'value' => 'content'
					),
				),
				'tab' => 'Excerpt'
			),
			array(
				'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
				'id' => 'excerpt_length',
				'std' => '17',
				'type' => 'text',
				'tab' => 'Excerpt'
			),

			array(
				'label' => __( 'Resize - Height', 'dslc_string' ),
				'id' => 'thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail'
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
				'visibility' => 'hidden'
			),
        );

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('.met_products_list', '', array('background-color' => '#EEEDE8')),

			// Price
			lc_general('.met_products_list_item_preview_overlay', 'Price Box', array('background-color' => '','color' => '#ffffff', 'font-size' => '18', 'line-height' => '22', 'font-weight' => '600')),
			lc_paddings('.met_products_list_item_preview_overlay', 'Price Box', array('t' => '9', 'r' => '10', 'b' => '9', 'l' => '10')),

			// Title
			lc_general('.met_products_list_item_title', 'Title', array('color' => '','color:hover' => '', 'font-size' => '19', 'line-height' => '22', 'font-weight' => '400')),

			// Excerpt
			lc_general('.met_p', 'Details', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'font-weight' => '400'))
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
        /* Module output starts here */

        $elementID = uniqid('productslist_');
        ?>

		<?php if ( class_exists( 'Woocommerce' ) ) : ?>

		<?php
			if ( $options['orderby'] == 'price' ) {
				$options['orderby'] = 'meta_value_num';
				$orderby = 'price';
			}

			$args = array(
				'post_type' => 'product',
				'posts_per_page' => $options['amount'],
				'order' => $options['order'],
				'orderby' => $options['orderby'],
				'offset' => $options['offset']
			);

			if ( isset( $options['categories'] ) && $options['categories'] != '' ) {

				$cats_array = explode( ' ', trim( $options['categories'] ));

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'product_cat',
						'field' => 'slug',
						'terms' => $cats_array
					)
				);

			}

			if ( isset( $orderby ) && $orderby == 'price' ) {

				$args['meta_key'] = '_price';

			}

			$dslc_query = new WP_Query( $args );

			if ( $dslc_query->have_posts() ) :
		?>

        <div id="<?php echo $elementID; ?>" class="met_products_list">
			<?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
				<?php
					global $product;
					$item_preview_width = 200;

					/**
					 * Manual Resize
					 */

					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$thumb_url = $thumb_url[0];
					$res_img = $thumb_url;

					$manual_resize = false;
					if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) || isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {

						$manual_resize = true;

						$resize_width = false;
						$resize_height = false;

						if ( isset( $options['thumb_resize_width_manual'] ) && ! empty( $options['thumb_resize_width_manual'] ) ) {
							$resize_width = $options['thumb_resize_width_manual'];
							$item_preview_width = $options['thumb_resize_width_manual'];
						}

						if ( isset( $options['thumb_resize_height'] ) && ! empty( $options['thumb_resize_height'] ) ) {
							$resize_height = $options['thumb_resize_height'];
						}

						$res_img = dslc_aq_resize( $thumb_url, $resize_width, $resize_height, true );

					}

					$item_preview_width_style = 'width:'.$item_preview_width.'px;';
					$item_details_margin_left_style = 'margin-left:'.$item_preview_width.'px;';
				?>
            <div class="met_products_list_item clearfix">
                <a href="<?php the_permalink(); ?>" class="met_products_list_item_preview" style="<?php echo $item_preview_width_style ?>">
					<img src="<?php echo $res_img ?>" alt="<?php echo esc_attr(get_the_title()) ?>" />
                    <div class="met_products_list_item_preview_overlay met_bgcolor"><span class="met_products_list_item_price"><?php echo $product->get_price_html(); ?></span></div>
                </a>
                <div class="met_products_list_item_details" style="<?php echo $item_details_margin_left_style ?>">
                    <a class="met_products_list_item_title met_color_transition2" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                    <div class="met_p">
						<?php if ( $options['excerpt_or_content'] == 'content' ) : ?>
							<?php the_content(); ?>
						<?php else : ?>
							<?php echo do_shortcode( wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ) ); ?>
						<?php endif; ?>
                    </div>
                </div>
            </div>
			<?php endwhile; ?>
        </div>

		<?php
			else : //there is no product

				if ( $dslc_is_admin ) :
					?><div class="dslc-notification dslc-red">You do not have products at the moment. Go to <strong>WP Admin &rarr; Products</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
				endif;

			endif;
		?>

		<?php
		else : //woocommerce plugin is not exist

			if ( $dslc_is_admin ) :
				?><div class="dslc-notification dslc-red">You do not have WooCommerce installed at the moment. You need to install it to use this module. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
			endif;

		endif;
		?>

        <?php
		wp_reset_query();

        /* Module output ends here */
        $this->module_end( $options );

    }

}