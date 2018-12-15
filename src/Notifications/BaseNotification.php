<?php

namespace BinBytes\ModelMediaBackup\Notifications;

use Illuminate\Notifications\Notification;

class BaseNotification extends Notification
{
    /**
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }
}
