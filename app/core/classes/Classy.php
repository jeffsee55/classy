<?php
/**
 * The core theme class.
 *
 * @since 	1.0.0
 * @package Classy
 * @author 	Andrew Tolochka <atolochka@gmail.com>
 */

namespace Classy;

use Windwalker\Renderer\BladeRenderer;
use Classy\Mailer;

/**
 * Class Classy.
 */
class Classy {

	/**
	 * Singleton instance of plugin
	 *
	 * @var Classy
	 * @since  0.1.0
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  0.1.0
	 * @return Classy A single instance of this class.
	 */
	public static function get_instance() {

		if ( null === self::$single_instance ) {

			self::$single_instance = new self();

		}

		return self::$single_instance;

	}

	/**
	 * Define the core functionality of the them.
	 *
	 * Set the theme name and the theme version that can be used throughout the theme.
	 *
	 * @since    1.0.0
	 */
	protected function __construct() {
		$this->define_constants();

		$this->init_appearance();

		$this->load_template_function();

		$this->init_config();

		$this->load_custom_includes();

		add_filter( 'theme_page_templates', array( $this, 'filter_templates' ) );

		add_action('init', [$this, 'init_admin']);

		add_action('wp_ajax_nopriv_classy_subscribe', [$this, 'processSubscriber']);
		add_action('wp_ajax_classy_subscribe', [$this, 'processSubscriber']);

		add_action('admin_post_classy_verify_subscriber', [$this, 'verifySubscriber']);
		add_action('admin_post_nopriv_classy_verify_subscriber', [$this, 'verifySubscriber']);

		add_action('admin_post_classy_notify_subscribers', [$this, 'notifySubscribers']);

		add_action('admin_post_classy_unsubscribe', [$this, 'unsubscribe']);
		add_action('admin_post_nopriv_classy_subscribe', [$this, 'unsubscribe']);

		add_action('phpmailer_init', [new Mailer, 'mailtrap']);

      add_filter( 'wp_mail_from_name', function() {
         return str_replace("&amp;", "&", get_bloginfo('name'));
		});

      add_filter( 'wp_mail_from', function() {
      	return 'info@' . 'heidandseek.com';
      } );
	}

	public function processSubscriber()
	{
		if(empty($_POST['subscriber_email']))
			wp_send_json_error(['success' => false, 'message' => 'Please provide an email address']);

		if(! filter_var($_POST['subscriber_email'], FILTER_VALIDATE_EMAIL))
			wp_send_json_error(['success' => false, 'message' => 'Email address is invalid']);

		if(email_exists($_POST['subscriber_email']))
			wp_send_json_error(['success' => false, 'message' => "Looks like you're already subscribed! Click <strong><a href=" . get_site_url() . ">here</a></strong> to send out an email verification"]);

		$userdata = array(
		    'user_login'  =>  $_POST['subscriber_email'],
			 'user_email' => $_POST['subscriber_email'],
		    'user_pass'   =>  hash('classy'),
			 'role' => 'subscriber'
		);

		$user_id = wp_insert_user( $userdata ) ;
		if(is_wp_error($user_id))
			wp_send_json_error(['success' => false, 'message' => 'There was a problem signign up.']);

		Mailer::sendVerification($_POST['subscriber_email']);
		wp_send_json_error(['success' => true, 'message' => 'Please check your email']);
	}

	public function verifySubscriber()
	{
		if(! isset($_GET['email']))
			wp_redirect(get_site_url() . '?message="subscriber_not_found"');

		$user = get_user_by('email', $_GET['email']);
		update_user_meta($user->ID, 'verified', true);
		wp_redirect(get_site_url() . '?message="subscriber_verified"');
		die();
	}

	public function unsubscribe()
	{
		if(! isset($_GET['email']))
			wp_redirect(get_site_url() . '?message="subscriber_not_found"');

		$user = get_user_by('email', $_GET['email']);
		wp_delete_user($user->ID);
		wp_redirect(get_site_url() . '?message="unsubscribed"');
		die();
	}

	public function notifySubscribers()
	{
		Mailer::sendNotification($_GET['post_id']);
	}

