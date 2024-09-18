<?php

namespace TuyaApi;

class Requester {
    public static function sendRequest($config, $endpoint, $request, $token = null,  $payload = null) {
        $_timestamp = round(microtime(true) * 1000);
        $_request = strtoupper($request);
        $_token = ($token) ? $token : '';
        $_modified_result = self::_setPayload($_request, $payload, $endpoint);
        $_payload = $_modified_result['payload'];
        $_endpoint = $_modified_result['endpoint'];
        $_body = ($_payload && $_request != 'GET') ? json_encode($payload) : '';
        $_stringtosign = implode("\n", [$_request, hash('sha256' , $_body), '', $_endpoint]);
        $_sign = self::_sign($_timestamp, $config['client_id'], $config['client_secret'], $_token, $_stringtosign);
        $_headers = self::generateHeaders($_request, $_timestamp, $_sign, $config['client_id'], $_token);


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL , $config['base_url'] . $_endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $_headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $_request); 
        if ($_request == 'POST' || $_request == 'PUT') curl_setopt($curl, CURLOPT_POSTFIELDS, $_body);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $_response = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new \Exception('Request Error: ' . curl_error($curl));
        }
        curl_close($curl); // release curl resource
        $_return = json_decode($_response, false); // => php obj; json_decode($response, true) => dictionary
        echo 'sendRequest result: '; print_r($_return, true);

        return $_return;
    }

    protected static function _setPayload($request, $payload, $endpoint) {
        $result = ['payload' => '', 'endpoint' => $endpoint];
        if (!$payload) { return $result; }
        if ($request == 'POST' || $request == 'PUT') { 
            $result['payload'] = json_encode($payload);
        } else {
            ksort($payload);
            $payload = http_build_query($payload);
            $payload = str_replace("%2C", ",", $payload); // fix comma url encoding
            $endpoint = $endpoint . ((preg_match('#\?#', $endpoint)) ? '&' . $payload : '?' . $payload);	
            $result['payload'] = $payload;
            $result['endpoint'] = $payload;
        }
        return $result;
    }

    protected static function _sign($time, $key, $secret, $token, $stringToSign) {
        $sign = strtoupper(hash_hmac('sha256', $key . $token . $time . $stringToSign, $secret));
        return $sign;
    }

    protected static function generateHeaders($request, $time, $sign, $client_id, $token) {
        $headers = 
        [
            'Accept: application/json, text/plan, */*',
            't: ' . $time,
            'sign_method: HMAC-SHA256',
            'client_id: ' . $client_id,
            'sign: ' . $sign,
            // 'User-Agent: tuyapiphp', //unknown if required
            // 'Signature-Headers: ',
        ];
        if ($request == 'POST' || $request == 'PUT') {
            $headers[] = 'Content-Type: application/json';	
		}
        if ($token) {
            $headers[] = 'access_token: ' . $token;	
        }
        return $headers;
    }
}

?>