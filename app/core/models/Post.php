<?php
/**
 * Wrapper for WP_Post.
 *
 * @package Classy\Models
 */

namespace Classy\Models;

use Classy\Basis;
use Classy\Comment;
use Classy\Helper;

/**
 * Class Post.
 */
class Post extends Basis {

	/**
	 * Current post id.
	 *
	 * @var int
	 */
	public $ID;

	/**
	 * Stores current post object.
	 *
	 * @var \WP_Post
	 */
	protected $object;

	/**
	 * Post title.
	 *
	 * @var string
	 */
	public $post_title;

	/**
	 * Post name.
	 *
	 * @var string
	 */
	public $post_name;

	/**
	 * Post content (raw).
	 *
	 * @var string
	 */
	public $post_content;

	/**
	 * Post type.
	 *
	 * @var string
	 */
	public $post_type;

	/**
	 * Post author id.
	 *
	 * @var int
	 */
	public $post_author;

	/**
	 * Post date. String as stored in the WP database, ex: 2012-04-23 08:11:23.
	 *
	 * @var string
	 */
	public $post_date;

	/**
	 * Post excerpt (raw).
	 *
	 * @var string
	 */
	public $post_excerpt;

	/**
	 * Post status. It can be draft, publish, pending, private, trash, etc.
	 *
	 * @var string
	 */
	public $post_status;

	/**
	 * Post permalink.
	 *
	 * @var string
	 */
	public $permalink;

	/**
	 * The layout used for the post in the archives page
	 *
	 * @var string
	 */
	public $layout = 'text-right';

	/**
	 * Main constructor function. If ID won't be provided we will try to find it, based on your query.
	 *
	 * @param object|int $post WP_Post or WP_Post.ID.
	 */
	public function __construct( $post = null ) {
		if ( is_integer( $post ) ) {
			$this->ID = $post;
			$this->init();
		} elseif ( is_a( $post, '\WP_Post' ) ) {
			$this->import( $post );
		}
	}

	/**
	 * Initialises Instance based on provided post id.
	 */
	protected function init() {
		$post = $this->get_object();

		if ( is_a( $post, '\WP_Post' ) ) {
			$this->import( $post );
		}
	}

	/**
	 * Returns post object.
	 *
	 * @return \WP_Post
	 */
	public function get_object() {
		return get_post( $this->ID );
	}

