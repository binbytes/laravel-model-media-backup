<?php

namespace BinBytes\ModelMediaBackup\Tests;

use BinBytes\ModelMediaBackup\ModelMediaBackupServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('second_avatar')->nullable();
            $table->softDeletes();
        });

        $app['db']->connection()->getSchemaBuilder()->create('test_new_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('filesystems.disks', [
            'local' => [
                'driver' => 'local',
                'root' => storage_path('app'),
            ],
            'backup' => [
                'driver' => 'local',
                'root' => storage_path('app/backup'),
            ],
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ModelMediaBackupServiceProvider::class
        ];
    }

}
