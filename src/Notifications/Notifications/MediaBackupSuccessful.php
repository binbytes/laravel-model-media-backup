<?php

namespace BinBytes\ModelMediaBackup\Notifications\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use BinBytes\ModelMediaBackup\Events\MediaBackupSuccessful as MediaBackupSuccessfulEvent;

class MediaBackupSuccessful extends Notification
{
    /**
     * @var MediaBackupSuccessfulEvent
     */
    protected $event;

    public function toMail()
    {
        return (new MailMessage)
            ->subject(trans('backup::notifications.backup_successful_subject', ['application_name' => $this->applicationName()]))
            ->markdown('modelmediabackup::mail.backup.processed', [
                'records' => $this->event->records
            ]);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function applicationName()
    {
        return config('app.name') ?? config('app.url') ?? 'Laravel application';
    }

    /**
     * @param \BinBytes\ModelMediaBackup\Events\MediaBackupSuccessful $event
     *
     * @return $this
     */
    public function setEvent(MediaBackupSuccessfulEvent $event)
    {
        $this->event = $event;

        return $this;
    }
}