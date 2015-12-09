<?php

class EvoApi{

    private $restURL;
    private $sessionId;

    public function __construct(){
        $this->restURL = "https://apitest.evolutionpayroll.com";
        $url = $this->restURL."/identity/v1/token/bureau/paydaytest";

        $response = $this->loginHttpCall($url, true);
        $obj = json_decode($response);
        $this->sessionId = $obj->access_token;
    }

    public function logOut(){

    }

    public function GET($resourceURL = ""){
        $url = $this->restURL . "/v1/api/bureau/paydaytest".$resourceURL;
        $curl = curl_init($url);
        $headers = array('Accept: application/json',
                         'Accept-Encoding: gzip, deflate, sdch',
                         'Accept-Language: en-US,en;q=0.8',
                         'TimeZone: America/Denver',
                         'Authorization: Bearer '. $this->sessionId,
                         'Connection: keep-alive',
                         'Host: apitest.evolutionpayroll.com');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5000);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);

        $response = curl_exec($curl);
        $errMsg = curl_error($curl);
        $errCode = curl_errno($curl);
        curl_close($curl);

        if($errMsg){
            throw new Exception('REST API error: '.$errMsg . ' Code: ' . $errCode);
        }

        return $response;

    }

    public function create(){

    }

    public function update(){

    }

    public function delete(){

    }

    private function loginHttpCall($url,$post=false){
        $curl = curl_init($url);
        $headers = array('Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '. base64_encode("paydayinc:payday_123"),
            'Host: apitest.evolutionpayroll.com',
            'Content-Length: 57');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5000);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);

        if($post){
            curl_setopt($curl, CURLOPT_POST, true);
            $body = "grant_type=password&username=gateway&password=bluehinge1#";
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($curl);
        $errMsg = curl_error($curl);
        $errCode = curl_errno($curl);
        curl_close($curl);

        if($errMsg){
            throw new Exception('REST API error: '.$errMsg . ' Code: ' . $errCode);
        }

        return $response;

    }


    private function httpCall($url, $post=false){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5000);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        if($post){
            curl_setopt($curl, CURLOPT_POST, true);
        }

        $response = curl_exec($curl);
        $errMsg = curl_error($curl);
        $errCode = curl_errno($curl);
        curl_close($curl);

        if($errMsg){
            throw new Exception('REST API error: '.$errMsg . ' Code: ' . $errCode);
        }

        return $response;

    }




}




?>