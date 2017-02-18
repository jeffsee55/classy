<?php
/**
 * Data that will be accessible on front page.
 */
$framework = get_theme_framework();
$post = $framework::get_post();

$category_ids = get_field('categories', $post->ID);

$data = [
	'post' => $post,
	'posts' => $framework::get_posts([
        'post_type' => 'post',
        'post_count' => get_option('posts_per_page'),
		'category__in' => $category_ids
    ]),
	'page_title' => $framework::archives_title(),
	'pagination' => $framework::get_pagination(),
];
