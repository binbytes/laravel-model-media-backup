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
            ->subject('Model media backup alert! - ' . config('app.name'))
            ->markdown('modelmediabackup::mail.backup.processed', [
                'records' => $this->event->recordsBackup
            ]);
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