<?php declare(strict_types=1);

namespace App\Notification\Notifications;

class TempLess20Notification extends AbstractNotification
{
    public function __construct(string $temp)
    {
        $this->setText(sprintf('Your name and Temperature less than 20C. %s', $temp));
    }
    
    
}