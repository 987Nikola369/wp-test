<?php
/**
 * Icon list on top bar
 *
 * @package Minimog
 * @since   1.0.0
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$info_list = $args['info_list'];
?>
<div class="top-bar-info">
	<ul class="info-list">
		<?php
		foreach ( $info_list as $item ) {
			$url  = $item['url'] ?? '';
			$icon = $item['icon_class'] ?? '';
			$text = $item['text'] ?? '';

			$link_attrs = [
				'class' => 'info-link',
			];
			$link_tag   = 'div';

			if ( ! empty( $url ) ) {
				$link_tag           = 'a';
				$link_attrs['href'] = $url;
			}

			$link_text = '<span class="info-text">' . $text . '</span>';
			$link_icon = '';

			if ( $icon !== '' ) {
				$link_icon = '<i class="info-icon ' . esc_attr( $icon ) . '"></i>';
			}
			?>
			<li class="info-item">
				<?php printf( '<%1$s %2$s>%3$s</%1$s>', $link_tag, Minimog_Helper::convert_array_html_attributes_to_string( $link_attrs ), $link_icon . $link_text ); ?>
			</li>
		<?php } ?>
	</ul>
</div>
