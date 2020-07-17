<?php declare(strict_types=1);


namespace App\Weather;

class WeatherService
{
    private $whether;
    
    public function __construct(WeatherProvider $whether)
    {
        $this->whether = $whether;
    }
    
    public function getTemperatureByCity(string $city): int
    {
        
        /** @var Temperature $temp */
        $temp = $this->whether->getTemperatureByCity($city);
        
        return $temp->byCelsius();
    }
    
}