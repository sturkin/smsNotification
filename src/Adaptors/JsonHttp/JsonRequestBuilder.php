<?php declare(strict_types=1);


namespace App\Adaptors\JsonHttp;

class JsonRequestBuilder
{
    public function get(string $url, array $headers): JsonResponse {
        $request = new JsonGetRequest($url);
        if (!empty($headers)) {
            foreach ($headers as $key => $value) {
                $request->header($key, $value);
            }
        }
        
        return $request->execute();
    }
    
}