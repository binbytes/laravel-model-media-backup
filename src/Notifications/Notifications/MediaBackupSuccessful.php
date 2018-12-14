<?php

namespace BinBytes\ModelMediaBackup\Notifications\Notifications;

use BinBytes\ModelMediaBackup\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use BinBytes\ModelMediaBackup\Events\MediaBackupSuccessful as MediaBackupSuccessfulEvent;

class MediaBackupSuccessful extends BaseNotification
{
    /**
     * @var MediaBackupSuccessfulEvent
     */
    protected $event;

    /**
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
            ->subject(trans('backup::notifications.backup_successful_subject', ['application_name' => $this->applicationName()]))
            ->markdown('modelmediabackup::mail.backup.processed', [
                'records' => $this->event->recordsBackup
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