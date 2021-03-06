<?php
/**
 * Data that will be accessible on archive page (index).
 */
$framework = get_theme_framework();
$data = array(
    'term' => $framework::get_term(),
	'posts' => $framework::get_posts(),
	'page_title' => $framework::archives_title(),
	'pagination' => $framework::get_pagination(),
);
