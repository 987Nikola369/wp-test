<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://woocommerce.com/document/template-structure/
 * @package       WooCommerce\Templates
 * @version       7.9.0
 *
 * @theme-version 3.1.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>
	<div class="woocommerce-cart-form"> <?php // Change form to div to prevent form submit on enter quantity. ?>
		<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<div id="cart-table-wrap" class="woocommerce-cart-form-wrapper">
			<?php wc_get_template( 'cart/cart-content.php' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_cart_table' ); ?>

		<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

		<div id="cart-collaterals" class="cart-collaterals">
			<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
			?>
		</div>
	</div>
<?php do_action( 'woocommerce_after_cart' );
