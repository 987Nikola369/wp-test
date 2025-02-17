<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

/** @var WC_Product $product */
global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}
?>
<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<div class="product-item">
		<div class="thumbnail">
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<?php echo Minimog_Woo::instance()->get_product_image( $product, '100x100' ); ?>
			</a>
		</div>
		<div class="info">
			<h6 class="product-title post-title-2-rows">
				<a href="<?php the_permalink(); ?>">
					<?php echo wp_kses_post( $product->get_name() ); ?>
				</a>
			</h6>
			<?php echo wp_kses( $product->get_price_html(), 'minimog-default' ); ?>
			<?php if ( ! empty( $show_rating ) ) : ?>
				<?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
			<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
