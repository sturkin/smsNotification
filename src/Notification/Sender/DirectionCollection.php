<?php declare(strict_types=1);


namespace App\Notification\Sender;


interface DirectionCollection extends \Iterator, \Countable
{
    public function current(): SendDirection;
    
}