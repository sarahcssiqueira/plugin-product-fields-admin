<?php
/**
 * Class CustomFieldDisplayManager
 *
 * This class is responsible for rendering custom fields in the appropriate locations on the frontend.
 * It takes care of displaying the custom field information in the following areas:
 *
 * - Product pages: To show the custom fields that users filled out when viewing a product.
 * - Cart: To ensure that any custom field information is visible to the user as they review their cart.
 * - Checkout: To display any custom fields that users filled out during the checkout process.
 * - Order confirmation: To present the custom field information in the order details for both customers and store admins.
 *
 * The ClassDisplay class will handle the presentation layer of custom fields, ensuring that users can easily
 * view and understand the additional information provided alongside the standard WooCommerce functionality.
 */

namespace ProductFieldsAdmin\Inc;

class CustomFieldDisplayManager {
	/**
	 *
	 */
	protected static $instance = null;

	/**
	 *
	 */
	public function __construct() {

		add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'display_wc_product_custom_fields' ] );
		add_filter( 'woocommerce_get_item_data', [ $this, 'display_custom_field_value_in_cart' ], 10, 2 );
		add_action( 'woocommerce_order_item_meta_end', [ $this, 'display_custom_field_in_order_details' ], 10, 3 );
	}

	/**
	 *
	 * Display the fields in the product page
	 */
	public function display_wc_product_custom_fields() {
		global $post;

		$product = wc_get_product( $post->ID );

		$title = $product->get_meta( 'custom_product_text_field' );

		if ( $title ) {
			printf(
				'<div><label for="">%s</label>
                    <input type="text" id="wc-custom-field" name="custom_product_text_field" value="">
                </div>',
				esc_html( $title )
			);
		}
	}

	/**
	 *
	 * Display the value from the custom field in the cart
	 */
	public function display_custom_field_value_in_cart( $item_data, $cart_item ) {
		if ( isset( $cart_item['custom_product_text_field'] ) ) {
			$item_data[] = [
				'key'   => 'Custom Field',
				'value' => wc_clean( $cart_item['custom_product_text_field'] ),
			];
		}
		return $item_data;
	}



	/**
	 *
	 * Display field to order object
	 */
	public function display_custom_field_in_order_details( $item_id, $item, $order ) {
		$custom_field_value = $item->get_meta( 'Custom Field' );
		if ( ! empty( $custom_field_value ) ) {
			echo '<p><strong>Custom Field:</strong> ' . esc_html( $custom_field_value ) . '</p>';
		}
	}


}

