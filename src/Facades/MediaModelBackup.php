<?php

namespace BinBytes\ModelMediaBackup\Facades;

use Illuminate\Support\Facades\Facade;

class MediaModelBackup extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mediamodelbackup';
    }
}
