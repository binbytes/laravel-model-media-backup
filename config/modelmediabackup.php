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
     * Turn it to true if you want notification after backup is proccessed
     */
    'EnableNotification' => false,

    /*
     * Notification configuration
     */
    'Notification' => [

        /*
         * Email address where you want to receive email alert
         */
        'MailTo' => null
    ]
];