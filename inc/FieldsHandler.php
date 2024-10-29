<?php
/**
 *
 * FieldsHandler Class
 *
 * Responsible for registering custom fields for WooCommerce products.
 * This class enables the addition of user-defined options on the product edit page.
 *
 * @package Product_Customization_Add-ons
 */

namespace ProductCustomizationAddons\Inc;

/**
 * Class FieldsHandler
 *
 * This class manages the registration of custom fields that can be added
 * to WooCommerce products, allowing store owners to collect additional
 * information from customers.
 */
class FieldsHandler {

	/**
	 * Registers custom product fields in the WooCommerce product data panel.
	 *
	 * This method adds a text input field for users to enter a customized option
	 * when editing a product. It includes a placeholder and label for the input.
	 */
	public function register_product_fields() {
		global $woocommerce, $post;

		woocommerce_wp_text_input(
			[
				'id'          => 'customized_option_text',
				'placeholder' => 'Option Name i.e: "Engraving Text"',
				'label'       => 'Customized Option',
				'desc_tip'    => 'true',
			]
		);
	}

}
