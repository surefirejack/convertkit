<?php

namespace ConvertKit;

class Subscriber extends ConvertKit {

    public $url_base;
    public $api_key;
    public $api_secret_key;
    public $request_url;
    public $id;

    function __construct($url_base, $api_key, $api_secret_key) {
        $this->url_base = $url_base;
        $this->api_key = $api_key;
        $this->api_secret_key = $api_secret_key;
        $this->request_url = "{$this->url_base}/subscribers/";
    }

    public function showall() {
        $request_url = $this->request_url . '?api_secret='.$this->api_secret_key;
        $response = $this->curl($request_url);
        return $response;
    }

    public function view($id) {
        if( $id ) $this->setSubscriberId($id);
        $request_url = $this->request_url . '/'.$this->id.'?api_secret='.$this->api_secret_key;
        $response = $this->curl($request_url);
        return $response;
    }

    public function setSubscriberId($id) {
        $this->id = (int)$id;
    }



    public function addToCourse($courseId, $subscriberData) {
        $request_url = "{$this->url_base}/courses/".$courseId.'/subscribe';

        $payload = array_merge(array('api_key' => $this->api_key), $subscriberData);

        $response = $this->curl($request_url, $payload, 'POST');
        return $response;
    }

    public function addToForm($formId, $subscriberData) {
        $request_url = "{$this->url_base}/forms/".$formId.'/subscribe';

        $payload = array_merge(array('api_key' => $this->api_key), $subscriberData);

        $response = $this->curl($request_url, $payload, 'POST');
        return $response;
    }

    public function removeTag($subscriberId, $tagId) {
        if( ! $tagId ) return false;
        if( ! $subscriberId ) return false;

        $request_url = $this->request_url .$subscriberId.'/tags/'.$tagId.'?api_secret='.$this->api_secret_key;

        $response = $this->curl($request_url, null, 'DELETE');
        return $response;
    }
}