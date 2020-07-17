<?php declare(strict_types=1);

namespace App\Adaptors\Weather;

use App\Adaptors\JsonHttp\JsonRequestBuilder;
use App\Weather\WeatherProvider;
use App\Weather\Temperature as ITemperature;
use PHPUnit\Util\Exception;

class Openweathermap implements WeatherProvider
{
    private $apiKey;
    private $requestBuilder;
    
    private $baseUrl = 'api.openweathermap.org/data/2.5/weather';
    private $baseParams = [];
    
    public function __construct(string $apiKey, JsonRequestBuilder $requestBuilder)
    {
        $this->apiKey = $apiKey;
        $this->requestBuilder = $requestBuilder;
        
        $this->initBaseParams();
    }
    
    //returns temp in celsius
    public function getTemperatureByCity(string $city): ITemperature
    {
        $url = $this->buildUrl(['q' => $city]);
        $cityWeather = $this->requestBuilder->get($url, []);
        
        if (empty($cityWeather->get('main')) || !$cityWeather->get('main')->temp) {
            //good place to put logger
            throw new Exception('Invalid openweathermap response');
        }
        
        return new Temperature($cityWeather->get('main')->temp);
    }
    
    private function initBaseParams(): void
    {
        $this->baseParams['appid'] = $this->apiKey;
    }
    
    private function buildUrl($params): string
    {
        $finalPrams = array_merge($this->baseParams, $params);
        
        return $this->baseUrl . '?' . http_build_query($finalPrams);
    }
    
}