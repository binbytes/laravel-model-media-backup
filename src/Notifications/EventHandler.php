<?php

namespace BinBytes\ModelMediaBackup\Notifications;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use BinBytes\ModelMediaBackup\Events\MediaBackupSuccessful;

class EventHandler
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * EventHandler constructor.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen($this->allEventClasses(), function ($event) {
            $notifiable = $this->determineNotifiable();

            $notification = $this->determineNotification($event);

            $notifiable->notify($notification);
        });
    }

    /**
     * @return \BinBytes\ModelMediaBackup\Notifications\Notifiable
     */
    protected function determineNotifiable()
    {
        $notifiableClass = $this->config->get('modelmediabackup.Notification.notifiable');

        return app($notifiableClass);
    }

    /**
     * @param $event
     *
     * @return \Illuminate\Notifications\Notification
     * @throws \Exception
     */
    protected function determineNotification($event)
    {
        $eventName = class_basename($event);
        $notificationClass = collect($this->config->get('modelmediabackup.Notification.Notifications'))
            ->first(function ($notificationClass) use ($eventName) {
                return class_basename($notificationClass) === $eventName;
            });

        if (! $notificationClass) {
            throw new \Exception('Notification not found'); //@todo apply notification classes.
        }

        return app($notificationClass)->setEvent($event);
    }

    /**
     * @return array
     */
    protected function allEventClasses()
    {
        return [
            MediaBackupSuccessful::class,
        ];
    }
}
