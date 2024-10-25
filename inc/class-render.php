<?php
/**
 *
 * Checkout
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin\Inc;

/**
 *
 */
class Render {

	/**
	 *
	 */
	protected static $instance = null;

	/**
	 *
	 */
	public function __construct() {

		add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'display_wc_product_custom_fields' ] );
		add_filter( 'woocommerce_get_cart_item_from_session', [ $this, 'get_cart_items_from_session' ], 10, 2 );
		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_wc_custom_field_to_cart_metadata' ], 10, 4 );
		add_filter( 'woocommerce_get_item_data', [ $this, 'display_custom_field_value_in_cart' ], 10, 2 );
		add_action( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_wc_custom_field_to_order' ], 10, 4 );
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
		 * Preserve custom data in the cart session
		 */
	public function get_cart_items_from_session( $cart_item, $values ) {
		if ( isset( $values['custom_product_text_field'] ) ) {
			$cart_item['custom_product_text_field'] = $values['custom_product_text_field'];
		}
		return $cart_item;
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
	 * Add custom field to order object
	 */
	public function add_wc_custom_field_to_order( $item, $cart_item_key, $values, $order ) {
		if ( isset( $values['custom_product_text_field'] ) ) {
			$item->add_meta_data( 'Custom Field', sanitize_text_field( $values['custom_product_text_field'] ), true );
		}
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

	/**
	 * Return the single class instance
	 */
	public static function singleton() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
