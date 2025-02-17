<?php

namespace Minimog_Elementor;

use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || exit;

class Widget_Single_Product_Meta extends Base {
	public function get_name() {
		return 'tm-single-product-meta';
	}

	public function get_title() {
		return __( 'Product Meta', 'minimog' );
	}

	public function get_icon_part() {
		return 'eicon-product-meta';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'product', 'meta' ];
	}

	public function get_categories() {
		return [ 'minimog_wc_product' ];
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_single_product_description', [
			'label' => __( 'Style', 'minimog' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'wc_style_warning', [
			'type'            => Controls_Manager::RAW_HTML,
			'raw'             => __( 'The visibility of this widget is affected by setting in Theme Options', 'minimog' ),
			'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		global $product;

		if ( empty( $product ) && ! $product instanceof \WC_Product ) {
			return;
		}

		wc_get_template( 'single-product/meta.php' );
	}

	public function get_group_name() {
		return 'woocommerce';
	}
}
