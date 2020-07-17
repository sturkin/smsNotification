<?php declare(strict_types=1);

namespace App\Weather;

interface WeatherProvider
{
    
    public function getTemperatureByCity(string $city): Temperature;
    
}
