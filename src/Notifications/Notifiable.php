<?php

namespace BinBytes\ModelMediaBackup\Notifications;

use Illuminate\Notifications\Notifiable as NotifiableTrait;

class Notifiable
{
    use NotifiableTrait;

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function routeNotificationForMail()
    {
        return config('modelmediabackup.notification.mail_to');
    }
}
