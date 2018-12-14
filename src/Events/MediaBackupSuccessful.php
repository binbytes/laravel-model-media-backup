<?php

namespace BinBytes\ModelMediaBackup\Events;

use Exception;
use Spatie\Backup\BackupDestination\BackupDestination;

class MediaBackupSuccessful
{
    /**
     * @var array
     */
    public $recordsBackup;

    /**
     * MediaBackupSuccessful constructor.
     *
     * @param array $recordsBackup
     */
    public function __construct(array $recordsBackup)
    {
        $this->recordsBackup = $recordsBackup;
    }
}
