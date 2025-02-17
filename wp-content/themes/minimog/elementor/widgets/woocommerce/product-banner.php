<?php

namespace Minimog_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || exit;

class Widget_Product_Banner extends Base {

	/**
	 * @var \WC_Product $product
	 */
	private $product = null;

	public function get_name() {
		return 'tm-product-banner';
	}

	public function get_title() {
		return __( 'Product Banner', 'minimog' );
	}

	public function get_icon_part() {
		return 'eicon-image-rollover';
	}

	public function get_keywords() {
		return [ 'banner', 'product' ];
	}

	protected function register_controls() {
		$this->add_content_section();

		$this->add_box_style_section();

		$this->add_content_style_section();

		$this->add_badge_style_section();
	}

	private function add_content_section() {
		$this->start_controls_section( 'content_section', [
			'label' => __( 'Content', 'minimog' ),
		] );

		$this->add_control( 'product_id', [
			'label'        => __( 'Choose Product', 'minimog' ),
			'type'         => Module_Query_Base::AUTOCOMPLETE_CONTROL_ID,
			'label_block'  => true,
			'multiple'     => false,
			'autocomplete' => [
				'object' => Module_Query_Base::QUERY_OBJECT_POST,
				'query'  => [
					'post_type' => 'product',
				],
			],
		] );

		$this->add_control( 'style', [
			'label'   => __( 'Style', 'minimog' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'01' => '01',
				'02' => '02',
			],
			'default' => '01',
		] );

		$this->add_control( 'hover_effect', [
			'label'        => __( 'Hover Effect', 'minimog' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''         => __( 'None', 'minimog' ),
				'zoom-in'  => __( 'Zoom In', 'minimog' ),
				'zoom-out' => __( 'Zoom Out', 'minimog' ),
				'move-up'  => __( 'Move Up', 'minimog' ),
			],
			'default'      => '',
			'prefix_class' => 'minimog-animation-',
		] );

		$this->add_control( 'image', [
			'label'   => __( 'Choose Image', 'minimog' ),
			'type'    => Controls_Manager::MEDIA,
			'dynamic' => [
				'active' => true,
			],
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'image',
			// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
			'default'   => 'full',
			'separator' => 'none',
		] );

		$this->add_control( 'show_category', [
			'label'   => __( 'Show Category', 'minimog' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'show_sale_badge', [
			'label' => __( 'Show Sale Badge', 'minimog' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$this->add_control( 'show_best_selling_badge', [
			'label' => __( 'Show Best Selling Badge', 'minimog' ),
			'type'  => Controls_Manager::SWITCHER,
		] );

		$this->add_control( 'title_size', [
			'label'   => __( 'Title HTML Tag', 'minimog' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'h1'   => 'H1',
				'h2'   => 'H2',
				'h3'   => 'H3',
				'h4'   => 'H4',
				'h5'   => 'H5',
				'h6'   => 'H6',
				'div'  => 'div',
				'span' => 'span',
				'p'    => 'p',
			],
			'default' => 'h2',
		] );

		$this->add_control( 'sub_text', [
			'label'       => __( 'Sub text', 'minimog' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => __( 'Enter your sub text', 'minimog' ),
			'label_block' => true,
			'condition'   => [
				'style' => '02',
			],
		] );

		$this->add_control( 'view', [
			'label'   => __( 'View', 'minimog' ),
			'type'    => Controls_Manager::HIDDEN,
			'default' => 'traditional',
		] );

		$this->end_controls_section();
	}

	private function add_box_style_section() {
		$this->start_controls_section( 'box_style_section', [
			'label' => __( 'Box', 'minimog' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'box_height', [
			'label'      => __( 'Height', 'minimog' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .minimog-box' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => __( 'Padding', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'body:not(.rtl) {{WRAPPER}} .minimog-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .minimog-box'       => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_horizontal_alignment', [
			'label'                => __( 'Horizontal Alignment', 'minimog' ),
			'label_block'          => true,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'default'              => 'center',
			'toggle'               => false,
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: flex; justify-content: {{VALUE}}',
			],
		] );

		$this->add_responsive_control( 'text_align', [
			'label'                => __( 'Alignment', 'minimog' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_text_align_full(),
			'selectors'            => [
				'{{WRAPPER}} .minimog-box' => 'text-align: {{VALUE}};',
			],
			'selectors_dictionary' => [
				'left'  => 'start',
				'right' => 'end',
			],
		] );

		$this->end_controls_section();
	}

	private function add_content_style_section() {
		$this->start_controls_section( 'content_style_section', [
			'label' => __( 'Content', 'minimog' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'content_max_width', [
			'label'      => __( 'Max Width', 'minimog' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .content-inner' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'image_title', [
			'label' => __( 'Image', 'minimog' ),
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_responsive_control( 'image_height', [
			'label'      => __( 'Height', 'minimog' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .minimog-box .minimog-image' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'category_style_heading', [
			'label'     => __( 'Category', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'category_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .banner-product-category' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'category_typography',
			'selector' => '{{WRAPPER}} .banner-product-category',
		] );

		$this->add_control( 'title_style_heading', [
			'label'     => __( 'Title', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'title_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .banner-product-title' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .banner-product-title',
		] );

		$this->add_control( 'price_style_heading', [
			'label'     => __( 'Price', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'price_margin', [
			'label'      => __( 'Margin', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'body.rtl {{WRAPPER}} .price'       => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body:not(.rtl) {{WRAPPER}} .price' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'button_style_heading', [
			'label'     => __( 'Button', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'button_margin', [
			'label'      => __( 'Margin', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'body:not(.rtl) {{WRAPPER}} .product-banner-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .product-banner-button'       => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	private function add_badge_style_section() {
		$this->start_controls_section( 'badge_style_section', [
			'label' => __( 'Badge', 'minimog' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'badge_size', [
			'label'     => __( 'Size', 'minimog' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 50,
					'max' => 150,
				],
			],
			'default'   => [
				'unit' => 'px',
				'size' => 74,
			],
			'selectors' => [
				'{{WRAPPER}} .product-banner-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'badge_background_color', [
			'label'     => __( 'Background Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .product-banner-badge' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'badge_text_style_heading', [
			'label'     => __( 'Text', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'badge_text_color', [
			'label'     => __( 'Text Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .product-banner-badge .badge-text' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'badge_text_typography',
			'selector' => '{{WRAPPER}} .product-banner-badge .badge-text',
		] );

		$this->add_control( 'badge_value_style_heading', [
			'label'     => __( 'Value', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'badge_value_color', [
			'label'     => __( 'Value Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .product-banner-badge .badge-value' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'badge_value_typography',
			'selector' => '{{WRAPPER}} .product-banner-badge .badge-value',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['product_id'] ) && ! function_exists( 'wc_get_product' ) ) {
			return;
		}

		$product = wc_get_product( $settings['product_id'] );

		if ( ! $product ) {
			return;
		}

		$this->product = $product;

		$box_tag = 'a';
		$this->add_render_attribute( 'wrapper', 'href', $this->product->get_permalink() );
		$this->add_render_attribute( 'wrapper', 'class', 'minimog-product-banner minimog-box link-secret style-' . $settings['style'] );
		?>
		<?php printf( '<%1$s %2$s>', $box_tag, $this->get_render_attribute_string( 'wrapper' ) ); ?>

		<?php if ( ! empty( $settings['image']['url'] ) ) : ?>
			<div class="minimog-image image">
				<?php echo \Minimog_Image::get_elementor_attachment( [
					'settings' => $settings,
				] ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $settings['show_sale_badge'] ) && 'yes' === $settings['show_sale_badge'] && $this->product->is_on_sale() ) : ?>
			<div class="product-banner-badge on-sale-badge">
				<?php $this->print_sale_badge(); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $settings['show_best_selling_badge'] ) && 'yes' === $settings['show_best_selling_badge'] ) : ?>
			<div class="product-banner-badge best-selling-badge">
				<span class="badge-value"><?php esc_html_e( 'Best', 'minimog' ); ?></span><span
					class="badge-text"><?php esc_html_e( 'Selling', 'minimog' ); ?></span>
			</div>
		<?php endif; ?>

		<div class="product-banner-content">
			<div class="content-inner">
				<?php if ( ! empty( $settings['show_category'] ) && 'yes' === $settings['show_category'] ) : ?>
					<?php
					$cats = $this->product->get_category_ids();
					if ( ! empty( $cats ) ) {
						$first_cat = $cats[0];
						$cat       = get_term_by( 'id', $first_cat, 'product_cat' );

						if ( $cat instanceof \WP_Term ) {
							echo '<div class="banner-product-category">' . $cat->name . '</div>';
						}
					}
					?>
				<?php endif; ?>
				<?php
				$this->add_render_attribute( 'title', 'class', 'banner-product-title' );

				printf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string( 'title' ), $this->product->get_title() );

				if ( '02' === $settings['style'] ) { ?>
					<div class="content-bottom">
						<p><?php echo esc_html( $settings['sub_text'] ); ?></p>
						<?php
						echo $this->product->get_price_html();
						\Minimog_Templates::render_button( [
							'text'          => __( 'Shop now', 'minimog' ),
							'size'          => 'xs',
							'wrapper_class' => 'product-banner-button',
						] ) ?>
					</div>
				<?php } else {
					echo $this->product->get_price_html();
					\Minimog_Templates::render_button( [
						'text'          => __( 'Shop now', 'minimog' ),
						'size'          => 'xs',
						'wrapper_class' => 'product-banner-button',
					] );
				} ?>
			</div>
		</div>
		<?php printf( '</%1$s>', $box_tag ); ?>
		<?php
	}

	protected function print_sale_badge() {
		$product = $this->product;

		if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
			$_regular_price = (float) $product->get_regular_price();
			$_sale_price    = (float) $product->get_sale_price();

			$percentage = round( ( ( $_regular_price - $_sale_price ) / $_regular_price ) * 100 );

			echo '<span class="badge-value">' . "{$percentage}%" . '</span><span class="badge-text">' . esc_html__( 'Off', 'minimog' ) . '</span>';
		} else {
			esc_html_e( 'Sale !', 'minimog' );
		}
	}
}
