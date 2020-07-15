<?php

namespace App\Notification\Notification;

class TempAbove20Notification extends AbstractNotification
{
    private $phone;
    private $temp;
    
    public function __construct(string $phone, string $temp)
    {
        $this->phone = $phone;
        $this->temp = $temp;
    }
    
    protected function prepareText(): string
    {
        return sprintf('Your name and Temperature more than 20C. %s', $this->temp);
    }
    
    protected function prepareTo(): string
    {
        return $this->phone;
    }
    
    
}