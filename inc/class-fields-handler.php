<?php

// FIELDS MANAGER

// implements:

// field type selector

// then

// field data form ( multiple times if needed )
//
// 'id'          => 'custom_product_text_field',
// 'placeholder' => 'Custom Product Text Field',
// 'label'       => 'Custom Product Text Field',
// 'desc_tip'    => 'true',


namespace ProductFieldsAdmin\Inc;

/**
 *
 */
class FieldsHandler {


	/**
	 * Creates form field based on the specified type.
	 */
	public function create_field( $type, $name, $label, $value = '', $options = [], $selected = '' ) {
		switch ( $type ) {
			case 'text':
				$this->generate_text_field( $name, $label, $value );
				break;

			case 'radio':
				$this->generate_radio_field( $name, $label, $options, $selected );
				break;

			default:
				echo '<p>' . esc_html__( 'Invalid field type.', 'text-domain' ) . '</p>';
				break;
		}
	}



	 /**
	  * Generate a text field.
	  */
	public function generate_text_field( $name, $label, $value = '' ) {
		?>
		<p class="form-field">
			<label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label>
			<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" 
				   value="<?php echo esc_attr( $value ); ?>" class="short" />
		</p>
		<?php
	}

	/**
	 * Generate a radio button field.
	 */
	public function generate_radio_field( $name, $label, $options = [], $selected = '' ) {
		?>
		<p class="form-field">
			<label><?php echo esc_html( $label ); ?></label>
			<?php foreach ( $options as $option ) : ?>
				<label>
					<input type="radio" name="<?php echo esc_attr( $name ); ?>" 
						   value="<?php echo esc_attr( $option ); ?>" 
						   <?php checked( $selected, $option ); ?> />
					<?php echo esc_html( $option ); ?>
				</label><br />
			<?php endforeach; ?>
		</p>
		<?php
	}


}
