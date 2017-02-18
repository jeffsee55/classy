<?php

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://api.instagram.com/v1/users/',
]);

$instagram_id = '44674676';
$instagram_key = '44674676.78cabfa.1f3a72731c0e4200a54813cdcbe50467';

try {
    $response = $client->request('GET', $instagram_id . '/media/recent/?count=6&access_token=' . $instagram_key);
    
    $body = $response->getBody();
    $stringBody = (string) $body;
    $feed = json_decode($stringBody)->data;

    $feed = array_map(function($item) {
        return $item->images->low_resolution->url;
    }, $feed);
} catch (GuzzleHttp\Exception\ConnectException $e) {
}


$framework = get_theme_framework();
$data = array(
	'post' => $framework::get_post(),
	'instagram' => $feed
);
