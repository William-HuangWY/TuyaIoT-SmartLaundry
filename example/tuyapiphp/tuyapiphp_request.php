<?php

function getPlugDevices($deviceList) {
    $devices = [];
    if (isset($deviceList->result) && is_array($deviceList->result)) {
        foreach ($deviceList->result as $device) {
            $devices[$device->id] = [
                'Name' => $device->name,
                'Model' => $device->model,
                'Product Name' => $device->product_name,
                'Status' => $device->status
            ];
        }
    }

    return $devices;
}

require_once 'vendor/autoload.php'; 
$config =
[
	'accessKey' 	=> 'xxxxxxxxxxxxxxxxx' , // client_id
	'secretKey' 	=> 'xxxxxxxxxxxxxxxxx' , // clien_secret
	'baseUrl'		=> 'https://openapi.tuyaus.com'
];
$app_id = "xxxxxxxxxxxxxxxxx"; // UID

$tuya = new \tuyapiphp\TuyaApi( $config );
$data = $tuya->token->get_new();
$accessToken = $data->result->access_token;

$deviceList = $tuya->devices($accessToken)->get_app_list($app_id); // assume all devices are plugs
$plug_devices = getPlugDevices($deviceList);

foreach ($plug_devices as $deviceId => $info) {
    echo "Device ID: $deviceId\n";
    echo "Name: " . $info['Name'] . "\n";
    echo "Model: " . $info['Model'] . "\n";
    echo "Product Name: " . $info['Product Name'] . "\n";
    echo "Status:\n";
    foreach ($info['Status'] as $status) {
        echo "  " . $status->code . ": " . $status->value . "\n";
    }
    echo "\n";
}

?>