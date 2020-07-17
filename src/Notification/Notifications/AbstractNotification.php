<?php declare(strict_types=1);


namespace App\Notification\Notifications;


use App\Notification\Notifications\Directions\DirectionCollection;
use App\Notification\Sender\DirectionCollection as IDirectionCollection;
use App\Notification\Sender\Notification;
use App\Notification\Sender\SendDirection;

abstract class AbstractNotification implements Notification
{
    
    private $text;
    private $sendDirections;
    
    public function getDirections(): IDirectionCollection
    {
        return $this->sendDirections;
    }
    
    public function addSendDirection(SendDirection $direction)
    {
        if (empty($this->sendDirections)) {
            $this->sendDirections = new DirectionCollection();
        }
        $this->sendDirections->addDirection($direction);
    }
    
    public function getText(): string
    {
        return $this->text;
    }
    
    protected function setText(string $text)
    {
        $this->text = $text;
    }
    
    final public function isValid(): bool
    {
        $res = true;
        if (count($this->sendDirections) < 1) {
            $res = false;
        }
        if (empty($this->text)) {
            $res = false;
        }
        
        return $res;
    }
    
    
}