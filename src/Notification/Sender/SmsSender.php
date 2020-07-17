<?php declare(strict_types=1);


namespace App\Notification\Sender;

interface SmsSender
{
    
    public function send(string $phone, string $text);
    
}