<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

defined( 'ABSPATH' ) || exit;

// Back compatible before 7.4.0
$readonly = $readonly ?? false;

if ( ! isset( $type ) ) {
	$type = $min_value > 0 && $min_value === $max_value ? 'hidden' : 'number';
	$type = ! empty( $readonly ) && 'hidden' !== $type ? 'text' : $type;
}

/* translators: %s: Quantity. */
$label = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'minimog' ), wp_strip_all_tags( $args['product_name'] ) ) : __( 'Quantity', 'minimog' );
?>
	<div class="quantity-button-wrapper quantity-input-<?php echo esc_attr( $type ); ?>">
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>" aria-label="<?php echo esc_attr( $label ); ?>"><?php esc_html_e( 'Quantity', 'minimog' ); ?></label>
		<div class="quantity">
			<?php
			/**
			 * Hook to output something before the quantity input field.
			 *
			 * @since 7.2.0
			 */
			do_action( 'woocommerce_before_quantity_input_field' );
			?>
			<input
				type="<?php echo esc_attr( $type ); ?>"
				<?php if ( $readonly ) : ?>
					readonly="readonly"
				<?php endif; ?>
				id="<?php echo esc_attr( $input_id ); ?>"
				class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
				name="<?php echo esc_attr( $input_name ); ?>"
				value="<?php echo esc_attr( $input_value ); ?>"
				aria-label="<?php esc_attr_e( 'Product quantity', 'minimog' ); ?>"
				<?php if ( in_array( $type, array( 'text', 'search', 'tel', 'url', 'email', 'password' ), true ) ) : ?>
					size="4"
				<?php endif; ?>
				min="<?php echo esc_attr( $min_value ); ?>"
				max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
				<?php if ( ! $readonly ): ?>
					step="<?php echo esc_attr( $step ); ?>"
					placeholder="<?php echo esc_attr( $placeholder ); ?>"
					inputmode="<?php echo esc_attr( $inputmode ); ?>"
					autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
				<?php endif; ?>
			/>
			<?php if ( ! $readonly && 'number' === $type ) : ?>
				<button type="button" class="decrease">-</button>
				<button type="button" class="increase">+</button>
			<?php endif; ?>
			<?php
			/**
			 * Hook to output something after quantity input field
			 *
			 * @since 3.6.0
			 */
			do_action( 'woocommerce_after_quantity_input_field' );
			?>
		</div>
	</div>
<?php
