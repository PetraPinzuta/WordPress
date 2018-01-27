<?php
/**
 * Hooks for WooCommerce which only needs to be used when WooCommerce is active.
 *
 * @package WordPress
 * @subpackage Belise
 * @since Belise 1.0.0
 */

// ARCHIVE PAGE - - -
// Hide shop title
add_filter( 'woocommerce_show_page_title', 'belise_woocommerce_hide_page_title' );

// Change the shop layout
add_action( 'woocommerce_before_main_content', 'belise_woocommerce_before_main_content', 10 );
add_action( 'woocommerce_after_main_content', 'belise_woocommerce_after_main_content', 10 );

// Remove sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Remove Add to cart on product loops
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

// Product image sizes
add_action( 'init', 'belise_woocommerce_image_sizes', 1 );

// Remove unused link
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

// Removes showing results
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Remove the default thumbnail
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'belise_woocommerce_template_loop_product_thumbnail', 10 );

// Remove product rating on shop/category
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// Remove product title
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// Remove product price
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// Add new product content
add_action( 'woocommerce_shop_loop_item_title', 'belise_woocommerce_template_loop_product_title', 10 );

// Remove pagination
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'belise_woocommerce_pagination', 10 );

// Add content from shop main after the products
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

// Remove breadcrumb
add_action( 'woocommerce_before_main_content', 'belise_woocommerce_breadcrumb_display' );

// Remove ordering
add_action( 'woocommerce_before_shop_loop', 'belise_woocommerce_ordering_display' );


// SINGLE PRODUCT - - -
// Remove rating
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

// WooCommerce Sharing icons
add_action( 'loop_start', 'belise_woocommerce_social_sharing' );

// Change excerpt display
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'belise_woocommerce_template_single_excerpt', 20 );

// Remove meta (categories)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Change Gravavatar size for reviews
remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
add_action( 'woocommerce_review_before', 'belise_woocommerce_review_display_gravatar', 10 );

// Change order for Upsell & Related products sections
add_action( 'template_redirect', 'belise_change_order_upsell_related' );

// Move coupon after table
add_action( 'woocommerce_before_checkout_form', 'belise_coupon_after_order_table_js' );
add_action( 'woocommerce_checkout_order_review', 'belise_coupon_after_order_table' );

// Remove product tabs on single
add_filter( 'woocommerce_product_tabs', 'belise_woocommerce_product_tabs', 98 );
