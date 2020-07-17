<?php declare(strict_types=1);


namespace App\Notification;


use App\Notification\Notifications\Builders\NotificationBuilder;
use App\Notification\Sender\Sender;

class NotificationService
{
    private $builder;
    private $sender;
    
    public function __construct(NotificationBuilder $builder, Sender $sender)
    {
        $this->builder = $builder;
        $this->sender = $sender;
    }
    
    public function sentTemperatureNotification(int $temp, string $phone)
    {
        $notification = null;
        if ($temp > 20) {
            $notification = $this->builder->getTempAbove20Notification($phone, (string)$temp);
        } else {
            $notification = $this->builder->getTempLess20Notification($phone, (string)$temp);
        }
        
        if (!$notification->isValid()) {
            throw new \Exception('Invalid notification');
        }
        
        $this->sender->send($notification);
    }
    
}