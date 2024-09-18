<?php

namespace TuyaApi;

class TuyaApiLite {
    protected $config;
    protected $token;

    public function __construct($base_url, $client_id, $client_secret) {
        $this->config = [
            'base_url' => $base_url,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ];
        $this->token = new Token($this->config);;
    }

    public function getAccessToken() {
        return $this->token->getNewToken();
    }

    // public function refreshAccessToken($refresh_token) {
    //     return $this->token->refreshToken($refresh_token);
    // }

    public function getToken() {
        return $this->token->getToken();
    }
}

?>