<?php
namespace Minimog_Elementor\Modules\Woocommerce\Tags;

use Minimog_Elementor\Module_Query_Base as QueryControlModule;

trait Tag_Product_Id {
	public function add_product_id_control() {
		$this->add_control(
			'product_id',
			[
				'label' => __( 'Product', 'elementor-pro' ),
				'type' => QueryControlModule::AUTOCOMPLETE_CONTROL_ID,
				'options' => [],
				'label_block' => true,
				'autocomplete' => [
					'object' => QueryControlModule::QUERY_OBJECT_POST,
					'query' => [
						'post_type' => [ 'product' ],
					],
				],
				// Since we're using the `wc_get_product` method to retrieve products, when no product selected manually
				// by the dynamic tag - the default should be `false` so the method will use the product id given in the
				// http request instead.
				'default' => false,
			]
		);
	}
}
