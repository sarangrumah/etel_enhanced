<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\Admin\Izin;

class IzinObserver
{
    protected $logHelper;

    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }

    public function created(Izin $izin)
    {
        $this->logHelper->createLog(
            'created',
            'A new Izin record has been created.',
            null,
            $izin->toArray()
        );
    }

    public function updated(Izin $izin)
    {
        $this->logHelper->createLog(
            'updated',
            'An Izin record has been updated.',
            $izin->getOriginal(),
            $izin->getChanges()
        );
    }

    public function deleted(Izin $izin)
    {
        $this->logHelper->createLog(
            'deleted',
            'An Izin record has been deleted.',
            $izin->toArray()
        );
    }
}
