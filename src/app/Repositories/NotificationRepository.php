<?php

namespace App\Repositories;

use App\Contracts\NotificationRepositoryInterface;
use App\Models\Notification;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * Create a new notification with the given data.
     *
     * @param array $data Data for creating the notification.
     * @return Notification Returns the newly created Notification object.
     */
    public function create(array $data): Notification
    {
        return Notification::create($data);
    }
}
