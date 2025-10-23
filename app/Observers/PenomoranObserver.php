<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\Admin\Penomoran;

class PenomoranObserver
{
    protected $logHelper;

    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }

    public function created(Penomoran $penomoran)
    {
        $this->logHelper->createLog(
            'created',
            'A new Penomoran record has been created.',
            null,
            $penomoran->toArray()
        );
    }

    public function updated(Penomoran $penomoran)
    {
        $this->logHelper->createLog(
            'updated',
            'A Penomoran record has been updated.',
            $penomoran->getOriginal(),
            $penomoran->getChanges()
        );
    }

    public function deleted(Penomoran $penomoran)
    {
        $this->logHelper->createLog(
            'deleted',
            'A Penomoran record has been deleted.',
            $penomoran->toArray()
        );
    }
}
