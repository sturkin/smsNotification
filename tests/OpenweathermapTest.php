<?php

use PHPUnit\Framework\TestCase;

class OpenweathermapTest extends TestCase
{
    
    public function testGetTemperatureByCity()
    {
        $city = 'Thessaloniki';
        $apiKey = 'asdasdasda3s';
        $returnTemp = 273.15 + 20;
        $mockJsonRequestBuilder = $this->createMock(\App\Adaptors\JsonHttp\JsonRequestBuilder::class);
        
        $mockJsonRequestBuilder->expects($this->any())
            ->method('get')
            ->with(
                $this->callback(function ($url) use ($apiKey, $city) {
                    $urlParts = parse_url($url);
                    $queryParams = [];
                    parse_str($urlParts['query'], $queryParams);
                    
                    return $queryParams['appid'] === $apiKey && $queryParams['q'] === $city;
                }),
                $this->isEmpty()
            )
            ->will(
                $this->returnCallback(
                    function () use ($returnTemp) {
                        return new \App\Adaptors\JsonHttp\JsonResponse(
                            200,
                            [],
                            json_encode((object)[
                                'main' => (object)[
                                    'temp' => $returnTemp,
                                ]
                            ])
                        );
                    }
                )
            );
        
        $openweathermap = new \App\Adaptors\Weather\Openweathermap($apiKey, $mockJsonRequestBuilder);
        $temp = $openweathermap->getTemperatureByCity($city);
        
        $this->assertSame(20, $temp->byCelsius());
    }
    
    
}