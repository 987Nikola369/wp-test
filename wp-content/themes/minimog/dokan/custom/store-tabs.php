<?php
/**
 * The Template for displaying store tabs
 *
 * @theme-version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$store_user = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info = $store_user->get_shop_info();
$store_tabs = dokan_get_store_tabs( $store_user->get_id() );

if ( empty( $store_tabs ) ) {
	return;
}

global $wp;
$current_url = isset( $wp->request ) ? home_url( $wp->request ) : '';
?>
<div id="dokan-store-tabs-wrap" class="dokan-store-tabs-wrap">
	<div class="dokan-store-tabs">
		<ul class="dokan-list-inline">
			<?php foreach ( $store_tabs as $key => $tab ) : ?>
				<?php
				if ( empty( $tab['url'] ) ) {
					continue;
				}
				?>
				<li class="store-tab-item<?php if ( $current_url === rtrim( $tab['url'], '/' ) ) : ?> active<?php endif; ?>">
					<a href="<?php echo esc_url( $tab['url'] ); ?>"><?php echo esc_html( $tab['title'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
