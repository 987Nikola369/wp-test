<?php

namespace Minimog_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;

defined( 'ABSPATH' ) || exit;

class Widget_Product_Categories_Grid extends Base {

	const PRODUCT_CATEGORY = 'product_cat';
	private $terms = [];

	public function get_name() {
		return 'tm-product-categories-grid';
	}

	public function get_title() {
		return __( 'Product Categories Grid', 'minimog' );
	}

	public function get_icon_part() {
		return 'eicon-gallery-grid';
	}

	public function get_keywords() {
		return [ 'product', 'product category', 'product categories', 'grid' ];
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_query_section();

		$this->add_grid_section();

		$this->add_cat_style_section();

		$this->add_cat_image_style_section();

		$this->add_cat_info_style_section();

		$this->add_cat_min_price_style_section();
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => __( 'Layout', 'minimog' ),
		] );

		$this->add_control( 'style', [
			'label'   => __( 'Style', 'minimog' ),
			'type'    => Controls_Manager::SELECT,
			'options' => \Minimog_Woo::instance()->get_shop_categories_style_options(),
			'default' => '01',
		] );

		$this->add_control( 'hover_effect', [
			'label'        => __( 'Hover Effect', 'minimog' ),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''                    => __( 'None', 'minimog' ),
				'zoom-in'             => __( 'Zoom In', 'minimog' ),
				'zoom-out'            => __( 'Zoom Out', 'minimog' ),
				'scaling-up'          => __( 'Scale Up', 'minimog' ),
				'scaling-up-style-02' => __( 'Scale Up Bigger', 'minimog' ),
			],
			'default'      => '',
			'prefix_class' => 'minimog-animation-',
		] );

		$this->add_control( 'show_count', [
			'label'                => __( 'Show Count', 'minimog' ),
			'type'                 => Controls_Manager::SWITCHER,
			'label_on'             => __( 'Show', 'minimog' ),
			'label_off'            => __( 'Hide', 'minimog' ),
			'return_value'         => 'yes',
			'default'              => 'yes',
			'selectors_dictionary' => [
				'yes' => 'display: inline-block;',
				''    => 'display: none;',
			],
			'frontend_available'   => true,
			'selectors'            => [
				'{{WRAPPER}} .category-count' => '{{VALUE}};',
			],
		] );

		$this->add_control( 'show_min_price', [
			'label'        => __( 'Show Min Price', 'minimog' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'minimog' ),
			'label_off'    => __( 'Hide', 'minimog' ),
			'return_value' => 'yes',
			'default'      => '',
		] );

		$this->add_control( 'thumbnail_default_size', [
			'label'        => __( 'Use Default Thumbnail Size', 'minimog' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '1',
			'return_value' => '1',
			'separator'    => 'before',
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'thumbnail',
			'default'   => 'full',
			'condition' => [
				'thumbnail_default_size!' => '1',
			],
		] );

		$this->add_control( 'button_text', [
			'label'       => __( 'Button Text', 'minimog' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => __( 'Shop Now', 'minimog' ),
			'label_block' => true,
			'separator'   => 'before',
		] );

		$this->end_controls_section();
	}

	private function add_grid_section() {
		$this->start_controls_section( 'grid_options_section', [
			'label' => __( 'Grid Options', 'minimog' ),
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'              => __( 'Columns', 'minimog' ),
			'type'               => Controls_Manager::NUMBER,
			'min'                => 1,
			'max'                => 12,
			'step'               => 1,
			'default'            => 3,
			'tablet_default'     => 2,
			'mobile_default'     => 1,
			'frontend_available' => true,
		] );

		$this->add_responsive_control( 'grid_gutter', [
			'label'              => __( 'Gutter', 'minimog' ),
			'type'               => Controls_Manager::NUMBER,
			'min'                => 0,
			'max'                => 200,
			'step'               => 1,
			'default'            => 30,
			'frontend_available' => true,
		] );

		$this->end_controls_section();
	}

	private function add_query_section() {
		$this->start_controls_section( 'query_section', [
			'label' => __( 'Query', 'minimog' ),
		] );

		$this->add_control( 'custom_query', [
			'label'     => __( 'Custom', 'minimog' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => __( 'Yes', 'minimog' ),
			'label_off' => __( 'No', 'minimog' ),
			'default'   => '',
		] );

		$this->add_control( 'source', [
			'label'       => __( 'Source', 'minimog' ),
			'type'        => Controls_Manager::SELECT,
			'options'     => [
				''                      => __( 'Show All', 'minimog' ),
				'by_id'                 => __( 'Manual Selection', 'minimog' ),
				'by_parent'             => __( 'By Parent', 'minimog' ),
				'current_subcategories' => __( 'Current Subcategories', 'minimog' ),
			],
			'label_block' => true,
			'condition'   => [
				'custom_query!' => 'yes',
			],
		] );

		$options = \Minimog_Woo::instance()->get_product_categories_dropdown_options();

		$this->add_control( 'categories', [
			'label'       => __( 'Categories', 'minimog' ),
			'type'        => Controls_Manager::SELECT2,
			'options'     => $options,
			'default'     => [],
			'label_block' => true,
			'multiple'    => true,
			'condition'   => [
				'custom_query!' => 'yes',
				'source'        => 'by_id',
			],
		] );

		$parent_options = [ '0' => __( 'Only Top Level', 'minimog' ) ] + $options;
		$this->add_control(
			'parent', [
			'label'     => __( 'Parent', 'minimog' ),
			'type'      => Controls_Manager::SELECT2,
			'multiple'  => false,
			'default'   => '0',
			'options'   => $parent_options,
			'condition' => [
				'custom_query!' => 'yes',
				'source'        => 'by_parent',
			],
		] );

		$this->add_control( 'hide_empty', [
			'label'     => __( 'Hide Empty', 'minimog' ),
			'type'      => Controls_Manager::SWITCHER,
			'default'   => 'yes',
			'label_on'  => 'Hide',
			'label_off' => 'Show',
		] );

		$this->add_control( 'number', [
			'label'     => __( 'Categories Count', 'minimog' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => '6',
			'condition' => [
				'custom_query!' => 'yes',
				'source!'       => 'by_id',
			],
		] );

		$this->add_control( 'orderby', [
			'label'     => __( 'Order By', 'minimog' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'name',
			'options'   => [
				'name'        => __( 'Name', 'minimog' ),
				'slug'        => __( 'Slug', 'minimog' ),
				'description' => __( 'Description', 'minimog' ),
				'count'       => __( 'Count', 'minimog' ),
				'order'       => __( 'Category order', 'minimog' ),
			],
			'condition' => [
				'custom_query!' => 'yes',
				'source!'       => 'by_id',
			],
		] );

		$this->add_control( 'order', [
			'label'     => __( 'Order', 'minimog' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'desc',
			'options'   => [
				'asc'  => __( 'ASC', 'minimog' ),
				'desc' => __( 'DESC', 'minimog' ),
			],
			'condition' => [
				'custom_query!' => 'yes',
				'source!'       => 'by_id',
			],
		] );

		// Custom term.
		$repeater = new Repeater();

		$repeater->add_control( 'cat_id', [
			'label'    => __( 'Select Categories', 'minimog' ),
			'type'     => Controls_Manager::SELECT2,
			'multiple' => false,
			'default'  => '',
			'options'  => $options,
		] );

		$repeater->add_control( 'image', [
			'label'   => __( 'Choose Image', 'minimog' ),
			'type'    => Controls_Manager::MEDIA,
			'dynamic' => [
				'active' => true,
			],
			'default' => [],
		] );

		$this->add_control( 'custom_categories', [
			'label'       => __( 'Categories', 'minimog' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [],
			'title_field' => "{{{ MinimogElementor.helpers.getRepeaterSelectOptionText('tm-product-categories-grid', 'custom_categories', 'cat_id', cat_id ) }}}",
			'condition'   => [
				'custom_query' => 'yes',
			],
		] );

		$this->end_controls_section();
	}

	private function add_cat_style_section() {
		$this->start_controls_section( 'cat_style_section', [
			'label' => __( 'Categories', 'minimog' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'background_box',
			'types'    => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .cat-wrap',
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => __( 'Padding', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'body:not(.rtl) {{WRAPPER}} .cat-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .cat-wrap'       => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_radius', [
			'label'      => __( 'Border box radius', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => 'px',
			'selectors'  => [
				'{{WRAPPER}} .cat-wrap'       => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .cat-wrap:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'text_align', [
			'label'                => __( 'Alignment', 'minimog' ),
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_text_align(),
			'selectors_dictionary' => [
				'left'   => 'text-align: start; justify-content: flex-start;',
				'center' => 'text-align: center; justify-content: center;',
				'right'  => 'text-align: end; justify-content: flex-end;',
			],
			'selectors'            => [
				'{{WRAPPER}} .cat-wrap'              => '{{VALUE}};',
				'{{WRAPPER}} .minimog-image-wrapper' => '{{VALUE}};',
			],
		] );

		$this->add_control( 'grid_border_color', [
			'label'     => __( 'Grid Border Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .minimog-product-categories' => '--grid-border-color: {{VALUE}};',
			],
			'condition' => [
				'style' => '12',
			],
		] );

		$this->end_controls_section();
	}

	private function add_cat_image_style_section() {
		$this->start_controls_section( 'cat_image_style_section', [
			'label' => __( 'Image', 'minimog' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'image_size', [
			'label'      => __( 'Size', 'minimog' ),
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
				'{{WRAPPER}} .minimog-product-categories .minimog-image' => 'width: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '03', '07', '09', '12' ],
			],
		] );

		$this->add_responsive_control( 'image_margin', [
			'label'      => __( 'Margin', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'body:not(.rtl) {{WRAPPER}} .minimog-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .minimog-image-wrapper'       => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'image_radius', [
			'label'      => __( 'Radius', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .minimog-product-categories .minimog-image'              => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .minimog-product-categories .minimog-image img'          => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .minimog-product-categories .minimog-image-inner:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .minimog-product-categories .minimog-image-inner:after'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		// Image Effect
		$this->start_controls_tabs( 'images_effects', [ 'separator' => 'before', ] );

		$this->start_controls_tab( 'images_effects_normal_tab', [
			'label' => __( 'Normal', 'minimog' ),
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters',
			'selector' => '{{WRAPPER}} .image',
		] );

		$this->add_control( 'images_opacity', [
			'label'     => __( 'Opacity', 'minimog' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .image' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'images_effects_hover_tab', [
			'label' => __( 'Hover', 'minimog' ),
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters_hover',
			'selector' => '{{WRAPPER}} .minimog-box:hover .image',
		] );

		$this->add_control( 'images_opacity_hover', [
			'label'     => __( 'Opacity', 'minimog' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .minimog-box:hover .image' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_cat_info_style_section() {
		$this->start_controls_section( 'cat_info_style_section', [
			'label' => __( 'Category Info', 'minimog' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'cat_info_horizontal_alignment', [
			'label'                => __( 'Horizontal Alignment', 'minimog' ),
			'label_block'          => true,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'toggle'               => false,
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'default'              => '',
			'selectors'            => [
				'{{WRAPPER}} .category-info-wrapper' => 'align-items: {{VALUE}}',
			],
			'condition'            => [
				'style' => '06',
			],
		] );

		$this->add_responsive_control( 'cat_info_vertical_alignment', [
			'label'                => __( 'Vertical Alignment', 'minimog' ),
			'label_block'          => true,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_vertical_alignment_full(),
			'toggle'               => false,
			'selectors_dictionary' => [
				'top'     => 'flex-start',
				'middle'  => 'center',
				'bottom'  => 'flex-end',
				'stretch' => 'space-between',
			],
			'default'              => '',
			'selectors'            => [
				'{{WRAPPER}} .category-info-wrapper' => 'justify-content: {{VALUE}}',
			],
			'condition'            => [
				'style' => '06',
			],
		] );

		$this->add_responsive_control( 'info_box_padding', [
			'label'      => __( 'Padding', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'body:not(.rtl) {{WRAPPER}} .category-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .category-info'       => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'info_box_max_width', [
			'label'          => __( 'Max Width', 'minimog' ),
			'type'           => Controls_Manager::SLIDER,
			'default'        => [
				'unit' => 'px',
			],
			'tablet_default' => [
				'unit' => 'px',
			],
			'mobile_default' => [
				'unit' => 'px',
			],
			'size_units'     => [ 'px', '%' ],
			'range'          => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1000,
				],
			],
			'selectors'      => [
				'{{WRAPPER}} .category-info-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		] );

		// Name.
		$this->add_control( 'name_style_hr', [
			'label'     => __( 'Name', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .category-name',
		] );

		$this->start_controls_tabs( 'cat_name_color_tabs' );

		$this->start_controls_tab( 'cat_name_color_normal_tab', [
			'label' => __( 'Normal', 'minimog' ),
		] );

		$this->add_control( 'cat_name_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-name' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'cat_name_color_hover_tab', [
			'label' => __( 'Hover', 'minimog' ),
		] );

		$this->add_control( 'cat_name_hover_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .minimog-box:hover .category-name' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Count
		$this->add_control( 'count_style_hr', [
			'label'     => __( 'Count', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'show_count' => 'yes',
			],
		] );

		$this->add_responsive_control( 'count_spacing', [
			'label'      => __( 'Spacing', 'minimog' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .category-count' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [
				'show_count' => 'yes',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'cat_count_typography',
			'selector'  => '{{WRAPPER}} .category-count',
			'condition' => [
				'show_count' => 'yes',
			],
		] );

		$this->add_control( 'cat_count_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-count' => 'color: {{VALUE}};',
			],
			'condition' => [
				'show_count' => 'yes',
			],
		] );

		// Button
		$this->add_control( 'button_style_hr', [
			'label'     => __( 'Button', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => [ '02', '05', '09' ],
			],
		] );

		$this->add_responsive_control( 'button_min_height', [
			'label'      => __( 'Height', 'minimog' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'max'  => 300,
					'step' => 1,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .tm-button' => 'min-height: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '02', '05' ],
			],
		] );

		$this->add_responsive_control( 'button_min_width', [
			'label'      => __( 'Width', 'minimog' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%', 'px' ],
			'range'      => [
				'%'  => [
					'max'  => 100,
					'step' => 1,
				],
				'px' => [
					'max'  => 1000,
					'step' => 1,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .tm-button' => 'min-width: {{SIZE}}{{UNIT}}',
			],
			'condition'  => [
				'style' => [ '02', '05' ],
			],
		] );

		$this->add_control( 'button_rounded', [
			'label'      => __( 'Rounded', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .tm-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '02', '05' ],
			],
		] );

		$this->add_control( 'button_border_width', [
			'label'      => __( 'Border Width', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .tm-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '02', '05' ],
			],
		] );

		$this->add_responsive_control( 'button_padding', [
			'label'      => __( 'Padding', 'minimog' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'body:not(.rtl) {{WRAPPER}} .tm-button.style-text'                                        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body:not(.rtl) {{WRAPPER}} .tm-button.style-flat'                                        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body:not(.rtl) {{WRAPPER}} .tm-button.style-border'                                      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body:not(.rtl) {{WRAPPER}} .tm-button.style-bottom-line .button-content-wrapper'         => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body:not(.rtl) {{WRAPPER}} .tm-button.style-bottom-thick-line .button-content-wrapper'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body:not(.rtl) {{WRAPPER}} .tm-button.style-bottom-line-winding .button-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .tm-button.style-text'                                              => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .tm-button.style-flat'                                              => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .tm-button.style-border'                                            => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .tm-button.style-bottom-line .button-content-wrapper'               => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .tm-button.style-bottom-thick-line .button-content-wrapper'         => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				'body.rtl {{WRAPPER}} .tm-button.style-bottom-line-winding .button-content-wrapper'       => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
			],
			'condition'  => [
				'style' => [ '02', '05', '09' ],
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'button_typography',
			'selector'  => '{{WRAPPER}} .tm-button',
			'condition' => [
				'style' => [ '02', '05', '09' ],
			],
		] );

		$this->start_controls_tabs( 'button_skin_tabs', [
			'condition' => [
				'style' => [ '02', '05', '09' ],
			],
		] );

		$this->start_controls_tab( 'button_skin_normal_tab', [
			'label' => __( 'Normal', 'minimog' ),
		] );

		$this->add_control( 'button_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-button' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'button_line_color', [
			'label'     => __( 'Line Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-button.style-bottom-line .button-content-wrapper:before'       => 'background: {{VALUE}};',
				'{{WRAPPER}} .tm-button.style-bottom-thick-line .button-content-wrapper:before' => 'background: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '09' ],
			],
		] );

		$this->add_control( 'button_background', [
			'label'     => __( 'Background Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-button' => '--minimog-tm-button-hover-background: {{VALUE}}; background-color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'button_box_shadow',
			'selector' => '{{WRAPPER}} .tm-button',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_skin_hover_tab', [
			'label' => __( 'Hover', 'minimog' ),
		] );

		$this->add_control( 'hover_button_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .minimog-box:hover .tm-button' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hover_button_line_color', [
			'label'     => __( 'Line Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tm-button.style-bottom-line .button-content-wrapper:after'       => 'background: {{VALUE}};',
				'{{WRAPPER}} .tm-button.style-bottom-thick-line .button-content-wrapper:after' => 'background: {{VALUE}};',
			],
			'condition' => [
				'style' => [ '09' ],
			],
		] );

		$this->add_control( 'hover_button_background', [
			'label'     => __( 'Background Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .minimog-box:hover .tm-button' => '--minimog-tm-button-hover-background: {{VALUE}}; background-color: {{VALUE}};',
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'button_hover_box_shadow',
			'selector' => '{{WRAPPER}} .minimog-box:hover .tm-button',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_cat_min_price_style_section() {
		$this->start_controls_section( 'cat_min_price_style_section', [
			'label'     => __( 'Min Price', 'minimog' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'show_min_price' => 'yes',
			],
		] );

		$this->add_responsive_control( 'cat_min_price_spacing', [
			'label'      => __( 'Spacing', 'minimog' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .category-min-price' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'cat_min_price_typography',
			'selector' => '{{WRAPPER}} .category-min-price',
		] );

		$this->add_control( 'cat_min_price_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-min-price' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cat_min_price_amount_style_hr', [
			'label'     => __( 'Amount', 'minimog' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'cat_min_price_amount_typography',
			'selector' => '{{WRAPPER}} .category-min-price .amount',
		] );

		$this->add_control( 'cat_min_price_amount_color', [
			'label'     => __( 'Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .category-min-price .amount' => 'color: {{VALUE}} !important;',
			],
		] );

		$this->end_controls_section();
	}

	private function query_terms() {
		$settings = $this->get_settings_for_display();

		$term_args = [
			'taxonomy'   => self::PRODUCT_CATEGORY,
			'number'     => $settings['number'],
			'hide_empty' => 'yes' === $settings['hide_empty'],
		];

		// Setup order.
		switch ( $settings['source'] ) {
			case 'by_id':
				$term_args['orderby'] = 'include';
				break;
			default:
				if ( 'order' === $settings['orderby'] ) {
					$term_args['orderby']  = 'meta_value_num';
					$term_args['meta_key'] = 'order';
				} else {
					$term_args['orderby'] = $settings['orderby'];
					$term_args['order']   = $settings['order'];
				}
				break;
		}

		// Setup source.
		switch ( $settings['source'] ) {
			case 'by_id':
				$term_args['include'] = $settings['categories'];
				break;
			case 'by_parent' :
				$term_args['parent'] = $settings['parent'];
				break;
			case 'current_subcategories':
				$term_args['parent'] = get_queried_object_id();
				break;
		}

		$this->terms = get_terms( $term_args );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'grid-wrapper', 'class', 'minimog-grid-wrapper minimog-product-categories' );
		$this->add_render_attribute( 'grid-wrapper', 'class', 'style-' . $settings['style'] );

		$this->add_render_attribute( 'content-wrapper', 'class', 'minimog-grid lazy-grid' );

		$grid_options = $this->get_grid_options( $settings );

		$this->add_render_attribute( 'grid-wrapper', 'data-grid', wp_json_encode( $grid_options ) );
		$grid_args_style = \Minimog_Helper::grid_args_to_html_style( $grid_options );
		if ( ! empty( $grid_args_style ) ) {
			$this->add_render_attribute( 'grid-wrapper', 'style', $grid_args_style );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'grid-wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'content-wrapper' ); ?>>
				<?php $this->print_grid(); ?>
			</div>
		</div>
		<?php
	}

	protected function get_grid_options( array $settings ) {
		$grid_options = [
			'type' => 'grid',
		];

		if ( ! empty( $settings['zigzag_reversed'] ) && 'yes' === $settings['zigzag_reversed'] ) {
			$grid_options['zigzagReversed'] = 1;
		}

		$columns_settings       = $this->parse_responsive_settings( $settings, 'grid_columns', 'columns' );
		$gutter_settings        = $this->parse_responsive_settings( $settings, 'grid_gutter', 'gutter' );
		$zigzag_height_settings = $this->parse_responsive_settings( $settings, 'zigzag_height', 'zigzagHeight' );

		$grid_options += $columns_settings + $gutter_settings + $zigzag_height_settings;

		return $grid_options;
	}

	private function print_grid() {
		$settings = $this->get_settings_for_display();

		$loop_settings = [
			'style'          => $settings['style'],
			'show_count'     => ! empty( $settings['show_count'] ) && 'yes' === $settings['show_count'] ? 1 : 0,
			'show_min_price' => ! empty( $settings['show_min_price'] ) && 'yes' === $settings['show_min_price'] ? 1 : 0,
			'button_text'    => $settings['button_text'],
			'layout'         => 'grid',
		];

		if ( isset( $settings['thumbnail_default_size'] ) && '1' !== $settings['thumbnail_default_size'] ) {
			$loop_settings['thumbnail_size'] = \Minimog_Image::elementor_parse_image_size( $settings );
		}

		if ( 'yes' === $settings['custom_query'] && ! empty( $settings['custom_categories'] ) ) {
			foreach ( $settings['custom_categories'] as $item ) {
				if ( empty( $item['cat_id'] ) ) {
					return;
				}

				$custom_settings = $loop_settings;

				if ( ! empty( $item['image']['id'] ) ) {
					$custom_settings['custom_thumbnail_id'] = $item['image']['id'];
				}

				$terms = get_terms( [
					'taxonomy'   => 'product_cat',
					'include'    => $item['cat_id'],
					'hide_empty' => 'yes' === $settings['hide_empty'],
				] );

				if ( empty( $terms ) || is_wp_error( $terms ) ) {
					continue;
				}

				$category = $terms[0];

				minimog_get_wc_template_part( 'content-product-cat', '', [
					'settings' => $custom_settings,
					'category' => $category,
				] );
			}
		} else {
			$this->query_terms();

			if ( empty( $this->terms ) ) {
				return;
			}

			foreach ( $this->terms as $category ) {
				minimog_get_wc_template_part( 'content-product-cat', '', [
					'settings' => $loop_settings,
					'category' => $category,
				] );
			}
		}
	}
}
