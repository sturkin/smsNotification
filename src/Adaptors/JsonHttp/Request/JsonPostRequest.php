<?php declare(strict_types=1);


namespace App\Adaptors\JsonHttp\Request;


use App\Adaptors\JsonHttp\JsonResponse;
use PHPUnit\Util\Exception;

class JsonPostRequest extends JsonAbstractRequest
{
    private $postData = '';
    
    public function __construct(string $url, string $postData)
    {
        parent::__construct($url);
        
        $this->postData = $postData;
    }
    
    protected function afterInit()
    {
        curl_setopt($this->getCh(), CURLOPT_POST, 1);
        curl_setopt($this->getCh(), CURLOPT_POSTFIELDS, $this->postData);
    }
    
}