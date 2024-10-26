<?php


namespace ProductFieldsAdmin\Inc;

class Connect {
	private $fields_handler;

	public function __construct( FieldsHandler $fields_handler ) {
		$this->fields_handler = $fields_handler;

		// Display fields on product page
		add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'display_custom_fields' ] );

		// Save user input when adding to cart
		add_action( 'woocommerce_add_cart_item_data', [ $this, 'save_custom_field_data' ], 10, 2 );
	}

	/**
	 * Display custom fields on the product page.
	 */
	public function display_custom_fields() {
		global $post;
		// Retrieve the custom fields saved for this product
		$custom_fields = get_post_meta( $post->ID, '_custom_product_fields', true ) ?: [];

		if ( empty( $custom_fields ) ) {
			return; // No custom fields to display
		}

		echo '<div class="product_custom_fields">';
		foreach ( $custom_fields as $field ) {
			$field_name  = $field['name'];
			$field_label = $field['label'];
			$field_type  = $field['type'];

			// Use fields handler to generate the appropriate input field
			echo '<p class="form-field">';
			echo '<label for="' . esc_attr( $field_name ) . '">' . esc_html( $field_label ) . '</label>';
			$this->fields_handler->generate_field( $field_type, $field_name, $field_label );
			echo '</p>';
		}
		echo '</div>';
	}

	/**
	 * Save custom field data when adding product to the cart.
	 */
	public function save_custom_field_data( $cart_item_data, $product_id ) {
		// Retrieve custom fields for this product
		$custom_fields = get_post_meta( $product_id, '_custom_product_fields', true ) ?: [];

		// Loop through fields and save user inputs
		foreach ( $custom_fields as $field ) {
			$field_name = $field['name'];
			if ( isset( $_POST[ $field_name ] ) ) {
				$cart_item_data[ $field_name ] = sanitize_text_field( $_POST[ $field_name ] );
			}
		}

		return $cart_item_data;
	}
}
