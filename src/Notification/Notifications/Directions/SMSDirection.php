<?php declare(strict_types=1);

namespace App\Notification\Notifications\Directions;

use App\Notification\Sender\SendDirection;

class SMSDirection implements SendDirection
{
    private $phone;
    
    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }
    
    public function info(): array
    {
        return [
            'phone' => $this->phone
        ];
    }
    
    public function name(): string
    {
        return 'SMS';
    }
    
    
}