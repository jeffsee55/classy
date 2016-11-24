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
        add_action( 'add_meta_boxes',   [$this, 'registerMetaBoxes']);
        add_action( 'save_post',        [$this, 'saveMeta']);
    }

    /**
     * Register meta box(es).
     */
    public function registerMetaBoxes($post)
    {
        add_meta_box(
            'archive-layout',
            __( 'Archive Layout', 'heid-and-seek' ),
            [$this, 'renderArchiveLayoutMetaBox'],
            'post',
            'side'
        );
        add_meta_box(
            'title-position',
            __( 'Title Position', 'heid-and-seek' ),
            [$this, 'renderTitlePostionMetaBox'],
            'post',
            'side'
        );
        add_meta_box(
            'title-overlay',
            __( 'Title Overlay', 'heid-and-seek' ),
            [$this, 'renderTitleOverlayMetaBox'],
            'post',
            'side'
        );
    }

    /**
     * Render meta box fields
     */
    public function renderTitlePostionMetaBox()
    {
        global $post;
        $value = get_post_meta($post->ID, '_title_position', true);
        if($value)
            $currentValue = $value;
        ?>
        <fieldset>
			<legend class="screen-reader-text">Post Formats</legend>
			<input <?= $value == 'left' ? 'checked' : ''; ?> type="radio" name="_title_position" class="post-format" id="title-position-left" value="left">
            <label for="title-position-left" class="post-format-standard">Left</label>
			<br>
			<input <?= $value == 'center' ? 'checked' : ''; ?> type="radio" name="_title_position" class="post-format" id="title-position-center" value="center">
            <label for="title-position-center" class="post-format-standard">Center</label>
			<br>
			<input <?= $value == 'right' ? 'checked' : ''; ?> type="radio" name="_title_position" class="post-format" id="title-position-right" value="right">
            <label for="title-position-right" class="post-format-standard">Right</label>
		</fieldset>
        <?php
    }

    /**
     * Render meta box fields
     */
    public function renderArchiveLayoutMetaBox()
    {
        global $post;
        $value = get_post_meta($post->ID, '_archive_layout', true);
        if($value)
            $currentValue = $value;
        ?>
        <fieldset>
			<legend class="screen-reader-text">Post Formats</legend>
			<input <?= $value == 'wide' ? 'checked' : ''; ?> type="radio" name="_archive_layout" class="post-format" id="archive-layout-wide" value="wide">
            <label for="archive-layout-wide" class="post-format-standard">Wide</label>
			<br>
			<input <?= $value == 'standard' ? 'checked' : ''; ?> type="radio" name="_archive_layout" class="post-format" id="archive-layout-standard" value="standard">
            <label for="archive-layout-standard" class="post-format-standard">Standard</label>
		</fieldset>
        <?php
    }

    /**
     * Render meta box fields
     */
    public function renderTitleOverlayMetaBox()
    {
        global $post;
        $value = get_post_meta($post->ID, '_title_overlay', true);
        if($value)
            $currentValue = $value;

        ?>
        <fieldset>
			<legend class="screen-reader-text">Title Overlay</legend>
			<input <?= $value == 1 ? 'checked' : ''; ?> type="radio" name="_title_overlay" class="post-format" id="title-overlay-true" value="1">
            <label for="title-overlay-true" class="post-format-standard">True</label>
			<br>
			<input <?= $value == 0 ? 'checked' : ''; ?> type="radio" name="_title_overlay" class="post-format" id="title-overlay-false" value="0">
            <label for="title-overlay-false" class="post-format-standard">False</label>
		</fieldset>
        <?php
    }

    /**
     * Save meta box content.
     *
     * @param int $post_id Post ID
     */
    function saveMeta( $post_id ) {
        if(isset($_POST['_title_position']))
            update_post_meta($post_id, '_title_position', $_POST['_title_position']);

        if(isset($_POST['_archive_layout']))
            update_post_meta($post_id, '_archive_layout', $_POST['_archive_layout']);

        if(isset($_POST['_title_overlay']))
            update_post_meta($post_id, '_title_overlay', $_POST['_title_overlay']);
    }
}