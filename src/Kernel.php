<?php declare(strict_types=1);

namespace App;

use App\Adaptors\JsonHttp\JsonRequestBuilder;
use App\Adaptors\SMS\Routee;
use App\Adaptors\Weather\Openweathermap;
use App\Exceptions\FatalErrorException;
use App\Notification\Notifications\Builders\NotificationBuilder;
use App\Notification\NotificationService;
use App\Notification\Sender\Sender;
use App\Weather\WeatherService;

//don't see a point to spend time to implement whole DI container, for will use bootstrap class as service locator
class Kernel
{
    private $config = [];
    private $configPath;
    private $services = [];
    
    public function __construct(string $configPath)
    {
        if (!file_exists($configPath)) {
            throw new FatalErrorException('Invalid Config Path');
        }
        
        $this->configPath = $configPath;
    }
    
    public function getService(string $name)
    {
        if (!empty($this->services[$name])) {
            return $this->services[$name];
        }
        
        if ($name === WeatherService::class) {
            $this->services[$name] = new WeatherService($this->buildWeatherAdaptor());
            
        } elseif (NotificationService::class) {
            $this->services[$name] = new NotificationService(
                new NotificationBuilder(),
                new Sender($this->buildSMSAdaptor())
            );
            
        } else {
            throw new FatalErrorException('Invalid service name');
        }
        
        
        return $this->services[$name];
    }
    
    private function getConfig($key)
    {
        if (!isset($this->config[$key])) {
            $this->config[$key] = include $this->configPath . '/' . "$key.php";
        }
        
        return $this->config[$key];
    }
    
    private function buildWeatherAdaptor()
    {
        $config = $this->getConfig('weather');
        $driver = $config['defaultDriver'];
        
        $adaptor = null;
        if ($driver === 'openweathermap') {
            $adaptor = new Openweathermap($config['drivers']['openweathermap']['apikey'], new JsonRequestBuilder());
        }
        
        if (empty($adaptor)) {
            throw new FatalErrorException('Cant build weather adaptor');
        }
        
        return $adaptor;
    }
    
    private function buildSMSAdaptor()
    {
        $config = $this->getConfig('sms');
        $driver = $config['defaultDriver'];
        
        $adaptor = null;
        if ($driver === 'routee') {
            $adaptor = new Routee(
                $config['drivers']['routee']['apikey'],
                $config['drivers']['routee']['secret'],
                new JsonRequestBuilder()
            );
        }
        
        if (empty($adaptor)) {
            throw new FatalErrorException('Cant build sms adaptor');
        }
        
        return $adaptor;
    }
    
}