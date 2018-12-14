<?php

namespace BinBytes\ModelMediaBackup\Events;

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
