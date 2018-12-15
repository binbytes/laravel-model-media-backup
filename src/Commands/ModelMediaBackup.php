<?php

namespace BinBytes\ModelMediaBackup\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use BinBytes\ModelMediaBackup\Events\MediaBackupSuccessful;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $backupDisk = config('modelmediabackup.backup_disk')) {
            return;
        }

        $storage = Storage::disk($backupDisk);
        $chunkSize = config('modelmediabackup.chunk_size');

        foreach ($models = config('modelmediabackup.models') as $model) {
            if (method_exists($model, 'backupFiles') === false) {
                continue;
            }

            $recordsBackup = [];

            $model::backupRecords()
                ->chunk($chunkSize, function ($records) use ($storage, &$recordsBackup) {
                    $records->each(function ($record) use ($storage, &$recordsBackup) {
                        if ($backupFiles = $record->backupFiles()) {
                            foreach (Arr::wrap($backupFiles) as $backupFile) {
                                if ($this->takeBackup($storage, $backupFile)) {
                                    $recordsBackup[] = $record->getKey();
                                }
                            }
                        }
                    });
                });

            if ($recordsBackup) {
                $this->sendNotifications($recordsBackup);
            }
        }
    }

    /**
     * Copy file to destination/backup disk.
     *
     * @param \Illuminate\Contracts\Filesystem\Filesystem $storage
     * @param string $file
     *
     * @return bool
     */
    protected function takeBackup($storage, $file)
    {
        if (Storage::exists($file) && $storage->exists($file) == false) {
            $stream = Storage::getDriver()->readStream($file);

            return $storage->put($file, $stream);
        }

        return false;
    }

    /**
     * Send notifications after backup.
     *
     * @param array $recordsBackup
     */
    protected function sendNotifications(array $recordsBackup)
    {
        event(
            new MediaBackupSuccessful($recordsBackup)
        );
    }
}
