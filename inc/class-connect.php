<?php
/**
 *
 * Connect Class
 *
 * Handles the connection between product customization fields and the WooCommerce cart.
 *
 * @package Product_Customization_Add-ons
 */

namespace ProductFieldsAdmin\Inc;

/**
 * Class Connect
 *
 * This class manages the saving of custom field data when a product is added to the cart.
 */
class Connect {

	/**
	 * Fields handler instance.
	 *
	 * @var FieldsHandler
	 */
	private $fields_handler;

	/**
	 * Connect constructor.
	 *
	 * Initializes the class and sets up the necessary hook for saving custom field data.
	 *
	 * @param FieldsHandler $fields_handler An instance of FieldsHandler to manage custom fields.
	 */
	public function __construct( FieldsHandler $fields_handler ) {
		$this->fields_handler = $fields_handler;

		add_action( 'woocommerce_add_cart_item_data', [ $this, 'save_custom_field_input' ], 10, 2 );
	}

	/**
	 * Saves custom field data when a product is added to the cart.
	 *
	 * This method checks if the custom field is set in the POST request,
	 * sanitizes the input, and adds it to the cart item data.
	 *
	 * @param array $cart_item_data Existing cart item data.
	 * @param int   $product_id The ID of the product being added to the cart.
	 * @return array Modified cart item data with custom field input.
	 */
	public function save_custom_field_input( $cart_item_data, $product_id ) {
		// Check if our custom field is set in the POST request.
		if ( isset( $_POST['customized_option_text'] ) ) {
			$cart_item_data['customized_option_text'] = sanitize_text_field( $_POST['customized_option_text'] );

			// Generate a unique key for this cart item to prevent merging with others.
			$cart_item_data['unique_key'] = md5( microtime() . rand() );
		}

		return $cart_item_data;
	}

}
