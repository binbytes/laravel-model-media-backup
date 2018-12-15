<?php

namespace BinBytes\ModelMediaBackup\Tests\Integration;

use BinBytes\ModelMediaBackup\Events\MediaBackupSuccessful;
use BinBytes\ModelMediaBackup\Tests\Support\TestModels\TestModel;
use BinBytes\ModelMediaBackup\Tests\Support\TestModels\TestNewModel;
use BinBytes\ModelMediaBackup\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ModelMedialBackupCommandTest extends TestCase
{
    /**
     * @var TestModel
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('modelmediabackup.models', [
            TestModel::class,
            TestNewModel::class,
        ]);

        $this->app['config']->set('modelmediabackup.backup_disk', 'backup');

        Storage::fake('local');
        $baseFile = UploadedFile::fake()->image('avatar.jpg');
        $file = Storage::disk('local')->putFile(
            'avatars',
            $baseFile
        );

        $this->model = TestModel::create([
            'name' => 'hello',
            'avatar' => $file,
        ]);

        Storage::disk('local')->assertExists($file);
    }

    /**
     * @test
     */
    public function it_can_take_backup()
    {
        Artisan::call('model:media:backup');

        Storage::disk('backup')->assertExists($this->model->avatar);
    }

    /**
     * @test
     */
    public function it_can_take_multipal_field_backup()
    {
        $file = Storage::disk('local')->putFile(
            'avatars',
            UploadedFile::fake()->image('new_avatar.jpg')
        );
        $this->model->second_avatar = $file;
        $this->model->save();

        Artisan::call('model:media:backup');

        Storage::disk('backup')->assertExists($this->model->avatar);
        Storage::disk('backup')->assertExists($this->model->second_avatar);
    }

    /**
     * @test
     */
    public function it_can_take_multipal_model_backup()
    {
        $file = Storage::disk('local')->putFile(
            'new_avatars',
            UploadedFile::fake()->image('new_avatar.jpg')
        );
        $this->model->second_avatar = $file;
        $this->model->save();

        $newModel = TestNewModel::create([
            'name' => 'helloworld',
            'avatar' => Storage::disk('local')->putFile(
                'new_model_avatars',
                UploadedFile::fake()->image('new_avatar.jpg')
            )
        ]);

        Artisan::call('model:media:backup');

        Storage::disk('backup')->assertExists($this->model->avatar);
        Storage::disk('backup')->assertExists($this->model->second_avatar);
        Storage::disk('backup')->assertExists($newModel->avatar);
    }

    /**
     * @test
     */
    public function it_will_fire_an_event_after_a_model_backup_was_taken_successfully()
    {
        $this->expectsEvents(MediaBackupSuccessful::class);

        Artisan::call('model:media:backup');
    }

    /**
     * @test
     */
    public function it_will_mot_fire_an_event_if_no_new_recored_found()
    {
        $this->model->delete();
        $this->doesntExpectEvents(MediaBackupSuccessful::class);

        Artisan::call('model:media:backup');
    }
}
