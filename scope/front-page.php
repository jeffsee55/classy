<?php
/**
 * Data that will be accessible on front page.
 */
$framework = get_theme_framework();

$categories = [
	'fashion',
	'food',
	'fitness',
	'feline'
];

$category_ids = array_map(function($slug) {
	return get_term_by('slug', $slug, 'category', OBJECT)->term_id;
}, $categories);

$data = [
	'post' => $framework::get_post(),
	'posts' => $framework::get_posts([
        'post_type' => 'post',
        'post_count' => get_option('posts_per_page'),
		'category__in' => $category_ids
    ]),
	'page_title' => $framework::archives_title(),
	'pagination' => $framework::get_pagination(),
];
