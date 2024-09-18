<?php

require_once __DIR__ . '/src/TuyaApi/TuyaApiLite.php'; 
require_once __DIR__ . '/src/TuyaApi/Token.php';
require_once __DIR__ . '/src/TuyaApi/Requester.php';

$config = [
    'client_id' => 'xxxxxxxxxxxxxxxxx', // your_client_id
    'client_secret' => 'xxxxxxxxxxxxxxxxx', // your_client_secret
    'base_url' => 'https://openapi.tuyaus.com',
];

$token = new TuyaApi\Token($config);
$response = $token->getNewToken();

echo 'New Token Response: ';
print_r($response);

echo "\n\n";

$currentToken = $token->getToken();
echo 'Current Token: ' . $currentToken . "\n";

?>