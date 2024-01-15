<?php

namespace App\Contracts;

use App\Models\Notification;

interface NotificationRepositoryInterface
{
    /**
     * Create a new notification with the given data.
     *
     * @param array $data Data for creating the notification.
     * @return Notification Returns the newly created Notification object.
     */
    public function create(array $data): Notification;
}
