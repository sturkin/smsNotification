<?php declare(strict_types=1);

namespace App\Adaptors\SMS;

use App\Adaptors\JsonHttp\JsonRequestBuilder;
use App\Notification\Sender\SmsSender;

class Routee implements SmsSender
{
    private $requestBuilder;
    
    private $apikey;
    private $secret;
    
    private $token;
    private $expire;
    
    private $baseUrl = 'https://connect.routee.net/sms';
    private $authUrl = 'https://auth.routee.net/oauth/token';
    
    public function __construct(string $apikey, string $secret, JsonRequestBuilder $builder)
    {
        $this->requestBuilder = $builder;
        $this->apikey = $apikey;
        $this->secret = $secret;
    }
    
    public function send(string $phone, string $text)
    {
        $url = $this->baseUrl;
        $postData = json_encode([
            'body' => $text,
            'to' => $phone
        ]);
        $headers = [
            'authorization' => 'Bearer ' . $this->getToken(),
            'content-type' => 'application/json'
        ];
        
        $response = $this->requestBuilder->post($url, $postData, $headers);
        if ($response->getCode() !== 200) {
            $code = $response->getCode();
            throw new \Exception('Send sms error, code ' . $code, $code);
        }
    }
    
    private function getToken()
    {
        if ($this->token && $this->expire < time()) {
            return $this->token;
        }
        
        $url = $this->authUrl;
        $postData = 'grant_type=client_credentials';
        $headers = [
            'authorization' => 'Basic ' . base64_encode($this->apikey . ':' . $this->secret),
            'content-type' => 'application/x-www-form-urlencoded'
        ];
        $response = $this->requestBuilder->post($url, $postData, $headers);
        
        if ($response->getCode() !== 200) {
            $code = $response->getCode();
            throw new \Exception('Auth error, code ' . $code, $code);
        }
        
        $this->token = $response->get('access_token');
        $this->expire = time() + $response->get('expires_in') - 10;
        
        return $this->token;
    }
    
}