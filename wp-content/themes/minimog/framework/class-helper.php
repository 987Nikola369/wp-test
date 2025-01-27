<?php
defined( 'ABSPATH' ) || exit;

/**
 * Helper functions
 */
if ( ! class_exists( 'Minimog_Helper' ) ) {
	class Minimog_Helper {

		public static function e( $var = '' ) {
			echo "{$var}";
		}

		public static function get_post_meta( $name, $default = false ) {
			global $minimog_page_options;

			if ( $minimog_page_options != false && isset( $minimog_page_options[ $name ] ) ) {
				return $minimog_page_options[ $name ];
			}

			return $default;
		}

		public static function get_the_post_meta( $options, $name, $default = false ) {
			if ( $options != false && isset( $options[ $name ] ) ) {
				return $options[ $name ];
			}

			return $default;
		}

		/**
		 * @return array
		 */
		public static function get_list_revslider() {
			global $wpdb;
			$revsliders = array(
				'' => 'Select a slider',
			);

			if ( function_exists( 'rev_slider_shortcode' ) ) {

				$table_name = $wpdb->prefix . 'revslider_sliders';
				$query      = $wpdb->prepare( "SELECT * FROM $table_name WHERE type != %s ORDER BY title ASC", 'template' );
				$results    = $wpdb->get_results( $query );
				if ( ! empty( $results ) ) {
					foreach ( $results as $result ) {
						$revsliders[ $result->alias ] = $result->title;
					}
				}
			}

			return $revsliders;
		}

		/**
		 * @param bool $default_option
		 *
		 * @return array
		 */
		public static function get_registered_sidebars( $default_option = false, $empty_option = true ) {
			global $wp_registered_sidebars;
			$sidebars = array();
			if ( $empty_option === true ) {
				$sidebars['none'] = __( 'No Sidebar', 'minimog' );
			}
			if ( $default_option === true ) {
				$sidebars['default'] = __( 'Default', 'minimog' );
			}
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[ $sidebar['id'] ] = $sidebar['name'];
			}

			return $sidebars;
		}

		/**
		 * Get list sidebar positions
		 *
		 * @return array
		 */
		public static function get_list_sidebar_positions( $default = false ) {
			$positions = array(
				'left'  => __( 'Left', 'minimog' ),
				'right' => __( 'Right', 'minimog' ),
			);


			if ( $default === true ) {
				$positions['default'] = __( 'Default', 'minimog' );
			}

			return $positions;
		}

		/**
		 * Get content of file
		 *
		 * @param string $path
		 *
		 * @return mixed
		 */
		static function get_file_contents( $path = '' ) {
			if ( $path !== '' ) {
				global $wp_filesystem;

				minimog_require_file_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();

				// $path = minimog_valid_file_path( $path );

				if ( file_exists( $path ) ) {
					return $wp_filesystem->get_contents( $path );
				}
			}

			return '';
		}

		public static function strposa( $haystack, $needle, $offset = 0 ) {
			if ( ! is_array( $needle ) ) {
				$needle = array( $needle );
			}
			foreach ( $needle as $query ) {
				if ( strpos( $haystack, $query, $offset ) !== false ) {
					return true;
				} // stop on first true result
			}

			return false;
		}

		public static function str_compare( $str1, $str2 ) {
			$str1 = strtolower( $str1 );
			$str2 = strtolower( $str2 );

			return $str1 === $str2;
		}

		public static function w3c_iframe( $iframe ) {
			$iframe = str_replace( 'frameborder="0"', '', $iframe );
			$iframe = str_replace( 'frameborder="no"', '', $iframe );
			$iframe = str_replace( 'scrolling="no"', '', $iframe );
			$iframe = str_replace( 'gesture="media"', '', $iframe );
			$iframe = str_replace( 'allow="encrypted-media"', '', $iframe );

			return $iframe;
		}

		public static function calculate_percentage( $value1, $value2 ) {
			$percent = ( $value1 > 0 ) ? ( $value1 * 100 ) / $value2 : 0;

			return $percent;
		}

		/**
		 * @param string|array $var Data to sanitize.
		 *
		 * @return string|array
		 * @see wc_clean() Function clone from woocommerce.
		 *
		 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
		 * Non-scalar values are ignored.
		 *
		 */
		public static function data_clean( $var ) {
			if ( is_array( $var ) ) {
				return array_map( 'data_clean', $var );
			} else {
				return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
			}
		}

		/**
		 * Check search page has results
		 *
		 * @return boolean true if has any results
		 */
		public static function is_search_has_results() {
			if ( is_search() ) {
				global $wp_query;
				$result = 0 != $wp_query->found_posts;

				return $result;
			}

			return 0 != $GLOBALS['wp_query']->found_posts;
		}

		public static function get_wpforms_list( $args = array() ) {
			$results = [];

			if ( ! function_exists( 'wpforms' ) ) {
				return $results;
			}

			if ( isset( $args['context'] ) && 'options' === $args['context'] && ! is_admin() ) {
				return $results;
			}

			$wpf = wpforms()->form->get( '', array(
				'orderby' => 'title',
			) );

			if ( ! empty( $wpf ) ) {
				$results = array(
					'' => __( 'None', 'minimog' ),
				);
				foreach ( $wpf as $form ) {
					$results[ $form->ID ] = $form->post_title;
				}
			} else {
				$results = array(
					'' => __( 'No forms found', 'minimog' ),
				);
			}

			return $results;
		}

		public static function is_page_template( $template_file ) {
			$template_full = 'templates/' . $template_file;

			return is_page_template( $template_full );
		}

		public static function get_all_pages( $args = array() ) {
			$options = [
				0 => __( 'Select a page', 'minimog' ),
			];

			if ( isset( $args['context'] ) && 'options' === $args['context'] && ! is_admin() ) {
				return $options;
			}

			$pages = get_pages();

			if ( $pages ) {
				foreach ( $pages as $page ) {
					$options [ $page->ID ] = $page->post_title;
				}
			}

			return $options;
		}

		/**
		 * @param array $attributes
		 *
		 * @return string
		 */
		public static function convert_array_html_attributes_to_string( $attributes ) {
			$attr_str = '';

			foreach ( $attributes as $name => $value ) {
				switch ( $name ) {
					case 'href':
					case 'src':
					case 'data-src':
						$attr_str .= ' ' . $name . '="' . esc_url( $value ) . '"';
						break;
					case 'class':
						$value = is_array( $value ) ? implode( ' ', $value ) : $value;

						$attr_str .= ' ' . $name . '="' . esc_attr( $value ) . '"';
						break;
					default:
						$value = is_array( $value ) ? wp_json_encode( $value ) : $value;

						$attr_str .= ' ' . $name . '="' . esc_attr( $value ) . '"';
						break;
				}
			}

			return $attr_str;
		}

		/**
		 * @param int $timestamp timestamp
		 *
		 * @return string
		 */
		public static function time_ago( $timestamp, $echo = true ) {
			return sprintf( __( '%s ago', 'minimog' ), human_time_diff( $timestamp, current_time( 'timestamp' ) ) );
		}

		/**
		 * @param array      $array
		 * @param int|string $position
		 * @param mixed      $insert
		 */
		public static function array_insert( &$array, $position, $insert ) {
			if ( is_int( $position ) ) {
				array_splice( $array, $position, 0, $insert );
			} else {
				$pos   = array_search( $position, array_keys( $array ) );
				$array = array_merge( array_slice( $array, 0, $pos ), $insert, array_slice( $array, $pos ) );
			}
		}

		public static function get_sample_countdown_date() {
			$date = date( 'm/d/Y H:i:s', strtotime( '+1 month', strtotime( date( 'm/d/Y H:i:s' ) ) ) );

			return $date;
		}

		public static function is_demo_site() {
			if ( defined( 'MINIMOG_DEMO_SITE' ) && true === MINIMOG_DEMO_SITE ) {
				return true;
			}

			$domain = wp_parse_url( get_stylesheet_directory_uri() );
			$host   = $domain['host'];

			if ( 'minimog.thememove.com' === $host ) {
				return true;
			}

			return false;
		}

		public static function is_dev_mode() {
			return defined( 'MINIMOG_DEV_MODE' ) && MINIMOG_DEV_MODE;
		}

		public static function get_button_style_options() {
			return [
				'flat'                => __( 'Flat', 'minimog' ),
				'border'              => __( 'Border', 'minimog' ),
				'border-02'           => __( 'Border 02', 'minimog' ),
				'text'                => __( 'Text', 'minimog' ),
				'bottom-line'         => __( 'Bottom Line', 'minimog' ),
				'bottom-thick-line'   => __( 'Bottom Thick Line', 'minimog' ),
				'bottom-line-winding' => __( 'Bottom Line Winding', 'minimog' ),
				'3d'                  => '3D',
			];
		}

		public static function strpos_array( $haystack, $needles ) {
			if ( is_array( $needles ) ) {
				foreach ( $needles as $str ) {
					if ( is_array( $str ) ) {
						$pos = self::strpos_array( $haystack, $str );
					} else {
						$pos = strpos( $haystack, $str );
					}
					if ( $pos !== false ) {
						return $pos;
					}
				}

				return false;
			} else {
				return strpos( $haystack, $needles );
			}
		}

		public static function get_setting_md_label( $label ) {
			return $label . ' <span class="minimog-icon-tablet-alt minimog-icon-rotate-270"></span>';
		}

		public static function get_setting_sm_label( $label ) {
			return $label . ' <span class="minimog-icon-tablet-alt"></span>';
		}

		public static function get_setting_xs_label( $label ) {
			return $label . ' <span class="minimog-icon-mobile-alt"></span>';
		}

		public static function get_setting_md_tooltip( $label ) {
			return sprintf( __( '%1$s in Medium Device', 'minimog' ), $label );
		}

		public static function get_setting_sm_tooltip( $label ) {
			return sprintf( __( '%1$s in Small Device', 'minimog' ), $label );
		}

		public static function get_setting_xs_tooltip( $label ) {
			return sprintf( __( '%1$s in Extra Small Device', 'minimog' ), $label );
		}

		public static function parse_redux_repeater_field_values( $repeater_values ) {
			$results = [];

			/**
			 * Some case this array index in lowercase.
			 */
			if ( isset( $repeater_values['redux_repeater_data'] ) ) {
				$repeater_values['Redux_repeater_data'] = $repeater_values['redux_repeater_data'];
			}

			if ( isset( $repeater_values['Redux_repeater_data'][0] ) ) {
				foreach ( $repeater_values['Redux_repeater_data'] as $item_index => $item_title ) {
					$item = array();

					foreach ( $repeater_values as $field_name => $field_values ) {
						if ( 'Redux_repeater_data' === $field_name ) {
							continue;
						}

						$item[ $field_name ] = isset( $field_values[ $item_index ] ) ? $field_values[ $item_index ] : '';
					}

					array_push( $results, $item );
				}
			}

			return $results;
		}

		public static function get_redux_image_url( $image_field_name, $image_size = 'full', $default_url = '' ) {
			$image = \Minimog::setting( $image_field_name );

			if ( ! empty( $image['id'] ) ) {
				$image_url = \Minimog_Image::get_attachment_url_by_id( [
					'id'   => $image['id'],
					'size' => $image_size,
				] );
			} elseif ( ! empty( $image['url'] ) ) {
				$image_url = $image['url'];
			} else {
				$image_url = $default_url;
			}

			return $image_url;
		}

		public static function get_redux_image( $args ) {
			$defaults = [
				'setting_name'   => '',
				'image_size'     => 'full',
				'default_url'    => '',
				'img_attributes' => [
					'width'  => '',
					'height' => '',
					'alt'    => '',
				],
			];
			$args     = wp_parse_args( $args, $defaults );

			$image_setting = \Minimog::setting( $args['setting_name'] );

			if ( ! empty( $image_setting['id'] ) ) {
				return \Minimog_Image::get_attachment_by_id( [
					'id'   => $image_setting['id'],
					'size' => $args['image_size'],
				] );
			} else {
				$image_url = ! empty( $image_setting['url'] ) ? $image_setting['url'] : $args['default_url'];
				if ( ! empty( $image_url ) ) {
					$image_url = str_replace( 'http://', MINIMOG_PROTOCOL . '://', $image_url );

					$args['img_attributes']['loading'] = 'lazy';
					$args['img_attributes']['src']     = $image_url;

					$html = Minimog_Image::build_img_tag( $args['img_attributes'] );

					return Minimog_Image::build_lazy_img_tag( $html, $args['img_attributes']['width'], $args['img_attributes']['height'] );
				}
			}

			return '';
		}

		public static function slider_args_to_html_attr( $args ) {
			$attribute_str = '';
			$style         = '';

			$is_vertical = ! empty( $args['data-vertical'] );

			if ( $is_vertical ) {
				$style .= "--slides-width: 100%;";
			}

			foreach ( $args as $name => $value ) {
				$attribute_str .= ' ' . $name . '="' . $value . '"';

				if ( ! $is_vertical && stripos( $name, 'data-items-' ) !== false || stripos( $name, 'data-gutter-' ) !== false ) {
					$css_var = str_replace( 'data-', '--', $name );
					$style   .= "$css_var: $value;";
				}
			}

			if ( ! empty( $style ) ) {
				$attribute_str .= ' style="' . $style . '"';
			}

			return $attribute_str;
		}

		public static function grid_args_to_html_style( $args ) {
			$style = '';

			$selectors_dictionary = [
				'columnsWideScreen'  => '--grid-columns-widescreen',
				'columns'            => '--grid-columns-desktop',
				'columnsLaptop'      => '--grid-columns-laptop',
				'columnsTabletExtra' => '--grid-columns-tablet-extra',
				'columnsTablet'      => '--grid-columns-tablet',
				'columnsMobileExtra' => '--grid-columns-mobile-extra',
				'columnsMobile'      => '--grid-columns-mobile',
				'gutterWidescreen'   => '--grid-gutter-widescreen',
				'gutter'             => '--grid-gutter-desktop',
				'gutterLaptop'       => '--grid-gutter-laptop',
				'gutterTabletExtra'  => '--grid-gutter-tablet-extra',
				'gutterTablet'       => '--grid-gutter-tablet',
				'gutterMobileExtra'  => '--grid-gutter-mobile-extra',
				'gutterMobile'       => '--grid-gutter-mobile',
			];

			foreach ( $args as $name => $value ) {
				if ( isset( $selectors_dictionary[ $name ] ) ) {
					$css_var = $selectors_dictionary[ $name ];
					$style   .= "$css_var: $value;";
				}
			}

			return $style;
		}

		public static function grid_args_to_html_attr( $args ) {
			$style = self::grid_args_to_html_style( $args );

			if ( ! empty( $style ) ) {
				return ' style="' . $style . '"';
			}

			return '';
		}

		public static function get_grid_alternating_style( $grid_options, $grid_alternating, $css_selector ) {
			$is_reversed = $grid_alternating > 0;

			$css = '';
			$css .= self::get_grid_alternating_style_by_columns( $grid_options['columns'], $is_reversed, $css_selector, 'desktop' );
			$css .= self::get_grid_alternating_style_by_columns( $grid_options['columnsTablet'], $is_reversed, $css_selector, 'tablet' );

			//$css .= self::get_grid_alternating_style_by_columns( $grid_options['columnsMobileExtra'], $is_reversed, $css_selector, 'mobile-extra' );

			return $css;
		}

		public static function get_grid_alternating_style_by_columns( $columns, $is_reversed, $css_selector, $device_name ) {
			$alternating_columns = $is_reversed ? $columns + 1 : $columns - 1;
			$grid_cols           = self::find_smallest_multiple( $columns, $alternating_columns );
			$total_column_2_rows = $columns + $alternating_columns;

			$grid_style = "
			{$css_selector} {
				--grid-columns-{$device_name}: {$grid_cols} !important;
			}";

			switch ( $device_name ) {
				case 'mobile-extra':
					$grid_style .= "@media (max-width: 575px) { {$css_selector} { --grid-column: {$alternating_columns}; } }";
					break;
				case 'tablet':
					$grid_style .= "@media (min-width: 576px) and (max-width: 767px) { {$css_selector} { --grid-column: {$alternating_columns}; } }";
					break;
				default:
					$grid_style .= "@media (min-width: 768px) {
						{$css_selector} { --grid-column: {$alternating_columns}; }
					}";
					break;
			}

			$media_prefix = '';
			$col_css      = '';
			switch ( $device_name ) {
				case 'mobile-extra':
					$media_prefix = "@media (max-width: 575px)";
					break;
				case 'tablet':
					$media_prefix = "@media (min-width: 576px) and (max-width: 767px)";
					break;
				default:
					$media_prefix = "@media (min-width: 768px)";
					break;
			}

			for ( $i = $columns + 1; $i <= $total_column_2_rows; $i ++ ) {
				$col_css .= "{$css_selector} .grid-item:nth-child({$total_column_2_rows}n+{$i}) { --grid-column: {$columns} }";
			}
			$grid_style .= "$media_prefix { $col_css }";

			return $grid_style;
		}

		public static function find_smallest_multiple( $a, $b ) {
			return ( $a * $b ) / self::find_gcd( $a, $b );
		}

		/**
		 * Find the greatest common divisor of two numbers
		 *
		 * @return void
		 */
		public static function find_gcd( $x, $y ) {
			return $y === 0 ? $x : self::find_gcd( $y, $x % $y );
		}

		public static function build_extra_terms_query( $query_args, $taxonomies ) {
			if ( empty( $taxonomies ) ) {
				return $query_args;
			}

			$terms       = explode( ', ', $taxonomies );
			$tax_queries = array(); // List of taxonomies.

			if ( ! isset( $query_args['tax_query'] ) ) {
				$query_args['tax_query'] = array();

				foreach ( $terms as $term ) {
					$tmp       = explode( ':', $term );
					$taxonomy  = $tmp[0];
					$term_slug = $tmp[1];
					if ( ! isset( $tax_queries[ $taxonomy ] ) ) {
						$tax_queries[ $taxonomy ] = array(
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => array( $term_slug ),
						);
					} else {
						$tax_queries[ $taxonomy ]['terms'][] = $term_slug;
					}
				}
				$query_args['tax_query']             = array_values( $tax_queries );
				$query_args['tax_query']['relation'] = 'AND';
			} else {
				foreach ( $terms as $term ) {
					$tmp       = explode( ':', $term );
					$taxonomy  = $tmp[0];
					$term_slug = $tmp[1];

					foreach ( $query_args['tax_query'] as $key => $query ) {
						if ( is_array( $query ) ) {
							if ( $query['filter_key'] == $taxonomy ) {
								$query_args['tax_query'][ $key ]['terms'][] = $term_slug;
								break;
							} else {
								$query_args['tax_query'][] = array(
									'filter_key' => $taxonomy,
									'taxonomy'   => $taxonomy,
									'field'      => 'slug',
									'terms'      => array( $term_slug ),
								);
							}
						}
					}
				}
			}

			return $query_args;
		}

		/**
		 * Check given term is the deepest term in given terms.
		 *
		 * @param $post_term
		 * @param $post_terms
		 *
		 * @return mixed
		 */
		public static function get_deepest_term( &$post_term, &$post_terms ) {
			$is_deepest = true;
			foreach ( $post_terms as $key => $term ) {
				if ( $term->parent === $post_term->term_id ) {
					$post_term = $term;
					unset( $post_terms[ $key ] );
					$is_deepest = false;
				}
			}

			if ( $is_deepest ) {
				return $post_term;
			}

			return self::get_deepest_term( $post_term, $post_terms );
		}

		/**
		 * Check given string has specific wrap tag.
		 *
		 * @param $html_string
		 * @param $tagname HTML tag name to check
		 *
		 * @return bool
		 */
		public static function has_html_tag( $html_string, $tagname ) {
			$pattern = "/<$tagname ?.*>(.*?)<\/$tagname>/";
			preg_match( $pattern, $html_string, $matches );

			return ! empty( $matches );
		}
	}

	new Minimog_Helper();
}
