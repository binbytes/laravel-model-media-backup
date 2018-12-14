<?php

namespace BinBytes\ModelMediaBackup\Traits;

use Carbon\Carbon;

trait HasBackupRecords
{
    /**
     * Media file associated with record
     * @return string|array
     */
    public abstract function backupFiles();

    /**
     * Select records to processed
     */
    public static function backupRecords()
    {
        return self::latest()
                ->whereDate('created_at', Carbon::yesterday()->toDateString());
    }
}
