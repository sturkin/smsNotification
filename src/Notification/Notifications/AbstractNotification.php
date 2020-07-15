<?php


namespace App\Notification\Notification;


abstract class AbstractNotification
{
    private $to;
    private $text;
    
    final public function getTo()
    {
        return $this->prepareTo();
    }
    
    protected function setTo($to)
    {
        $this->to = $to;
    }
    
    final public function getText()
    {
        return $this->prepareText();
    }
    
    protected function setText($text)
    {
        $this->text = $text;
    }
    
    abstract protected function prepareText(): string;
    abstract protected function prepareTo(): string;
    
    
    
}