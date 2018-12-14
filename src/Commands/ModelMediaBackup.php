<?php

namespace BinBytes\ModelMediaBackup\Commands;

use BinBytes\ModelMediaBackup\Interfaces\ShouldBackupFiles;
use BinBytes\ModelMediaBackup\Mail\MediaBackupTaken;
use Illuminate\Console\Command;

class ModelMediaBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:media:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take backup of resource by model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $backupDisk = config('modelmediabackup.BACKUP_DISK');

        if(!$backupDisk) {
            return;
        }

        $storage = \Storage::disk($backupDisk);
        $chunkSize = config('modelmediabackup.ChunkSize');

        foreach ($models = config('modelmediabackup.Models') as $model) {
            if(in_array(ShouldBackupFiles::class, class_implements($model)) === false) {
                continue;
            }

            $recordsBackup = [];

            $model::backupRecords()
                ->chunk($chunkSize, function ($records) use($storage, &$recordsBackup) {
                    $records->each(function ($record) use($storage, &$recordsBackup) {
                        if ($backupFiles = $record->backupFiles()) {
                            foreach (is_array($backupFiles) ? $backupFiles : [$backupFiles] as $backupFile) {
                                if($this->takeBackup($storage, $backupFile)) {
                                    $recordsBackup[] = $record->getKey();
                                }
                            }
                        }
                    });
                });

            if($recordsBackup) {
                $this->sendNotifications($recordsBackup);
            }
        }
    }

    /**
     * Copy file to destination/backup disk
     *
     * @param $storage
     * @param $file
     *
     * @return bool
     */
    protected function takeBackup($storage, $file)
    {
        if(\Storage::exists($file) && $storage->exists($file) == false) {
            $stream = \Storage::getDriver()->readStream($file);

            return $storage->put($file, $stream);
        }

        return false;
    }

    /**
     * Send notifications after backup
     *
     * @param $recordsBackup
     */
    protected function sendNotifications(array $recordsBackup)
    {
        if(!config('modelmediabackup.EnableNotification')) {
            return;
        }

        if($mailTo = config('modelmediabackup.Notification.MailTo')) {
            $this->sendNotificationMail($mailTo, $recordsBackup);
        }
    }

    /**
     * Send notification mail
     */
    protected function sendNotificationMail($mailTo, array $recordsBackup)
    {
        \Mail::to($mailTo)
            ->send(new MediaBackupTaken(
                $recordsBackup
            ));
    }
}
