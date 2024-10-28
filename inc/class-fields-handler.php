<?php

namespace ProductFieldsAdmin\Inc;

/**
 *
 */
class FieldsHandler {

	/**
	 * Register Custom Fields
	 */
	public function register_product_fields() {
		global $woocommerce, $post;

		woocommerce_wp_text_input(
			[
				'id'          => 'custom_product_text_field',
				'placeholder' => 'Custom Product Text Field',
				'label'       => 'Custom Product Text Field',
				'desc_tip'    => 'true',
			]
		);
	}

}
