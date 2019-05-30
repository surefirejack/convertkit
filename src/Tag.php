<?php

namespace ConvertKit;

class Tag extends ConvertKit {

    public $url_base;
    public $api_key;
    public $api_secret_key;
    public $request_url;
    public $id;

    function __construct($url_base, $api_key, $api_secret_key) {
        $this->url_base = $url_base;
        $this->api_key = $api_key;
        $this->api_secret_key = $api_secret_key;
        $this->request_url = "{$this->url_base}/tags";
    }


    public function setTagId($id) {
        $this->id = (int)$id;
    }

    function showall() {
        $request_url = $this->request_url . '?api_key='.$this->api_key;
        $response = $this->curl($request_url);
        return $response;
    }

    public function addToSubscriber($subscriberData, $id = null) {
        if( $id ) $this->setTagId($id);
        $request_url = $this->request_url . '/'.$this->id.'/subscribe';

        $payload = array_merge(array('api_key' => $this->api_key), $subscriberData);

        $response = $this->curl($request_url, $payload, 'POST');
        return $response;
    }

    public function deleteFromSubscriber($subscriberId = null) {
        if( ! $subscriberId ) return false;
        if( ! $this->id ) return false;

        $subscriber = new Subscriber($this->url_base, $this->api_key, $this->api_secret_key);
        $subscriber->removeTag($subscriberId, $this->id);
        return $subscriber;
    }

    public function listSubscriptions($id = null) {
        if( $id ) $this->setTagId($id);
        $request_url = $this->request_url . '/'.$this->id.'/subscriptions?api_secret='.$this->api_secret_key;
        $response = $this->curl($request_url);
        return $response;
    }


    public function add($post_data) {
        $payload = array_merge(array('api_secret' => $this->api_secret_key), $post_data);
        $this->response = $this->curl($this->request_url, $payload);
        return $this->response;
    }

    
}