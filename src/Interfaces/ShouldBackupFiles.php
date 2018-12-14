<?php

namespace BinBytes\ModelMediaBackup\Interfaces;

/**
 * Interface ShouldBackupFiles
 * @package BinBytes\ModalBackup\Interfaces
 */
interface ShouldBackupFiles
{
    /**
     * Files those are need to backup with associate with record
     * @return string|array
     */
    public function backupFiles();

    public static function backupRecords();
}
