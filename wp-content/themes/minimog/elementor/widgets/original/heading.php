<?php

namespace Minimog_Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

defined( 'ABSPATH' ) || exit;

class Modify_Widget_Heading extends Modify_Base {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function initialize() {
		add_action( 'elementor/element/heading/section_title_style/before_section_end', [
			$this,
			'before_end_section_title_style',
		] );

		add_action( 'elementor/element/heading/section_title_style/after_section_end', [
			$this,
			'section_title_style',
		] );
	}

	/**
	 * @param \Elementor\Widget_Base $element The edited element.
	 */
	public function before_end_section_title_style( $element ) {
		$element->start_injection( [
			'type' => 'control',
			'at'   => 'after',
			'of'   => 'title_color',
		] );

		$element->add_control( 'link_hover_color', [
			'label'     => __( 'Link Hover Color', 'minimog' ),
			'type'      => Controls_Manager::COLOR,
			'global' => [
				'default' => Global_Colors::COLOR_PRIMARY,
			],
			'selectors' => [
				// Stronger selector to avoid section style from overwriting.
				'{{WRAPPER}}.elementor-widget-heading .elementor-heading-title a:hover' => 'color: {{VALUE}} !important;',
			],
		] );

		$element->end_injection();
	}

	/**
	 * @param \Elementor\Widget_Base $element The edited element.
	 */
	public function section_title_style( $element ) {
		$element->start_controls_section( 'heading_dimension_section', [
			'tab'   => Controls_Manager::TAB_STYLE,
			'label' => __( 'Dimension', 'minimog' ),
		] );

		$element->add_responsive_control( 'heading_max_width', [
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
					'max' => 1600,
				],
			],
			'selectors'      => [
				'{{WRAPPER}} .elementor-heading-title' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$element->add_responsive_control( 'alignment', [
			'label'                => __( 'Alignment', 'minimog' ),
			'label_block'          => false,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: flex; justify-content: {{VALUE}}',
			],
		] );

		$element->end_controls_section();
	}
}

Modify_Widget_Heading::instance()->initialize();
