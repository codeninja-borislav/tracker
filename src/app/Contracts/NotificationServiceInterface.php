<?php

namespace App\Contracts;

interface NotificationServiceInterface
{
    public function checkAndNotifyUsers(): void;
}