	/**
	 * Init Appearance class.
	 */
	private function init_appearance() {
		new Appearance();
		new Media();
	}

	/**
	 * Init Admin class.
	 */
	public function init_admin() {
		new Admin();
	}

	/**
	 * Load template functions.
	 */
	private function load_template_function() {
		require_once( CLASSY_THEME_FRAMEWORK_PATH . 'core/functions/template-functions.php' );
	}

	/**
	 * Loads custom files specified in custom/config.php.
	 */
	private function load_custom_includes() {
		$include = self::get_config_var( 'include' );

		if ( is_array( $include ) ) {
			foreach ( $include as $file ) {
				$files = (array) glob( CLASSY_THEME_FRAMEWORK_PATH . 'custom/' . $file );
				foreach ( $files as $filename ) {
					if ( is_readable( $filename ) ) {
						require_once $filename;
					}
				}
			}
		}
	}

	/**
	 * Defines plugin constants
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_constants() {

		$theme = wp_get_theme();

		define( 'CLASSY_THEME', $theme->template );
		define( 'CLASSY_THEME_NAME', $theme->get( 'Name' ) );
		define( 'CLASSY_THEME_PATH', get_template_directory() . '/' );
		define( 'CLASSY_THEME_DIR', get_template_directory_uri() . '/' );
		define( 'CLASSY_THEME_VERSION', $theme->get( 'Version' ) );
		define( 'CLASSY_THEME_FRAMEWORK_PATH', CLASSY_THEME_PATH . 'app/' );
		define( 'CLASSY_THEME_FRAMEWORK_DIR', CLASSY_THEME_DIR . 'app/' );

	}

	/**
	 * Init Theme Configuration
	 */
	private function init_config() {
		Config::init();
	}

	/**
	 * Filters registered templates and adds custom theme templates.
	 *
	 * @param array $page_templates Available WordPress templates.
	 *
	 * @return array
	 */
	public function filter_templates( $page_templates = array() ) {

		$custom_templates = View::get_page_templates_list();

		return array_merge( $page_templates, $custom_templates );

	}

	/**
	 * Returns theme config variable.
	 *
	 * @param string $name Variable's name.
	 *
	 * @return mixed|bool Return false if variable not found.
	 */
	public static function get_config_var( $name ) {

		$vars = Config::get_vars();

		return ( isset( $vars[ $name ] ) ) ? $vars[ $name ] : false;

	}

	/**
	 * Returns theme textdomain
	 *
	 * @return string
	 */
	public static function textdomain() {

		$textdomain = Classy::get_config_var( 'textdomain' );

		return $textdomain ? $textdomain : CLASSY_THEME;

	}

	/**
	 * Performs view render.
	 * If there is $view attribute presented, it will render requested view.
	 * If it's not it will try to find necessary view based on $wp_query
	 *
	 * @param  string|null $view View path in blade format, ex: single, layout.default, single.partials.slider and etc.
	 * @param  array|null  $data Additional params.
	 * @return void
	 */
	public static function render( $view = null, $data = null ) {

		$views = CLASSY_THEME_PATH . View::$folder;
		$cache = WP_CONTENT_DIR . '/viewcache';
		$common_scope = Scope::get_common_scope();

		if ( null !== $view && is_string( $view ) ) {

			if ( $data && is_array( $data ) ) {

				$scope = array_merge( $common_scope, $data );

			} else {

				$scope = $common_scope;

			}
		} else {

			$view = View::get_view();

			$scope = Scope::get_scope();

		}

		$renderer = new BladeRenderer( $views, array( 'cache_path' => $cache ) );

		$html = $renderer->render( $view, $scope );

		echo self::maybe_minify( $html );

	}

	/**
	 * Minifies html in case the minify_html option is set to true.
	 *
	 * @param  string $html HTML string.
	 * @return string
	 */
	private static function maybe_minify( $html ) {

		$minify_html = self::get_config_var( 'minify_html' );

		if ( true === $minify_html ) {

			$html = self::minify_html( $html );

		}

		return $html;

	}

