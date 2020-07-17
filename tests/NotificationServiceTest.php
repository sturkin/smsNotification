<?php

use App\Notification\Notifications\Builders\NotificationBuilder;
use App\Notification\Notifications\TempAbove20Notification;
use App\Notification\Notifications\TempLess20Notification;
use PHPUnit\Framework\TestCase;
use App\Notification\Sender\Sender;
use App\Notification\NotificationService;
use App\Notification\Sender\Notification;

class NotificationServiceTest extends TestCase
{
    
    public function testSentTemperatureNotificationAbove20()
    {
        $temp = 21;
        $phone = '+306948872100';
        
        $notificationBuilder = new NotificationBuilder();
        $mockSender = $this->createMock(Sender::class);
        
        $mockSender->expects($this->once())
            ->method('send')
            ->with(
                $this->callback(function (Notification $notification) use ($phone) {
                    $this->assertInstanceOf(TempAbove20Notification::class, $notification);
                    
                    $isValidDirection = false;
                    /** @var \App\Notification\Sender\SendDirection $direction */
                    foreach ($notification->getDirections() as $direction) {
                        if ($direction->name() === 'SMS') {
                            $isValidDirection = true;
                            $this->assertSame($phone, $direction->info()['phone']);
                        }
                    }
                    
                    $this->assertTrue($isValidDirection);
                    
                    return true;
                })
            );
        
        $notificationService = new NotificationService($notificationBuilder, $mockSender);
        $notificationService->sentTemperatureNotification($temp, $phone);
    }
    
    public function testSentTemperatureNotificationLess20()
    {
        $temp = 20;
        $phone = '+306948872100';
        
        $notificationBuilder = new NotificationBuilder();
        $mockSender = $this->createMock(Sender::class);
        
        $mockSender->expects($this->once())
            ->method('send')
            ->with(
                $this->callback(function (Notification $notification) use ($phone) {
                    $this->assertInstanceOf(TempLess20Notification::class, $notification);
                    
                    $isValidDirection = false;
                    /** @var \App\Notification\Sender\SendDirection $direction */
                    foreach ($notification->getDirections() as $direction) {
                        if ($direction->name() === 'SMS') {
                            $isValidDirection = true;
                            $this->assertSame($phone, $direction->info()['phone']);
                        }
                    }
                    
                    $this->assertTrue($isValidDirection);
                    
                    return true;
                })
            );
        
        $notificationService = new NotificationService($notificationBuilder, $mockSender);
        $notificationService->sentTemperatureNotification($temp, $phone);
    }
    
}