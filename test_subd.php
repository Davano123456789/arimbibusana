<?php
$apiKey = 'fadeBYzF84f4f7c5590b48feylEgmfTQ';
$baseUrl = 'https://rajaongkir.komerce.id/api/v1';

$options = [
    'http' => [
        'header' => "key: $apiKey\r\n",
        'ignore_errors' => true
    ]
];
$context = stream_context_create($options);

// Get subdistricts for a random city, actually let's see if we can find subdistrict by ID
// Wait, is there a way to get subdistrict details by ID? Komerce V1 subdistrict list requires ?city=ID
$res = file_get_contents("$baseUrl/destination/subdistrict?search=648", false, $context);
print_r(substr($res, 0, 500));
