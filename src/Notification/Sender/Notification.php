<?php declare(strict_types=1);

namespace App\Notification\Sender;

interface Notification
{
    
    public function getDirections(): DirectionCollection;
    
    public function getText(): string;
    
}