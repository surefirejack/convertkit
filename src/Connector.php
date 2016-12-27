<?php

namespace ConvertKit;

require_once(dirname(__FILE__) . "/exceptions/RequestException.php");

class Connector {


    public $api_url_base = 'https://api.convertkit.com';
    protected $api_version  = 3;
    public $api_key;
    public $api_secret_key;
    public $output = "json";
    public $base_url;

    function __construct($api_key, $api_secret_key) {
        $this->base_url = $this->api_url_base.'/v'.$this->api_version;
        $this->api_key = $api_key;
        $this->api_secret_key = $api_secret_key;
        $this->debug=false;
    }

    public function credentials_test() {
//        $test_url = "{$this->url}&api_action=user_me&api_output={$this->output}";
//        $r = $this->curl($test_url);
//        if (is_object($r) && (int)$r->result_code) {
//            // successful
//            $r = true;
//        } else {
//            // failed - log it
//            $this->curl_response_error = $r;
//            $r = false;
//        }
//        return $r;
    }

    // debug function (nicely outputs variables)
    public function dbg($var, $continue = 0, $element = "pre", $extra = "") {
//        echo "<" . $element . ">";
//        echo "Vartype: " . gettype($var) . "\n";
//        if ( is_array($var) ) echo "Elements: " . count($var) . "\n";
//        elseif ( is_string($var) ) echo "Length: " . strlen($var) . "\n";
//        if ($extra) {
//            echo $extra . "\n";
//        }
//        echo "\n";
//        print_r($var);
//        echo "</" . $element . ">";
//        if (!$continue) exit();
    }

    public function curl($url, $params_data = array(), $verb = "", $custom_method = "") {




        $debug_str1 = "";
        $request = curl_init();
        $debug_str1 .= "\$ch = curl_init();\n";
//        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        $debug_str1 .= "curl_setopt(\$ch, CURLOPT_HEADER, 0);\n";
        $debug_str1 .= "curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);\n";

        if ($params_data && $verb == "GET") {
            if ($this->version == 2) {
                $url .= "&" . $params_data;
                curl_setopt($request, CURLOPT_URL, $url);
            }
        }
        else {
            curl_setopt($request, CURLOPT_URL, $url);
            if ($params_data && !$verb) {
                // if no verb passed but there IS params data, it's likely POST.
                $verb = "POST";
            } elseif ($verb) {
                // $verb is likely "POST" or "PUT".
            } else {
                $verb = "GET";
            }
        }
        $debug_str1 .= "curl_setopt(\$ch, CURLOPT_URL, \"" . $url . "\");\n";
        if ($this->debug) {
            $this->dbg($url, 1, "pre", "Description: Request URL");
        }
        if ($verb == "POST" || $verb == "PUT" || $verb == "DELETE") {

            $params_data = json_encode($params_data);

            if ($verb == "PUT") {
                curl_setopt($request, CURLOPT_CUSTOMREQUEST, "PUT");
                $debug_str1 .= "curl_setopt(\$ch, CURLOPT_CUSTOMREQUEST, \"PUT\");\n";
            } elseif ($verb == "DELETE") {
                curl_setopt($request, CURLOPT_CUSTOMREQUEST, "DELETE");
                $debug_str1 .= "curl_setopt(\$ch, CURLOPT_CUSTOMREQUEST, \"DELETE\");\n";
            } else {
                $verb = "POST";
                curl_setopt($request, CURLOPT_POST, 1);
                $debug_str1 .= "curl_setopt(\$ch, CURLOPT_POST, 1);\n";

                curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            }



            $debug_str1 .= "curl_setopt(\$ch, CURLOPT_HTTPHEADER, array(\"Expect:\"));\n";
            if ($this->debug) {
                curl_setopt($request, CURLINFO_HEADER_OUT, 1);
                $debug_str1 .= "curl_setopt(\$ch, CURLINFO_HEADER_OUT, 1);\n";
                $this->dbg($data, 1, "pre", "Description: POST data");
            }
            curl_setopt($request, CURLOPT_POSTFIELDS, $params_data);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($params_data))
            );

            $debug_str1 .= "curl_setopt(\$ch, CURLOPT_POSTFIELDS, \"" . $params_data . "\");\n";
        }
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0);

        $debug_str1 .= "curl_setopt(\$ch, CURLOPT_SSL_VERIFYPEER, false);\n";
        $debug_str1 .= "curl_setopt(\$ch, CURLOPT_SSL_VERIFYHOST, 0);\n";
//    return $debug_str1;



        $response = curl_exec($request);
        $curl_error = curl_error($request);
        if (!$response && $curl_error) {
            return $curl_error;
        }
        $debug_str1 .= "curl_exec(\$ch);\n";
        if ($this->debug) {
            $this->dbg($response, 1, "pre", "Description: Raw response");
        }
        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
        if (!preg_match("/^[2-3][0-9]{2}/", $http_code)) {
            // If not 200 or 300 range HTTP code, return custom error.
            return "HTTP code $http_code returned";
        }
        $debug_str1 .= "\$http_code = curl_getinfo(\$ch, CURLINFO_HTTP_CODE);\n";
        if ($this->debug) {
            $this->dbg($http_code, 1, "pre", "Description: Response HTTP code");
            $request_headers = curl_getinfo($request, CURLINFO_HEADER_OUT);
            $debug_str1 .= "\$request_headers = curl_getinfo(\$ch, CURLINFO_HEADER_OUT);\n";
            $this->dbg($request_headers, 1, "pre", "Description: Request headers");
        }
        curl_close($request);
        $debug_str1 .= "curl_close(\$ch);\n";
        $object = json_decode($response);
        if ($this->debug) {
            $this->dbg($object, 1, "pre", "Description: Response object (json_decode)");
        }
        if ( !is_object($object)  ) {
            // add methods that only return a string
            $string_responses = array("tags_list", "segment_list", "tracking_event_remove", "contact_list", "form_html", "tracking_site_status", "tracking_event_status", "tracking_whitelist", "tracking_log", "tracking_site_list", "tracking_event_list");
            if (in_array($method, $string_responses)) {
                return $response;
            }

            $requestException = new RequestException;
            $requestException->setFailedMessage($response);
            throw $requestException;
        }

        if ($this->debug) {
            echo "<textarea style='height: 300px; width: 600px;'>" . $debug_str1 . "</textarea>";
        }

        return $object;
    }

}