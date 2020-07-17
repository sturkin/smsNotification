<?php declare(strict_types=1);


namespace App\Adaptors\Weather;

use App\Weather\Temperature as ITemperature;

class Temperature implements ITemperature
{
    const KELVIN_CELSIUM_DIFF = 273.15;
    
    private $kelvinTemp;
    
    public function __construct($kelvinTemp)
    {
        $this->kelvinTemp = $kelvinTemp;
    }
    
    public function byCelsius(): int
    {
        return (int)round($this->kelvinTemp - static::KELVIN_CELSIUM_DIFF);
    }
    
}