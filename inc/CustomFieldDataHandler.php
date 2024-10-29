<?php
/**
 *
 * CustomFieldDataHandler Class
 *
 * Class responsible for including custom fields into the appropriate parts of the WooCommerce workflow.
 * It facilitates the addition of user-defined fields to various locations, such as:
 *
 * - Product pages: To allow customers to see and interact with custom fields when viewing a product.
 * - Cart: To ensure that any custom information related to the product is available during the checkout process.
 * - Checkout: To allow customers to see and review custom fields before finalizing the order.
 * - Order display: To allow customers to see and review custom field information associated with the order in the order details.
 *
 *  @package Product_Customization_Add-ons
 */

namespace ProductCustomizationAddons\Inc;

/**
 * Class CustomFieldDataHandler
 *
 * This class manages the addition and display of custom fields in WooCommerce,
 * including during the cart and checkout processes.
 */
class CustomFieldDataHandler {

	/**
	 * CustomFieldDataHandler constructor.
	 *
	 * Initializes the class and sets up the necessary hooks for adding custom fields
	 * to the cart and order objects.
	 */
	public function __construct() {

		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_wc_custom_field_to_cart_metadata' ], 10, 4 );
		add_action( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_wc_custom_field_to_order' ], 10, 4 );
	}

	/**
	 * Adds custom field data to the cart item metadata.
	 *
	 * This method checks for the presence of the custom field in the POST request
	 * and adds it to the cart item data.
	 *
	 * @param array    $cart_item_data Existing cart item data.
	 * @param int      $product_id The ID of the product being added to the cart.
	 * @param int|null $variation_id The ID of the product variation (if applicable).
	 * @param int      $quantity The quantity of the product being added.
	 * @return array Modified cart item data with custom field.
	 */
	public function add_wc_custom_field_to_cart_metadata( $cart_item_data, $product_id, $variation_id, $quantity ) {
		if ( ! empty( $_POST['customized_option_text'] ) ) {
			$cart_item_data['customized_option_text'] = sanitize_text_field( wp_unslash( $_POST['customized_option_text'] ) );
		}
			return $cart_item_data;
	}

	/**
	 * Adds custom field data to the order object.
	 *
	 * This method retrieves the custom field data from the cart item and adds it to
	 * the order line item metadata for later review in order details.
	 *
	 * @param \WC_Order_Item_Product $item The order item object.
	 * @param string                 $cart_item_key The cart item key.
	 * @param array                  $values The cart item data.
	 * @param \WC_Order              $order The order object.
	 */
	public function add_wc_custom_field_to_order( $item, $cart_item_key, $values, $order ) {
		if ( isset( $values['customized_option_text'] ) ) {
			$item->add_meta_data( 'Custom Field', sanitize_text_field( $values['customized_option_text'] ), true );
		}
	}

}
