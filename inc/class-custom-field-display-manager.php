<?php
/**
 *
 * CustomFieldDisplayManager Class
 *
 * This class is responsible for rendering custom fields in the appropriate locations on the frontend.
 * It takes care of displaying the custom field information in the following areas:
 *
 * - Product pages: To show the custom fields that users filled out when viewing a product.
 * - Cart: To ensure that any custom field information is visible to the user as they review their cart.
 * - Checkout: To display any custom fields that users filled out during the checkout process.
 * - Order confirmation: To present the custom field information in the order details for both customers and store admins.
 *
 * @package Product_Customization_Add-ons
 */

namespace ProductFieldsAdmin\Inc;

/**
 * Class CustomFieldDisplayManager
 *
 * This class manages the display of custom fields in WooCommerce, including on product pages,
 * in the cart, during checkout, and in order details.
 */
class CustomFieldDisplayManager {


	/**
	 * CustomFieldDisplayManager constructor.
	 *
	 * Initializes the class and sets up the necessary hooks for displaying custom fields.
	 */
	public function __construct() {

		add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'display_wc_product_custom_fields' ] );
		add_filter( 'woocommerce_get_item_data', [ $this, 'display_custom_field_value_in_cart' ], 10, 2 );
		add_action( 'woocommerce_order_item_meta_end', [ $this, 'display_custom_field_in_order_details' ], 10, 3 );
	}

	/**
	 * Displays custom fields on the product page.
	 *
	 * This method retrieves the custom field metadata and outputs the corresponding input field
	 * for users to fill out.
	 */
	public function display_wc_product_custom_fields() {
		global $post;

		$product = wc_get_product( $post->ID );

		$title = $product->get_meta( 'customized_option_text' );

		if ( $title ) {
			printf(
				'<div><label for="">%s</label>
                    <input type="text" id="wc-custom-field" name="customized_option_text" value="">
                </div>',
				esc_html( $title )
			);
		}
	}

	/**
	 * Displays the custom field value in the cart.
	 *
	 * This method adds the custom field data to the item data displayed in the cart.
	 *
	 * @param array $item_data Existing item data for the cart item.
	 * @param array $cart_item The cart item data.
	 * @return array Modified item data with custom field information.
	 */
	public function display_custom_field_value_in_cart( $item_data, $cart_item ) {
		if ( isset( $cart_item['customized_option_text'] ) ) {
			$item_data[] = [
				'key'   => 'Custom Field',
				'value' => wc_clean( $cart_item['customized_option_text'] ),
			];
		}
		return $item_data;
	}


	/**
	 * Displays the custom field value in the order details.
	 *
	 * This method retrieves the custom field value from the order item and displays it
	 * in the order details for customers and admins.
	 *
	 * @param int                    $item_id The ID of the order item.
	 * @param \WC_Order_Item_Product $item The order item object.
	 * @param \WC_Order              $order The order object.
	 */
	public function display_custom_field_in_order_details( $item_id, $item, $order ) {
		$custom_field_value = $item->get_meta( 'Custom Field' );
		$custom_field_label = $item->get_meta( 'Custom Field Label', true );
		if ( ! empty( $custom_field_value ) ) {
			echo $custom_field_label . esc_html( $custom_field_value ) . '</p>';
		}
	}


}

