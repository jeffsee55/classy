<?php
/**
 * Theme Appearance Class.
 *
 * Manages JS & CSS enqueuing of the theme.
 *
 * @package Classy
 */

namespace Classy;

/**
 * Class Appearance.
 */
class Appearance {

	/**
	 * Appearance constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_print_scripts', array( $this, 'init_js_vars' ) );

		add_filter( 'post_gallery', array($this, 'add_gallery_classes'), 10, 3 );

		add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );

	}

	/**
	 * Enqueues styles
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'main', CLASSY_THEME_DIR . 'dist/css/main.css', array(), CLASSY_THEME_VERSION, 'all' );

	}

	/**
	 * Enqueues scripts
	 */
	public function enqueue_scripts() {

			wp_enqueue_script( 'main_script', CLASSY_THEME_DIR . 'dist/js/main.js', array( 'jquery' ), CLASSY_THEME_VERSION, true );
			wp_localize_script( "main_script", 'classy',
				[
					'ajaxUrl' => admin_url( 'admin-ajax.php' ), //url for php file that process ajax request to WP
					'nonce' => wp_create_nonce( 'classy' ),// this is a unique token to prevent form hijacking
				]
			);

	}

	public function add_gallery_classes($output = '', $atts, $instance) {
		$gallery = new Gallery($output = '', $atts, $instance);
		return $gallery->display();
	}

	/**
	 * Load needed options & translations into template.
	 */
	public function init_js_vars() {

		$options = array(
			'base_url'          => home_url( '' ),
			'blog_url'          => home_url( 'archives/' ),
			'template_dir'      => CLASSY_THEME_DIR,
			'ajax_load_url'     => admin_url( 'admin-ajax.php' ),
			'is_mobile'         => (int) wp_is_mobile(),
		);

		wp_localize_script(
			'theme_plugins',
			'theme',
			$options
		);

	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function setup_theme() {
		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'header-menu' => __( 'Header Menu', Classy::textdomain() ),
			'footer-menu' => __( 'Footer Menu', Classy::textdomain() ),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */

		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		add_theme_support( 'custom-logo', array(
		    'height'      => 100,
		    'width'       => 400,
		    'flex-height' => true,
		    'flex-width'  => true,
		    'header-text' => array( 'Heid & Seek', 'FOOD, FITNESS, FASHION, FELINES' ),
		) );

		// we don't care about the height,only the width
		add_image_size('gallery', 2000, 900, false);

		// resize post thumnbnails to be a usable size
		set_post_thumbnail_size(300, 300, true);

		add_image_size('hero', 1600, 1600, false);

		add_filter( 'image_size_names_choose', function($sizes) {
			return array_merge( $sizes, array(
		        'gallery' => __( 'Gallery Size' ),
		    ) );
		});
	}
}
