<?php
/**
 * Plugin Name:       Product Fields Admin
 * Plugin URI:        https://sarahjobs.com/wordpress/plugins/product-fields-admin
 * Description:       Product Fields Admin for WooCommerce
 * Version:           1.0.0
 * Author:            Sarah Siqueira
 * Author URI:        https://sarahjobs.com/about
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl.html
 * Text Domain:       product-fields-admin
 */

 
// Register Custom Fields
add_action( 'woocommerce_product_options_general_product_data', 'register_wc_product_custom_fields' );

function register_wc_product_custom_fields() {
	global $woocommerce, $post;
	echo '<div class="product_custom_field">';

	woocommerce_wp_text_input(
		array(
			'id'          => 'custom_product_text_field',
			'placeholder' => 'Custom Product Text Field',
			'label'       => 'Custom Product Text Field',
			'desc_tip'    => 'true',
		)
	);
	echo '</div>';
}

// Save Fields
add_action( 'woocommerce_process_product_meta', 'save_wc_product_custom_fields' );

function save_wc_product_custom_fields ( $post_id ) {

    $product = wc_get_product( $post_id );
    $title = isset( $_POST['custom_product_text_field'] ) ? $_POST['custom_product_text_field'] : '';
    $product->update_meta_data( 'custom_product_text_field', sanitize_text_field( $title ) );
    $product->save();
	}

// Display the fields in the product page
add_action('woocommerce_before_add_to_cart_button', 'display_wc_product_custom_fields');

function display_wc_product_custom_fields() {
    global $post;
  
    $product = wc_get_product($post->ID);

    $title = $product->get_meta('custom_product_text_field');
  
    if ($title) {
        printf(

            '<div><label for="">%s</label>
                <input type="text" id="wc-custom-field" name="wc-custom-field" value="">
            </div>',

            esc_html($title)
        );
  }
}

// Validate user input
add_filter( 'woocommerce_add_to_cart_validation', 'validate_wc_custom_fields', 10, 3 );

function validate_wc_custom_fields( $passed, $product_id, $quantity ) {
    if( empty( $_POST['wc-custom-field'] ) ) {
        $passed = false;
        wc_add_notice( 'Please enter a value into the text field', 'error' );
    }
    return $passed;
}

// Add the user input from the previous custom field to cart meta data
add_filter( 'woocommerce_add_cart_item_data', 'add_wc_custom_field_to_cart_metadata', 10, 4 );

function add_wc_custom_field_to_cart_metadata( $cart_item_data, $product_id, $variation_id, $quantity ) {
    if( ! empty( $_POST['wc-custom-field'] ) ) {
        $cart_item_data['title_field'] = $_POST['wc-custom-field'];
    }
    return $cart_item_data;
}

// Display the value from the custom field to the cart && checkout pages
add_filter( 'woocommerce_cart_item_name', 'add_wc_custom_field_cart_checkout', 10, 3 );

function add_wc_custom_field_cart_checkout( $name, $cart_item, $cart_item_key ) {
    if( isset( $cart_item['title_field'] ) ) {
        $name .= sprintf(
            '<p>%s</p>',
            esc_html( $cart_item['title_field'] )
        );
    }
    return $name;
}

// Add custom field to order object
add_action( 'woocommerce_checkout_create_order_line_item', 'add_wc_custom_field_to_order', 10, 4 );

function add_wc_custom_field_to_order( $item, $cart_item_key, $values, $order ) {
    foreach( $item as $cart_item_key=>$values ) {
            if( isset( $values['title_field'] ) ) {
                $item->add_meta_data('Custom Field', $values['title_field'], true );
            }
        }
    }
    