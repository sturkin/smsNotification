<?php declare(strict_types=1);


namespace App\Adaptors\JsonHttp;

class JsonResponse
{
    private $code;
    private $headers;
    private $body;
    
    public function __construct(int $code, array $headers, string $body)
    {
        $this->code = $code;
        $this->headers = $headers;
        $this->body = json_decode($body);
    }
    
    public function header(string $key): string
    {
        return $this->headers[$key];
    }
    
    public function get(string $key)
    {
        return isset($this->body->$key) ? $this->body->$key : null;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    public function getCode(): int
    {
        return $this->code;
    }
    
}