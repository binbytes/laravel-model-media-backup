<?php

namespace BinBytes\ModelMediaBackup\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MediaBackupTaken extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, Queueable;

    /**
     * Backup Taken of these records
     *
     * @var array
     */
    public $records;

    /**
     * Create a new message instance.
     *
     * @param array $records
     */
    public function __construct(array $records)
    {
        $this->records = $records;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('modelmediabackup::mail.backup.processed', [
            'records' => $this->records
        ]);
    }
}