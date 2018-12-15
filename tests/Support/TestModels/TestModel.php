<?php

namespace BinBytes\ModelMediaBackup\Tests\Support\TestModels;

use Illuminate\Database\Eloquent\Model;
use BinBytes\ModelMediaBackup\Traits\HasBackupRecords;

class TestModel extends Model
{
    use HasBackupRecords;

    /**
     * @var string
     */
    protected $table = 'test_models';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Media file associated with record.
     *
     * @return string|array
     */
    public function backupFiles()
    {
        return [
            $this->avatar,
            $this->second_avatar,
        ];
    }

    /**
     * @return mixed
     */
    public static function backupRecords()
    {
        return self::latest();
    }
}
