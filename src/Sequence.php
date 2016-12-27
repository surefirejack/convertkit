<?php

namespace ConvertKit;


class Sequence extends ConvertKit {

    public $url_base;
    public $api_key;
    public $api_secret_key;
    public $request_url;
    public $id;

    function __construct($url_base, $api_key, $api_secret_key) {
        $this->url_base = $url_base;
        $this->api_key = $api_key;
        $this->api_secret_key = $api_secret_key;
        $this->request_url = "{$this->url_base}/sequences";
    }


    public function setSequenceId($id) {
        $this->id = (int)$id;
    }

    function showall() {
        $request_url = $this->request_url . '?api_key='.$this->api_key;
        $response = $this->curl($request_url);
        return $response;
    }

    public function listSubscriptions($id = null) {
        if( $id ) $this->setSequenceId($id);
        $request_url = $this->request_url . '/'.$this->id.'/subscriptions?api_secret='.$this->api_secret_key;
        $response = $this->curl($request_url);
        return $response;
    }
}