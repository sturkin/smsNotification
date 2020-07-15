<?php


namespace App\Notification;


use App\Notification\Notification\TempAbove20Notification;
use App\Notification\Notification\TempLess20Notification;

class NotificationBuilder
{
    
    public function getTempLess20Notification(string $phone, string $temp) {
        return new TempLess20Notification($phone, $temp);
    }
    
    public function getTempAbove20Notification(string $phone, string $temp) {
        return new TempAbove20Notification($phone, $temp);
    }
    
}