<?php
/**
 * Cart goal to get free shipping
 *
 * @package Minimog\Woocommerce
 * @since   1.0.0
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="cart-goal-wrap">
	<div class="cart-goal<?php if ( 0 >= $amount_left ): ?> cart-goal-done<?php endif; ?>">
		<?php wc_get_template( 'cart/cart-goal-text.php', [
			'min_amount' => $min_amount,
		] ); ?>

		<div class="cart-goal-progress minimog-progress">
			<div class="progress-bar-wrap">
				<div class="progress-bar"
				     role="progressbar"
				     aria-label="<?php esc_attr_e( 'Cart goal', 'minimog' ); ?>"
				     style="<?php echo esc_attr( "width: {$percent_amount_done}%" ); ?>"
				     aria-valuenow="<?php echo esc_attr( $percent_amount_done ); ?>" aria-valuemin="0"
				     aria-valuemax="100">
					<div class="progress-value">
						<!-- fas-star -->
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
							<path
								d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/>
						</svg>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
