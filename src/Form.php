<?php


namespace ConvertKit;

class Form extends ConvertKit {

    public $url_base;
    public $api_key;
    public $api_secret_key;
    public $request_url;
    public $id;

    function __construct($url_base, $api_key, $api_secret_key) {
        $this->url_base = $url_base;
        $this->api_key = $api_key;
        $this->api_secret_key = $api_secret_key;
        $this->request_url = "{$this->url_base}/forms/";
    }

    public function showall() {
        $request_url = $this->request_url . '?api_secret='.$this->api_secret_key;
        $response = $this->curl($request_url);
        return $response;
    }

    public function setFormId($id) {
        $this->id = (int)$id;
    }


    public function listSubscriptions($id = null) {
        if( $id ) $this->setFormId($id);
        $request_url = $this->request_url . '/'.$this->id.'/subscriptions?api_secret='.$this->api_secret_key;
        $response = $this->curl($request_url);
        return $response;
    }
}