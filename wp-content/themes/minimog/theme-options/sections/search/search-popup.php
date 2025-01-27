<?php
Redux::set_section( Minimog_Redux::OPTION_NAME, array(
	'title'      => __( 'Search Popup', 'minimog' ),
	'id'         => 'search_popup',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'section_popup_search_form',
			'type'     => 'tm_heading',
			'title'    => 'Search Form',
			'indent'   => true,
			'collapse' => 'show',
		),
		array(
			'id'       => 'popup_search_categories_enable',
			'type'     => 'switch',
			'title'    => 'Categories dropdown',
			'subtitle' => 'Display categories dropdown to narrow search results.',
			'default'  => false,
			'on'       => __( 'Show', 'minimog' ),
			'off'      => __( 'Hide', 'minimog' ),
		),
		array(
			'id'       => 'popup_search_ajax_disable',
			'type'     => 'switch',
			'title'    => 'Disable ajax search',
			'subtitle' => 'This will disable the AJAX search function in theme. Choose \'Yes\' if you want to use a third-party search plugin.',
			'default'  => false,
			'on'       => __( 'Yes', 'minimog' ),
			'off'      => __( 'No', 'minimog' ),
		),
		array(
			'type'        => 'text',
			'id'          => 'popup_search_ajax_auto_delay',
			'title'       => 'Search delay',
			'subtitle'    => 'Control delay time before auto searching. Leave blank to use default.',
			'description' => 'Within (millisecond). Default 1000 ms',
			'attributes'  => [
				'type' => 'number',
				'step' => 50,
				'min'  => 0,
			],
		),
		array(
			'id'       => 'section_popup_search_scope',
			'type'     => 'tm_heading',
			'title'    => 'Search Scope',
			'indent'   => true,
			'collapse' => 'show',
		),
		array(
			'id'            => 'section_popup_search_number_results',
			'title'         => __( 'Number items', 'minimog' ),
			'description'   => __( 'Controls the number of search results.', 'minimog' ),
			'type'          => 'slider',
			'default'       => Minimog_Redux::get_default_setting( 'section_popup_search_number_results' ),
			'min'           => 5,
			'max'           => 50,
			'step'          => 1,
			'display_value' => 'text',
		),
		array(
			'id'    => 'popup_search_in_content',
			'type'  => 'switch',
			'title' => 'Search in description',
			'on'    => __( 'Yes', 'minimog' ),
			'off'   => __( 'No', 'minimog' ),
		),
		array(
			'id'    => 'popup_search_in_excerpt',
			'type'  => 'switch',
			'title' => 'Search in short description',
			'on'    => __( 'Yes', 'minimog' ),
			'off'   => __( 'No', 'minimog' ),
		),
		array(
			'id'    => 'popup_search_in_sku',
			'type'  => 'switch',
			'title' => 'Search in SKU',
			'on'    => __( 'Yes', 'minimog' ),
			'off'   => __( 'No', 'minimog' ),
		),
		array(
			'id'       => 'section_popup_search_extra',
			'type'     => 'tm_heading',
			'title'    => 'Extra Options',
			'indent'   => true,
			'collapse' => 'show',
		),
		array(
			'id'           => 'popular_search_keywords',
			'type'         => 'repeater',
			'title'        => __( 'Popular search keywords', 'minimog' ),
			'item_name'    => __( 'Keyword', 'minimog' ),
			'bind_title'   => 'text',
			'group_values' => true,
			'fields'       => array(
				array(
					'id'    => 'text',
					'title' => __( 'Keyword', 'minimog' ),
					'type'  => 'text',
				),
			),
			'default'      => [
				'Redux_repeater_data' => [
					[ 'title' => '' ],
					[ 'title' => '' ],
					[ 'title' => '' ],
				],
				'text'                => [
					'T-Shirt',
					'Blue',
					'Jacket',
				],
			],
		),
	),
) );
