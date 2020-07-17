#!/usr/bin/env php
<?php

require_once 'bootstrap.php';

$cityName = $argv[1];
$phone = $argv[2];

/** @var \App\Weather\WeatherService $weatherService */

$weatherService = kernel()->getService(\App\Weather\WeatherService::class);

$temp = $weatherService->getTemperatureByCity($cityName);

/** @var \App\Notification\NotificationService $notificationService */
$notificationService = kernel()->getService(\App\Notification\NotificationService::class);
$notificationService->sentTemperatureNotification($temp, $phone);
