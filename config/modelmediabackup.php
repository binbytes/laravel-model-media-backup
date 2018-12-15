<?php

return [
    /*
     * Models from which you want to take media for backup
     */
    'models' => [
        // Example 'App\User'
    ],

    /*
     * Backup FILESYSTEM_DRIVER name on which you want to take backup
     */
    'backup_disk' => null, // FILESYSTEM_DRIVER

    /*
     * Number of records to be chunk in backup process
     */
    'chunk_size' => 100,

    /*
     * Notification configuration
     */
    'notification' => [

        /*
         * Email address where you want to receive email alert
         */
        'mail_to' => null,

        /*
         * Here you can specify the notifiable to which the notifications should be sent. The default
         *
         * notifiable will use the variables specified in this config file.
         */
        'notifiable' => \BinBytes\ModelMediaBackup\Notifications\Notifiable::class,

        'notifications' => [
            \BinBytes\ModelMediaBackup\Notifications\Notifications\MediaBackupSuccessful::class,
        ],
    ],
];
