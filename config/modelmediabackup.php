<?php

return [
    /*
     * Models from which you want to take media for backup
     */
    'Models' => [
        // Example 'App\User'
    ],

    /*
     * Backup FILESYSTEM_DRIVER name on which you want to take backup
     */
    'BACKUP_DISK' => null, // FILESYSTEM_DRIVER

    /*
     * Number of records to be chunk in backup process
     */
    'ChunkSize' => 100,

    /*
     * Notification configuration
     */
    'Notification' => [

        /*
         * Email address where you want to receive email alert
         */
        'MailTo' => null,

        /*
         * Here you can specify the notifiable to which the notifications should be sent. The default
         *
         * notifiable will use the variables specified in this config file.
         */
        'notifiable' => \BinBytes\ModelMediaBackup\Notifications\Notifiable::class,

        'Notifications' => [
            \BinBytes\ModelMediaBackup\Notifications\Notifications\MediaBackupSuccessful::class,
        ]
    ]
];