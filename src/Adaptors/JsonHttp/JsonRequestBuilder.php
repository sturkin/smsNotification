<?php declare(strict_types=1);


namespace App\Adaptors\JsonHttp;

use App\Adaptors\JsonHttp\Request\JsonAbstractRequest;
use App\Adaptors\JsonHttp\Request\JsonGetRequest;
use App\Adaptors\JsonHttp\Request\JsonPostRequest;

class JsonRequestBuilder
{
    public function get(string $url, array $headers): JsonResponse
    {
        $request = new JsonGetRequest($url);
        $this->putHeaders($request, $headers);
        
        
        return $request->execute();
    }
    
    public function post(string $url, string $data, array $headers): JsonResponse
    {
        $request = new JsonPostRequest($url, $data);
        $this->putHeaders($request, $headers);
        
        return $request->execute();
    }
    
    private function putHeaders(JsonAbstractRequest $request, array $headers)
    {
        if (!empty($headers)) {
            foreach ($headers as $key => $value) {
                $request->header($key, $value);
            }
        }
    }
    
}