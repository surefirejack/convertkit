<?php

namespace ConvertKit;

class Webhook extends ConvertKit {

    public $url_base;
    public $api_key;
    public $api_secret_key;
    public $request_url;
    public $response;

    function __construct($url_base, $api_key, $api_secret_key) {
        $this->url_base = $url_base;
        $this->api_key = $api_key;
        $this->api_secret_key = $api_secret_key;
        $this->request_url = "{$this->url_base}/automations/hooks?api_key=".$this->api_key;
    }

    function add($post_data) {
//        return print_r($post_data, true);
        $payload = array_merge(array('api_secret' => $this->api_secret_key), $post_data);
        $this->response = $this->curl($this->request_url, $payload);
        return $this->response;
    }
}