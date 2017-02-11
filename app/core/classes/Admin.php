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
        add_action( 'save_post',        [$this, 'saveMeta']);
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
				'inline' => 'span',
				'block' => 'div',
				'classes' => 'preview-only',
				'wrapper' => true,
			),
			array(
				'title' => 'Credits',
				'inline' => 'span',
				'block' => 'div',
				'classes' => 'credits',
				'wrapper' => true,
			),
			array(
				'title' => 'Cursive',
				'inline' => 'span',
				'block' => 'div',
				'classes' => 'font-cursive',
				'wrapper' => true,
			),
		);
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $style_formats );

		return $init_array;

	}
}