	/**
	 * Returns minified version of string with removed whitespaces and empty strings.
	 *
	 * @param  string $html HTML string.
	 * @return string
	 */
	private static function minify_html( $html ) {

		$search = array(
			"/\n/s",
			'/\>[^\S ]+/s',  // Strip whitespaces after tags, except space.
			'/[^\S ]+\</s',  // Strip whitespaces before tags, except space.
			'/(\s)+/s',       // Shorten multiple whitespace sequences.
			'/<!--(.|\s)*?-->/',
		);

		$replace = array(
			'',
			'>',
			'<',
			'\\1',
			'',
		);

		return preg_replace( $search, $replace, $html );

	}

	/**
	 * Alias for Helper::get_archives_title()
	 * Returns page title for archive page.
	 * Example: Archives, Author: John Doe, Tag: Lorem Ipsum
	 *
	 * @return string
	 */
	public static function archives_title() {

		return Helper::get_archives_title();

	}

	/**
	 * Returns archive object.
	 *
	 * @param  mixed  $args 		Array of query args.
	 * @param  string $return_type 	Post/object/id.
	 *
	 * @return mixed
	 */
	public static function get_term() {

		$object = get_queried_object();

		return new \Classy\Models\Term($object);
	}

	/**
	 * Returns posts
	 *
	 * @param  mixed  $args   Array of query args.
	 * @param  string $return object/id/Post.
	 *
	 * @return array
	 */
	public static function get_posts( $args = false, $return = '\Classy\Models\Post' ) {

		$_return = array();

		$query = Query_Helper::find_query( $args );

		if ( isset( $query->posts ) ) {

			foreach ( $query->posts as $post ) {

				if ( 'id' === $return ) {

					$_return[] = $post->id;

				} elseif ( 'object' === $return ) {

					$_return[] = $post;

				} elseif ( class_exists( $return ) ) {

					$_return[] = new $return( $post );

				}
			}
		}

		return $_return;
	}


	/**
	 * Returns post.
	 *
	 * @param  mixed  $args 		Array of query args.
	 * @param  string $return_type 	Post/object/id.
	 *
	 * @return mixed
	 */
	public static function get_post( $args = false, $return_type = '\Classy\Models\Post' ) {

		$posts = self::get_posts( $args, $return_type );

		if ( $post = reset( $posts ) ) {
			return $post;
		}

	}

	/**
	 * @todo: Write description here.
	 *
	 * @param array $prefs Args for paginate_links.
	 *
	 * @return array mixed
	 */
	public static function get_pagination( $prefs = array() ) {

		global $wp_query;
		global $paged;
		global $wp_rewrite;

		$args = array();
		$args['total'] = ceil( $wp_query->found_posts / $wp_query->query_vars['posts_per_page'] );

		if ( $wp_rewrite->using_permalinks() ) {

			$url = explode( '?', get_pagenum_link( 0 ) );

			if ( isset( $url[1] ) ) {
				parse_str( $url[1], $query );
				$args['add_args'] = $query;
			}

			$args['format'] = 'page/%#%';
			$args['base'] = trailingslashit( $url[0] ).'%_%';

		} else {
			$big = 999999999;
			$args['base'] = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
		}

		$args['type'] = 'array';
		$args['current'] = max( 1, get_query_var( 'paged' ) );
		$args['mid_size'] = max( 9 - $args['current'], 3 );
		$args['prev_next'] = false;

		if ( is_int( $prefs ) ) {
			$args['mid_size'] = $prefs - 2;
		} else {
			$args = array_merge( $args, $prefs );
		}

		$data = array();
		$data['pages'] = Helper::paginate_links( $args );
		$next = get_next_posts_page_link( $args['total'] );

		if ( $next ) {
			$data['next'] = array( 'link' => untrailingslashit( $next ), 'class' => 'page-numbers next' );
		}

		$prev = previous_posts( false );

		if ( $prev ) {
			$data['prev'] = array( 'link' => untrailingslashit( $prev ), 'class' => 'page-numbers prev' );
		}

		if ( $paged < 2 ) {
			$data['prev'] = null;
		}

		return Helper::array_to_object( $data );

	}
}
