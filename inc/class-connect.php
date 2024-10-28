<?php


namespace ProductFieldsAdmin\Inc;

class Connect {
	private $fields_handler;

	public function __construct( FieldsHandler $fields_handler ) {
		$this->fields_handler = $fields_handler;

		add_action( 'woocommerce_add_cart_item_data', [ $this, 'save_custom_field_input' ], 10, 2 );
	}

	/**
	 * Save custom field data when adding product to the cart.
	 */
	public function save_custom_field_input( $cart_item_data, $product_id ) {
		// Check if our custom field is set in the POST request
		if ( isset( $_POST['custom_product_text_field'] ) ) {
			$cart_item_data['custom_product_text_field'] = sanitize_text_field( $_POST['custom_product_text_field'] );

			// Generate a unique key for this cart item to prevent merging with others
			$cart_item_data['unique_key'] = md5( microtime() . rand() );
		}

		return $cart_item_data;
	}

}
