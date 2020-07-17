<?php


use App\Weather\WeatherProvider;
use PHPUnit\Framework\TestCase;

class WeatherServiceTest extends TestCase
{
    
    public function testGetTemperatureByCity()
    {
        $city = 'Thessaloniki';
        $temp = 20;
        $returnTemp = 273.15 + $temp;
        $mockWeatherProvider = $this->createMock(WeatherProvider::class);
        
        $mockWeatherProvider->expects($this->any())
            ->method('getTemperatureByCity')
            ->will(
                $this->returnCallback(
                    function () use ($returnTemp) {
                        return new \App\Adaptors\Weather\Temperature($returnTemp);
                    }
                )
            );
        
        $weatherService = new \App\Weather\WeatherService($mockWeatherProvider);
        $temp = $weatherService->getTemperatureByCity($city);
        
        $this->assertSame(20, $temp);
    }
    
}