<?php declare(strict_types=1);


namespace App\Notification\Notifications\Directions;

use App\Notification\Sender\SendDirection;
use \App\Notification\Sender\DirectionCollection as IDirectionCollection;

class DirectionCollection implements IDirectionCollection
{
    private $directions = [];
    
    public function addDirection(SendDirection $direction)
    {
        $this->directions[$direction->name()] = $direction;
    }
    
    //COUNTABLE FUNCTIONS
    public function count()
    {
        return count($this->directions);
    }
    
    //ITERATOR FUNCTIONS
    public function rewind()
    {
        return reset($this->directions);
    }
    
    public function current(): SendDirection
    {
        return current($this->directions);
    }
    
    public function key()
    {
        return key($this->directions);
    }
    
    public function next()
    {
        return next($this->directions);
    }
    
    public function valid()
    {
        return key($this->directions) !== null;
    }
    
}