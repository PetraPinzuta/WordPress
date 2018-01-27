<?php
/**
 * Functions for WooCommerce which only needs to be used when WooCommerce is active.
 *
 * @package WordPress
 * @subpackage Belise
 * @since Belise 1.0.0
 */

/**
 * Display the cart icon
 */
function belise_cart_icon() {
	if ( belise_woocommerce_activated() ) {
		global $woocommerce;
		$cart_url = $woocommerce->cart->get_cart_url();

		echo '<a href="' . esc_url( $cart_url ) . '" title="' . esc_attr__( 'Cart', 'belise-lite' ) . '" class="menu-shopping-cart"><i class="fa 
		fa-shopping-cart"></i></a>';
	}
}

/**
 * Display category title
 */
function belise_woocommerce_page_title( $echo = true ) {

	if ( is_search() ) {
		/* translators: %s: search query */
		$page_title = sprintf( esc_html__( 'Search Results: &ldquo;%s&rdquo;', 'belise-lite' ), get_search_query() );

		if ( get_query_var( 'paged' ) ) {
			/* translators: %s: page number */
			$page_title .= sprintf( esc_html__( '&nbsp;&ndash; Page %s', 'belise-lite' ), get_query_var( 'paged' ) );
		}
	} elseif ( is_tax() ) {

		$page_title = single_term_title( '', false );

	} else {

		if ( function_exists( 'wc_get_page_id' ) ) {
			$shop_page_id = wc_get_page_id( 'shop' );

			if ( ! empty( $shop_page_id ) ) {
				$page_title = get_the_title( $shop_page_id );
			}
		}
	}

	$page_title = apply_filters( 'belise_woocommerce_page_title', $page_title );

	if ( $echo ) {
		echo esc_html( $page_title );
	} else {
		return $page_title;
	}
}

/**
 * Hide shop title
 */
function belise_woocommerce_hide_page_title() {
	return false;
}


/**
 * Change the layout before the shop page main content
 */
function belise_woocommerce_before_main_content() {
	?>
	<div id="primary" class="content-area">
		<div class="container">
			<div class="row">
	<?php
}

/**
 * Change the layout after the shop page main content
 */
function belise_woocommerce_after_main_content() {
	?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Define product images size
 */
function belise_woocommerce_image_sizes() {
	$catalog = array(
		'width'  => '370',
		'height' => '270',
		'crop'   => 1,
	);

	$single = array(
		'width'  => '550',
		'height' => '550',
		'crop'   => 1,
	);

	$thumbnail = array(
		'width'  => '120',
		'height' => '120',
		'crop'   => 0,
	);

	update_option( 'shop_catalog_image_size', $catalog );
	update_option( 'shop_single_image_size', $single );
	update_option( 'shop_thumbnail_image_size', $thumbnail );
}

/**
 * Change the layout of the thumbnail on single product listing
 */
function belise_woocommerce_template_loop_product_thumbnail() {
	?>
	<div class="product-image">
	<?php if ( has_post_thumbnail() ) { ?>
		<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( 'shop_catalog' ); ?>
		</a>
	<?php } ?>
	</div>
	<?php
}

/**
 * Define product loop display
 */
function belise_woocommerce_template_loop_product_title() {
	global $product;
	?>
	<div class="product-header">
		<h3 class="product-title">
			<a class="shop-item-title-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html( the_title() ); ?></a>
		</h3>
		<?php
		$product_price = $product->get_price_html();
		if ( ! empty( $product_price ) ) {
			echo '<div class="price">' . wp_kses_post( $product_price ) . '</div>';
		}
		?>
	</div>
	<?php
}

/**
 * Insert pagination
 */
function belise_woocommerce_pagination() {
	the_posts_pagination(
		array(
			'prev_text' => esc_html__( 'Prev page', 'belise-lite' ),
			'next_text' => esc_html__( 'Next page', 'belise-lite' ),
		)
	);
}

/**
 * Shop page description on product archives
 */
function belise_woocommerce_template_single_excerpt() {
	global $post;

	if ( ! $post->post_excerpt ) {
		return;
	}
	?>
	<div class="description" itemprop="description">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
	</div><?php
}

/**
 * Change Gravatar size for reviews
 */
function belise_woocommerce_review_display_gravatar( $comment ) {
		echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '145' ), '' );
}

/**
 * Change order for Upsell & Related products sections
 */
function belise_change_order_upsell_related() {
	if ( is_product() ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		add_action( 'woocommerce_after_main_content', 'belise_upsell_related_display', 25 );
	}
}

/**
 * Change order for Upsell & Related products sections
 */
function belise_upsell_related_display() {
	echo '</div>';
	global $product;

	/* Related Products */
	if ( function_exists( 'wc_get_related_products' ) ) {
		$prod_id = get_the_ID();
		$related = wc_get_related_products( $prod_id );
	} else {
		$related = $product->get_related();
	}
	if ( ! empty( $related ) && ( count( $related ) > 0 ) ) {
		$belise_related_items = array(
			'posts_per_page' => 3,
		);

		echo '<div class="woocommerce-related-products"><div class="container"><div class="row">';
		woocommerce_related_products( $belise_related_items );
		echo '<div class="clear"></div>';
		echo '</div></div></div>';
	}

	/* Upsells */
	if ( function_exists( 'method_exists' ) && method_exists( $product, 'get_upsell_ids' ) ) {
		$upsells = $product->get_upsell_ids();
	} else {
		$upsells = $product->get_upsells();
	}
	if ( ! empty( $upsells ) && ( count( $upsells ) > 0 ) ) {
		$belise_upsell_items = 3;

		echo '<div class="woocommerce-upsells-products"><div class="container"><div class="row">';
		woocommerce_upsell_display( $belise_upsell_items );
		echo '<div class="clear"></div>';
		echo '</div></div></div>';
	}
}

/**
 * Move coupon after table
 */
function belise_coupon_after_order_table_js() {
	wc_enqueue_js(
		'
     $( $( ".woocommerce-info, .checkout_coupon" ).detach() ).appendTo( "#belise-checkout-coupon" );
 '
	);
}

/**
 * Move coupon after table
 */
function belise_coupon_after_order_table() {
	echo '<div id="belise-checkout-coupon"></div><div style="clear:both"></div>';
}

/**
 * Remove social sharing
 */
function belise_woocommerce_social_sharing() {
	remove_action( 'woocommerce_share', 'jetpack_woocommerce_social_share_icons', 10 );
}

/**
 * Remove breadcrumb on shop category
 */
function belise_woocommerce_breadcrumb_display() {
	$woocommerce_breadcrumb = get_theme_mod( 'belise_woocommerce_breadcrumb_display', false );

	if ( (bool) $woocommerce_breadcrumb === false ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	}
}

/**
 * Remove ordering on shop category
 */
function belise_woocommerce_ordering_display() {
	$woocommerce_ordering = get_theme_mod( 'belise_woocommerce_ordering_display', false );

	if ( (bool) $woocommerce_ordering === false ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}
}

/**
 * Remove product tabs on single
 */
function belise_woocommerce_product_tabs( $tabs ) {
	$woocommerce_tabs = get_theme_mod( 'belise_woocommerce_tabs_display', false );

	if ( (bool) $woocommerce_tabs === false ) {
		unset( $tabs['description'] );
		unset( $tabs['reviews'] );
		unset( $tabs['additional_information'] );
	} else {
		$tabs['description'];
		$tabs['reviews'];
		$tabs['additional_information'];
	}

	return $tabs;
}
?>
