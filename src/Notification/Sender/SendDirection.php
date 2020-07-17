<?php declare(strict_types=1);

namespace App\Notification\Sender;

interface SendDirection
{
    public function name(): string;
    
    public function info(): array;
}