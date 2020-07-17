<?php declare(strict_types=1);


namespace App\Notification\Notifications\Builders;


use App\Notification\Notifications\Directions\SMSDirection;
use App\Notification\Notifications\TempAbove20Notification;
use App\Notification\Notifications\TempLess20Notification;

class NotificationBuilder
{
    
    public function getTempLess20Notification(string $phone, string $temp)
    {
        $notification = new TempLess20Notification($temp);
        $notification->addSendDirection(new SMSDirection($phone));
        
        return $notification;
    }
    
    public function getTempAbove20Notification(string $phone, string $temp)
    {
        $notification = new TempAbove20Notification($temp);
        $notification->addSendDirection(new SMSDirection($phone));
        
        return $notification;
    }
    
}