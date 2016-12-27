<?php

namespace ConvertKit;


class CustomField extends ConvertKit {

    public $url_base;
    public $api_key;
    public $api_secret_key;
    public $request_url;
    public $id;

    function __construct($url_base, $api_key, $api_secret_key) {
        $this->url_base = $url_base;
        $this->api_key = $api_key;
        $this->api_secret_key = $api_secret_key;
        $this->request_url = "{$this->url_base}/custom_fields";
    }


    public function setCustomFieldId($id) {
        $this->id = (int)$id;
    }

    public function showall() {
        $request_url = $this->request_url . '?api_key='.$this->api_key;
        $response = $this->curl($request_url);
        return $response;
    }

    public function add($post_data) {
        $payload = array_merge(array('api_secret' => $this->api_secret_key), $post_data);
        $this->response = $this->curl($this->request_url, $payload);
        return $this->response;
    }

    public function edit($id = null, $post_data) {
        if( $id ) $this->setCustomFieldId($id);
        $payload = array_merge(array('api_secret' => $this->api_secret_key), $post_data);
        $this->response = $this->curl($this->request_url . '/'.$this->id, $payload, 'PUT');
        return $this->response;
    }

    public function delete($id = null) {
        if( $id ) $this->setCustomFieldId($id);
        $payload = array('api_secret' => $this->api_secret_key);
        $this->response = $this->curl($this->request_url . '/'.$this->id, $payload, 'DELETE');
        return $this->response;
    }

}