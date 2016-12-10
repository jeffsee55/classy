<?php
/**
 * Media Manager Class.
 *
 * Manages Admin functions
 *
 * @package Classy
 */

namespace Classy;

/**
 * Class Admin
 */
class Media {
	/**
	 * Media constructor.
	 */
	public function __construct() {
        $this->registerMediaTaxonomy();
        add_action('wp_enqueue_media', [$this, 'addMediaScript']);
        add_filter('current_screen', [$this, 'setScreen']);
		add_filter('bulk_actions-upload', [$this, 'addBulkActions']);
		add_filter('handle_bulk_actions-upload', [$this, 'handleBulkActions'], 10, 3 );
		add_action( 'admin_notices', [$this, 'handleBulkActionNotice']);
    }

    public function setScreen($screen)
    {
        $this->screenID = $screen->id;
    }

    public function registerMediaTaxonomy()
    {
        $labels = array(
            'name'              => _x( 'Collection', 'classy' ),
            'singular_name'     => _x( 'Collection', 'classy' ),
            'search_items'      => __( 'Search Collections', 'classy' ),
            'all_items'         => __( 'Collections', 'classy' ),
            'parent_item'       => __( 'Parent Category', 'classy' ),
            'parent_item_colon' => __( 'Parent Category:', 'classy' ),
            'edit_item'         => __( 'Edit Collection', 'classy' ),
            'update_item'       => __( 'Update Collection', 'classy' ),
            'add_new_item'      => __( 'Add New Collection', 'classy' ),
            'new_item_name'     => __( 'New Collection Name', 'classy' ),
            'menu_name'         => __( 'Collection', 'classy' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'collection' ),
        );

        register_taxonomy(
            'collection',
            'attachment',
            $args
        );
        register_taxonomy_for_object_type( 'post_tag', 'attachment' );
    }

	public function addBulkActions($bulkActions)
	{
		$collections = get_terms( array(
            'taxonomy' => 'collection',
            'hide_empty' => false
        ) );

		foreach($collections as $collection)
		{
			$bulkActions[$collection->slug] = 'Place in ' . $collection->name;
		}

		return $bulkActions;
	}

	function handleBulkActions($redirect_to, $doaction, $post_ids) {
		foreach ( $post_ids as $post_id ) {
			// Perform action for each post.
			wp_set_object_terms($post_id, $doaction, 'collection', true);
		}
		$redirect_to = add_query_arg( 'bulk_added_to_collection', count( $post_ids ), $redirect_to );
		return $redirect_to;
	}

	function handleBulkActionNotice()
	{
		if ( ! empty( $_REQUEST['bulk_added_to_collection'] ) ) {
			$added_count = intval( $_REQUEST['bulk_added_to_collection'] );
			printf( '<div id="message" class="notice updated fade"><p>' .
			_n( 'Added %s posts to collection.',
			'Added %s posts to collection.',
			$added_count,
			'add_to_collection'
			) . '</p></div>', $added_count );
		}
	}

    public function addMediaScript()
    {
    	wp_enqueue_script( 'media-library-taxonomy-filter', get_stylesheet_directory_uri() . '/assets/js/media.js', array( 'media-editor', 'media-views' ) );
    	// Load 'terms' into a JavaScript variable that collection-filter.js has access to
    	wp_localize_script( 'media-library-taxonomy-filter', 'MediaLibraryTaxonomyFilterData', array(
    		'terms' => get_terms( array(
                'taxonomy' => 'collection',
                'hide_empty' => false
            ) ),
    	) );
    	// Overrides code styling to accommodate for a third dropdown filter
    	add_action( 'admin_footer', function(){
    		?>
    		<style>
    		.media-modal-content .media-frame select.attachment-filters {
    			max-width: -webkit-calc(33% - 12px);
    			max-width: calc(33% - 12px);
    		}
    		</style>
    		<?php
    	});
    }
}
