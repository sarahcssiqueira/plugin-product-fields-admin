<?php
/**
 *
 * Admin
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin\Inc;

/**
 *
 */
class Admin {

	/**
	 *
	 */
	// protected static $instance = null;
	private $fields_handler;

	 /**
	  *
	  */
	public function __construct( FieldsHandler $fields_handler ) {
		$this->fields_handler = $fields_handler;

		add_filter( 'woocommerce_product_data_tabs', [ $this, 'settings_tabs' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'render_product_tab_content' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_custom_product_field' ] );
	}


	/**
	 * Creates a custom tab for the custom fields
	 *
	 * @param array $tabs Custom Tab.
	 */
	public function settings_tabs( $tabs ) {

		$tabs['product_add_ons'] = [
			'label'    => 'Product Add-Ons',
			'target'   => 'custom_product_data', // id match with the panel
			'class'    => [ 'show_if_simple' ],
			'priority' => 21,
		];
		return $tabs;

	}

	 // Render custom tab content
	public function render_product_tab_content() {
		// Render a form for admins to define custom fields
		?>
		<div id="custom_product_data" class="panel woocommerce_options_panel">
			<h3><?php esc_html_e( 'Add Custom Field' ); ?></h3>
			<select id="field_type" name="field_type">
				<option value="text"><?php esc_html_e( 'Text Field' ); ?></option>
				<option value="radio"><?php esc_html_e( 'Radio Button' ); ?></option>
			</select>
			<input type="text" id="field_name" name="field_name" placeholder="<?php esc_attr_e( 'Field Name' ); ?>" />
			<input type="text" id="field_label" name="field_label" placeholder="<?php esc_attr_e( 'Field Label' ); ?>" />
			<input type="text" id="field_options" name="field_options" placeholder="<?php esc_attr_e( 'Options (comma separated for radio)' ); ?>" />
			<button id="add_field" type="button"><?php esc_html_e( 'Add Field' ); ?></button>
		</div>
		<div id="existing_custom_fields">
			<h3><?php esc_html_e( 'Existing Custom Fields' ); ?></h3>
		   <?php
			$this->render_existing_fields();
			?>
		</div>
		<?php
	}

	// Render existing fields based on saved custom fields
	public function render_existing_fields() {
		$custom_fields = get_post_meta( get_the_ID(), 'custom_product_fields', true ) ?: [];
		foreach ( $custom_fields as $field ) {
			if ( $field['type'] === 'text' ) {
				$this->fields_handler->generate_text_field( $field['name'], $field['label'] );
			} elseif ( $field['type'] === 'radio' ) {
				$this->fields_handler->generate_radio_field( $field['name'], $field['label'], explode( ',', $field['options'] ) );
			}
		}
	}

	// Save custom fields when product is saved
	public function save_custom_product_field( $post_id ) {
		// Get the custom fields data from POST
		if ( isset( $_POST['custom_product_fields'] ) ) {
			$custom_fields = array_map( 'sanitize_text_field', $_POST['custom_product_fields'] );
			update_post_meta( $post_id, 'custom_product_fields', $custom_fields );
		}
	}

}

