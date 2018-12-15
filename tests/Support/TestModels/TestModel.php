<?php

namespace BinBytes\ModelMediaBackup\Tests\Support\TestModels;

use BinBytes\ModelMediaBackup\Traits\HasBackupRecords;
use Illuminate\Database\Eloquent\Model;

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
     * Media file associated with record
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