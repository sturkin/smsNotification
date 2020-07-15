<?php


namespace App\Notification;


use App\Notification\Notification\AbstractNotification;

class NotificationService
{
    private $builder;
    
    public function __construct(NotificationBuilder $builder)
    {
        $this->builder = $builder;
    }
    
    public function sentTemperatureNotification(int $temp, string $phone) {
        $notification = null;
        if ($temp > 20) {
            $notification = $this->builder->getTempAbove20Notification();
        } else {
            $notification = $this->builder->getTempLess20Notification();
        }
        
    }
    
    protected function sendNotification(AbstractNotification $notification) {
    
    }
    
}