<?php

namespace TuyaApi;

class Token {
    protected $_config;
    protected $_token = '';

    public function __construct($config) {
        $this->_config = $config;
    }

    public function getNewToken() {
        $endpoint = $this->_endpoints['new_token'];
        $response = Requester::sendRequest($this->_config, $endpoint, "GET", $this->_token);
        if (isset($response->result->access_token)) {
            $this->_token = $response->result->access_token;
        }
        return $response;
    }

    // public function refreshToken($refresh_token) {
    //     $endpoint = '/v1.0/token/' . $refresh_token;
    //     return Requester::sendRequest($this->_config, $endpoint, "GET");
    // }

    public function getToken() {
        return $this->_token;
    }

    protected $_endpoints = 
    [
        'new_token'		=> '/v1.0/token?grant_type=1' ,
        'refresh_token'	=> '/v1.0/token/',
    ];
}

?>