# Laravel Model Media Backup
Take newly added media backup associated with any model rather than full backup on daily basis.

It will be useful in the case where you have lot of media but rather than taking whole media file each day it will be better to just take newly added media.

BinBytes is an web & mobile application development agency in Rajkot, India. You'll find an overview of all our services [on our website](https://binbytes.com).

## Installation

You can install this package via composer using:

``` bash
$ composer require binbytes/laravel-model-media-backup
```

The package will automatically register itself.

To publish the config file to `config/modelmediabackup.php` run:

```bash
php artisan vendor:publish --provider="BinBytes\ModelMediaBackup\ModelMediaBackupServiceProvider"
```
This will publish a file `modelmediabackup.php` in your config directory with the following contents:

```php
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
```
## Usage
After you've installed the package and filled in the values in the config-file, you need to setup model from which you want to take media.

Your Eloquent models should use the `BinBytes\ModelMediaBackup\Traits\HasBackupRecord` trait.

The trait contains an abstract method `backupFiles()` that you must implement yourself. 

Here's an example of how to implement the trait:

```php
<?php

namespace App;

use BinBytes\ModelMediaBackup\Traits\HasBackupRecords;
use Illuminate\Database\Eloquent\Model;

class YourEloquentModel extends Model
{
    use HasBackupRecords;

    /**
     * Media file associated with record
     * @return string|array
     */
    public function backupFiles()
    {
        return $this->path(); // Full path of your media file OR array of paths
    }
}
```

Want to take records as per own strategy? according to your need? No problem!
By default the records of yesterday will be taken for backup.

```php
/**
 * Select records to processed
 */
public static function backupRecords()
{
    return self::latest()
            ->whereDate('created_at', Carbon::yesterday()->toDateString());
}
```

Now you are ready to go, just run below artisan command to take backup
```php
php artisan model:media:backup
```

To run backup on daily basis add this in `App\Console\Kernel`
```php
$schedule->command('model:media:backup')->daily();
```

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Nikunj Kanetiya](https://github.com/nikkanetiya)
- [Malde Chavda](https://github.com/maldechavda)

## License

MIT License. Please see the [license file](LICENSE.md) for more information.

[link-author]: https://github.com/binbytes