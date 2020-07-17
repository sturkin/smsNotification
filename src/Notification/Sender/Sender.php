<?php declare(strict_types=1);


namespace App\Notification\Sender;


use App\Notification\Notification\AbstractNotification;

class Sender
{
    private $smsSender;
    
    public function __construct(SmsSender $smsSender)
    {
        $this->smsSender = $smsSender;
    }
    
    public function send(Notification $notification)
    {
        
        foreach ($notification->getDirections() as $direction) {
            if ($direction->name() === 'SMS') {
                $info = $direction->info();
                
                if (!empty($info['phone'])) {
                    $this->smsSender->send($info['phone'], $notification->getText());
                }
            }
        }
    }
    
}