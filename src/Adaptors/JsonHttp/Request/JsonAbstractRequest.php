<?php declare(strict_types=1);


namespace App\Adaptors\JsonHttp\Request;


use App\Adaptors\JsonHttp\JsonResponse;

abstract class JsonAbstractRequest
{
    
    private $headers = [];
    private $url;
    private $ch;
    
    private $headerSize;
    private $result;
    
    public function __construct(string $url)
    {
        $this->url = $url;
        
    }
    
    public function header(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        
        return $this;
    }
    
    public function execute(): JsonResponse
    {
        
        $this->init();
        $this->makeRequest();
        $response = $this->makeResponse();
        $this->close();
        
        return $response;
    }
    
    abstract protected function afterInit();
    
    protected function getCh()
    {
        return $this->ch;
    }
    
    
    private function init()
    {
        $this->ch = curl_init();
        
        $options = array(
            CURLOPT_HEADER => 1,
            CURLOPT_URL => $this->url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
        );
        curl_setopt_array($this->ch, $options);
        
        $headers = [];
        foreach ($this->headers as $key => $value) {
            $headers[] = "$key: $value";
        }
        
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        
        $this->afterInit();
    }
    
    private function makeRequest()
    {
        if (!$this->result = curl_exec($this->ch)) {
            throw new \Exception(curl_error($this->ch));
        }
        $this->headerSize = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
    }
    
    private function makeResponse(): JsonResponse
    {
        $headers = $this->parseHeadersString();
        
        $code = $headers['http_code'];
        unset($headers['http_code']);
        
        $body = $this->parseBody();
        
        return new JsonResponse((int)$code, $headers, $body);
    }
    
    private function parseHeadersString(): array
    {
        $headerStr = substr($this->result, 0, $this->headerSize);
        $headers = array();
        
        foreach (explode("\r\n", $headerStr) as $i => $line)
            if ($i === 0) {
                list($protocol, $code, $title) = explode(' ', $line);
                $headers['http_code'] = $code;
                
            } else {
                list ($key, $value) = explode(': ', $line);
                if (!empty($key)) {
                    $headers[$key] = $value;
                }
            }
        
        return $headers;
    }
    
    private function parseBody(): string
    {
        return substr($this->result, $this->headerSize);
    }
    
    
    private function close()
    {
        curl_close($this->ch);
    }
    
    
}