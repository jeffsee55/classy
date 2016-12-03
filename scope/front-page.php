<?php
/**
 * Data that will be accessible on front page.
 */
$framework = get_theme_framework();
$data = array(
	'post' => $framework::get_post(),
	'posts' => $framework::get_posts([
        'post_type' => 'post',
        'post_count' => get_option('posts_per_page')
    ]),
	'page_title' => $framework::archives_title(),
	'pagination' => $framework::get_pagination(),
);
