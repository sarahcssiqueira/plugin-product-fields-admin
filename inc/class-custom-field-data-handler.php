<?php
/**
 * Class CustomFieldDataHandler {
 *
 * Class responsible for including custom fields into the appropriate parts of the WooCommerce workflow.
 * It facilitates the addition of user-defined fields to various locations, such as:
 *
 * - Product pages: To allow customers to see and interact with custom fields when viewing a product.
 * - Cart: To ensure that any custom information related to the product is available during the checkout process.
 * - Checkout: To allow customers to see and review custom fields before finalizing the order.
 * - Order display: To allow customers to see and review custom field information associated with the order in the order details.
 *
 * The ClassInclude class will ensure that custom fields are integrated seamlessly into the WooCommerce flow,
 * providing a better user experience and allowing for additional product customization options.
 */


namespace ProductFieldsAdmin\Inc;

class CustomFieldDataHandler {

	/**
	 *
	 */
	public function __construct() {

		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_wc_custom_field_to_cart_metadata' ], 10, 4 );
		add_action( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_wc_custom_field_to_order' ], 10, 4 );
	}

	/**
	 *
	 * Adds custom field to the cart.
	 */
	public function add_wc_custom_field_to_cart_metadata( $cart_item_data, $product_id, $variation_id, $quantity ) {
		if ( ! empty( $_POST['custom_product_text_field'] ) ) { // Make sure to use the correct name
			$cart_item_data['custom_product_text_field'] = sanitize_text_field( wp_unslash( $_POST['custom_product_text_field'] ) );
		}
			return $cart_item_data;
	}

	/**
	 *
	 * Add custom field to order object
	 */
	public function add_wc_custom_field_to_order( $item, $cart_item_key, $values, $order ) {
		if ( isset( $values['custom_product_text_field'] ) ) {
			$item->add_meta_data( 'Custom Field', sanitize_text_field( $values['custom_product_text_field'] ), true );
		}
	}

}