	/**
	 * Checks if current user can edit this post.
	 *
	 * @return boolean
	 */
	public function can_edit() {
		if ( ! function_exists( 'current_user_can' ) ) {
			return false;
		}
		if ( current_user_can( 'edit_post', $this->ID ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns post edit url.
	 *
	 * @return string
	 */
	public function get_edit_url() {
		if ( $this->can_edit() ) {
			return get_edit_post_link( $this->ID );
		}

		return '';
	}

	/**
	 * Returns array of attached image ids.
	 *
	 * @return false|array of ids
	 */
	public function get_attached_images() {
		$attrs = array(
			'post_parent' => $this->ID,
			'post_status' => null,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => 'ASC',
			'numberposts' => -1,
			'orderby' => 'menu_order',
			'fields' => 'ids',
		);

		$images = get_children( $attrs );

		if ( ! count( $images ) ) {
			return false;
		}

		return $images;
	}

	/**
	 * Returns array of attached images as Image objects.
	 *
	 * @return array of Image
	 */
	public function attached_images() {
		$_return = array();

		$images = $this->get_attached_images();

		if ( $images ) {

			foreach ( $images as $image_id ) {

				$_return[] = new Image( $image_id );

			}
		}

		return $_return;
	}


	/**
	 * Returns first attached image id.
	 *
	 * @return int|boolean
	 */
	public function get_first_attached_image_id() {
		$attrs = array(
			'post_parent' => $this->ID,
			'post_status' => null,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => 'ASC',
			'numberposts' => 1,
			'orderby' => 'menu_order',
			'fields' => 'ids',
		);

		$images = get_children( $attrs );

		if ( ! count( $images ) ) {
			return false;
		}

		$images = array_values( $images );

		return $images[0];
	}

	/**
	 * Returns first attached image.
	 *
	 * @return Image
	 */
	public function first_attached_image() {

		$image_id = $this->get_first_attached_image_id();

		if ( $image_id ) {
			return new Image( $image_id );
		}

		return new Image();
	}

	/**
	 * Has post thumbnail
	 *
	 * @return bool
	 */
	public function has_featured_image()
	{
		return has_post_thumbnail($this->ID);
	}

	/**
	 * Returns post thumbnail.
	 *
	 * @return Image
	 */
	public function thumbnail() {
		if ( function_exists( 'get_post_thumbnail_id' ) ) {
			$image_id = get_post_thumbnail_id( $this->ID );

			if ( $image_id ) {

				return new Image( $image_id );

			}
		}

		return new Image();
	}

	/**
	 * Returns post title with filters applied.
	 *
	 * @return string
	 */
	public function get_title() {
		return apply_filters( 'the_title', $this->post_title, $this->ID );
	}

	/**
	 * Alias for get_title.
	 *
	 * @return string
	 */
	public function title() {
		return $this->get_title();
	}

	/**
	 * Alias for get_title.
	 *
	 * @return string
	 */
	public function meta($key) {
		return get_post_meta($this->ID, $key, true);
	}

	/**
	 * Returns post date
	 *
	 * @return string
	 */
	public function get_date() {
		$date = new \DateTime($this->post_date);
		$date = date_format($date, 'M d');

		return $date;
	}

	/**
	 * Determine if date should be shown
	 *
	 * @return bool
	 */
	public function should_hide_date() {
		foreach($this->get_categories() as $category) {
			return $category->should_hide_date();
		}

		return true;
	}

	/**
	 * Returns the first/main category name for the post
	 *
	 * @return string
	 */
	public function get_category() {
		$categories = $this->get_categories();

		return array_shift($categories);
	}

	/**
	 * Returns all categories as custom Term class object
	 *
	 * @return array Term
	 */
	public function get_categories()
	{
		$categories = [];
		$postCategories = wp_get_post_categories($this->ID, ['fields' => 'all_with_object_id']);
		foreach($postCategories as $category)
		{
			// if any return true
			$categories[] = new Term($category);
		}

		return $categories;
	}

	/**
	 * Returns the list of tags
	 *
	 * @return array
	 */
	public function get_tags() {
		return wp_get_post_tags( $this->ID );
	}

	/**
	 * Returns the first/main category name for the post color
	 *
	 * @return string (hex)
	 */
	public function get_category_color() {
		$category = $this->get_category();

		if($color = $category->get_color())
			return $color;
		if($category->slug == 'fitness')
			return 'bg-stone';
		if($category->slug == 'fashion')
			return 'bg-rose';
		if($category->slug == 'feline')
			return 'bg-navy';

		return 'bg-stone';
	}

	/**
	 * Returns the template that belongs to the post
	 *
	 * @return string
	 */
	public function get_preview_template($layout = 'text-left') {
		$format = get_post_meta($this->ID, 'archive_layout', true);
		if($format == 'wide')
			return 'post.wide';

		if($layout == 'text-left')
			$this->layout = 'text-right';
		if($layout == 'text-right')
			$this->layout = 'text-left';

		return 'post.preview';
	}

	public function get_layout() {
		return $this->layout;
	}

	public function title_position() {
		$position = get_post_meta($this->ID, 'text_align', true);
		if(isset($position))
			return 'is-' . $position;

		return 'is-left';
	}

	public function background_position() {
		$position = get_post_meta($this->ID, 'background_position', true);
		return $position;
		if(! is_null($position))
			return $position;

		return 'center';
	}

	public function maybe_overlay() {
		$overlay = get_post_meta($this->ID, 'overlay', true);
		if($overlay)
			return 'overlay';

		return '';
	}

	/**
	 * Returns the post content with filters applied.
	 *
	 * @param integer $page Page number, in case our post has <!--nextpage--> tags.
	 *
	 * @return string Post content
	 */
	public function get_content( $page = 0 ) {
		if ( 0 === absint( $page ) && $this->post_content ) {
			return apply_filters( 'the_content', $this->post_content );
		}

		$content = $this->post_content;

		if ( $page ) {
			$contents = explode( '<!--nextpage-->', $content );

			$page--;

			if ( count( $contents ) > $page ) {
				$content = $contents[ $page ];
			}
		}

		$content = apply_filters( 'the_content', ($content) );

		return $content;
	}

	/**
	 * Alias for get_content.
	 *
	 * @return string
	 */
	public function content() {
		return $this->get_content();
	}

	/**
	 * Returns post type object for current post.
	 *
	 * @return object
	 */
	public function get_post_type() {
		return get_post_type_object( $this->post_type );
	}

	/**
	 * Returns post permalink.
	 *
	 * @return string
	 */
	public function get_permalink() {
		if ( isset( $this->permalink ) ) {
			return $this->permalink;
		}

		$this->permalink = get_permalink( $this->ID );

		return $this->permalink;
	}

	/**
	 * Alias for get_permalink
	 *
	 * @return string
	 */
	public function permalink() {
		return $this->get_permalink();
	}

	/**
	 * Returns post preview of requested length.
	 * It will look for post_excerpt and will return it.
	 * If post contains <!-- more --> tag it will return content until it
	 *
	 * @param  integer $len      Number of words.
	 * @param  boolean $force    If is set to true it will cut your post_excerpt to desired $len length.
	 * @param  string  $readmore The text for 'readmore' link.
	 * @param  boolean $strip    Should we strip tags.
	 *
	 * @return string            Post preview.
	 */
	public function get_preview( $len = 30, $force = false, $readmore = 'read', $strip = true) {
		$text = '';
		$trimmed = false;

		if ( isset( $this->post_excerpt ) && strlen( $this->post_excerpt ) ) {

			if ( $force ) {
				$text = Helper::trim_words( $this->post_excerpt, $len, false );
				$trimmed = true;
			} else {
				$text = $this->post_excerpt;
			}
		}

		if ( ! strlen( $text ) && preg_match( '/<!--\s?more(.*?)?-->/', $this->post_content, $readmore_matches ) ) {

			$pieces = explode( $readmore_matches[0], $this->post_content );
			$text = $pieces[0];

			if ( $force ) {
				$text = Helper::trim_words( $text, $len, false );
				$trimmed = true;
			}

			$text = do_shortcode( $text );
		}

		if ( ! strlen( $text ) ) {

			$text = Helper::trim_words( $this->get_content(), $len, false );
			$trimmed = true;

		}

		if ( ! strlen( trim( $text ) ) ) {

			return trim( $text );

		}

		if ( $strip ) {

			$text = trim( strip_tags( $text ) );

		}

		if ( strlen( $text ) ) {

			$text = trim( $text );
			$last = $text[ strlen( $text ) - 1 ];

			if ( '.' !== $last && $trimmed ) {
				$text .= '<br>';
			}

			if ( ! $strip ) {
				$last_p_tag = strrpos( $text, '</p>' );
				if ( false !== $last_p_tag ) {
					$text = substr( $text, 0, $last_p_tag );
				}
				if ( '.' !== $last && $trimmed ) {
					$text .= '<br>';
				}
			}

			if ( $readmore && isset( $readmore_matches ) && ! empty( $readmore_matches[1] ) ) {
				$text .= ' <a href="' . $this->get_permalink() . '" class="read-more">' . trim( $readmore_matches[1] ) . '</a>';
			} elseif ( $readmore ) {
				$text .= ' <a href="' . $this->get_permalink() . '" class="read-more">' . trim( $readmore ) . '</a>';
			}

			if ( ! $strip ) {
				$text .= '</p>';
			}
		}

		if(have_rows('preview_list', $this->ID)) {
			$items = get_field('preview_list', $this->ID);
			$items = array_column($items, 'item');
			$text = '<ul class="preview-list">';
			foreach($items as $item) {
				$text .= '<li>' . $item . '</li>';
			}
			$text .= '</ul>';

			$text .= ' <a href="' . $this->get_permalink() . '" class="read-more">' . trim( $readmore ) . '</a>';
		}

		return trim( $text );
	}

	/**
	 * Returns comments array
	 *
	 * @param string $status Comment status.
	 * @param string $order  Order for comments query.
	 *
	 * @return array
	 */
	public function get_comments( $status = 'approve', $order = 'DESC' ) {

		$_return = array();

		$args = array(
			'post_id' => $this->ID,
			'status' => $status,
			'order' => $order,
		);

		$comments = get_comments( $args );

		foreach ( $comments as $comment ) {

			$_return[ $comment->comment_ID ] = new Comment( $comment );

		}

		foreach ( $_return as $key => $comment ) {

			if ( $comment->has_parent() ) {

				$_return[ $comment->comment_parent ]->add_child( $comment );

				unset( $_return[ $key ] );

			}
		}

		return array_values( $_return );
	}
}
