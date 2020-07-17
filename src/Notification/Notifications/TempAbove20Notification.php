<?php declare(strict_types=1);

namespace App\Notification\Notifications;

class TempAbove20Notification extends AbstractNotification
{
    public function __construct(string $temp)
    {
        $this->setText(sprintf('Your name and Temperature more than 20C. %s', $temp));
    }
    
}