<?php
/**
 * Theme Admin Class.
 *
 * Manages Admin functions
 *
 * @package Classy
 */

namespace Classy;

/**
 * Class Admin
 */
class Admin {

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		add_filter( 'mce_buttons_2', 	[$this, 'addFormats']);
		add_filter( 'tiny_mce_before_init', [$this, 'my_mce_before_init_insert_formats']);
    }

	public function addFormats($buttons)
	{
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}

	function my_mce_before_init_insert_formats( $init_array ) {
		// Define the style_formats array
		$style_formats = array(
			array(
				'title' => 'Preview Only',
				'block' => 'blockquote',
				'classes' => 'preview-only',
				'wrapper' => true,
			),
			array(
				'title' => 'Header List',
				'block' => 'ul',
				'classes' => 'header-list',
				'wrapper' => true,
			),
			array(
				'title' => 'Credits',
				'block' => 'blockquote',
				'classes' => 'credits',
				'wrapper' => true,
			),
			array(
				'title' => 'Cursive',
				'block' => 'blockquote',
				'classes' => 'font-cursive',
				'wrapper' => true,
			),
		);
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $style_formats );

		return $init_array;

	}
}
