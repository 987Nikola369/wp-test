<?php
defined( 'ABSPATH' ) || exit;

/**
 * Initial setup for this theme
 */
class Minimog_Init {

	protected static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function initialize() {
		// Add theme supports.
		add_action( 'after_setup_theme', array( $this, 'setup' ) );

		// Add theme supports.
		add_action( 'init', array( $this, 'load_text_domain' ), 1 );

		// Core filters.
		add_filter( 'insight_core_info', array( $this, 'core_info' ) );

		// Add backwards compatibility for older versions for title tag feature.
		if ( ! function_exists( '_wp_render_title_tag' ) ) {
			add_action( 'wp_head', array( $this, 'minimog_render_title' ) );
		}
	}

	function minimog_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @access public
	 */
	public function setup() {
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'           => __( 'Primary', 'minimog' ),
			'mobile-menu'       => __( 'Mobile Menu', 'minimog' ) . '<span class="hint--top" aria-label="Only use this location if you want to display different menu on mobile. If no menus set to this location then the menu setted to Primary location will be use.">[?]</span>',
			'category-dropdown' => __( 'Category Dropdown', 'minimog' ),
		) );

		// Adjust the content-width.
		$GLOBALS['content_width'] = apply_filters( 'content_width', 640 );

		/*
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */

		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		] );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', [
			'aside',
			'image',
			'gallery',
			'video',
			'audio',
			'quote',
			'link',
		] );

		/*
		 * Set up the WordPress core custom background feature.
		 */
		add_theme_support( 'custom-background', apply_filters( 'custom_background_args', array(
			'default-color' => '#ffffff',
			'default-image' => '',
		) ) );

		// Support editor style.
		add_editor_style( array( 'editor-style.css' ) );
		add_theme_support( 'custom-header' );

		/*
		 * Support selective refresh for widget
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'insight-core' );
		add_theme_support( 'insight-detect' );
		add_theme_support( 'insight-kungfu' );
		add_theme_support( 'insight-metabox' );
		add_theme_support( 'insight-megamenu' );
		add_theme_support( 'insight-sidebar' );

		// Gutenberg.
		add_theme_support( 'editor-styles' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
	}

	public function load_text_domain() {
		// Then, fallback to the centralized languages folder
		load_theme_textdomain( 'minimog', trailingslashit( WP_LANG_DIR ) . 'themes' );

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'minimog', MINIMOG_THEME_DIR . '/languages' );
	}

	/**
	 * Core info
	 *
	 * @param $info
	 *
	 * @return mixed
	 */
	function core_info( $info ) {
		$info['icon']    = MINIMOG_THEME_URI . '/assets/admin/images/logo.png';
		$info['tf']      = 'https://themeforest.net/item/minimog-the-high-converting-ecommerce-wordpress-theme/36947163';
		$info['docs']    = 'https://minimog-wp.gitbook.io/minimog-ecommerce-wordpress-theme/';
		$info['child']   = 'https://www.dropbox.com/s/mk4fguckv9xmyyf/minimog-child.zip?dl=1';
		$info['update']  = 'https://api.thememove.com/update/minimog';
		$info['api']     = 'https://api.thememove.com/update/minimog';
		$info['support'] = 'https://thememove.ticksy.com/submit/#100019229';
		$info['faqs']    = 'https://thememove.ticksy.com/articles/';
		$info['desc']    = __( 'Thank you for using our theme, please reward it a full five-star &#9733;&#9733;&#9733;&#9733;&#9733; rating.', 'minimog' );

		return $info;
	}
}
