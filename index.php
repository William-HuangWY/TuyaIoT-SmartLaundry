<?php

require_once __DIR__ . '/src/TuyaApi/TuyaApiLite.php'; 
require_once __DIR__ . '/src/TuyaApi/Token.php';
require_once __DIR__ . '/src/TuyaApi/Requester.php';

$config = [
    'client_id' => 'xxxxxxxxxxxxxxxxx', // your_client_id
    'client_secret' => 'xxxxxxxxxxxxxxxxx', // your_client_secret
    'base_url' => 'https://openapi.tuyaus.com',
];

$tuya = new TuyaApi\TuyaApiLite($config['base_url'], $config['client_id'], $config['client_secret']);
$response = $tuya->getAccessToken();

echo 'New Token Response: ';
print_r($response);

echo "\n\n";

$currentToken = $tuya->getToken();
echo 'Current Token: ' . $currentToken . "\n";

?>