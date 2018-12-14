<?php

namespace BinBytes\ModelMediaBackup\Traits;

use Carbon\Carbon;

trait HasBackupRecords
{
    /**
     * Select records to processed
     */
    public static function backupRecords()
    {
        return self::latest()
                ->whereDate('created_at', Carbon::yesterday()->toDateString());
    }
}
