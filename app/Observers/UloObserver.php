<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\Admin\Ulo;

class UloObserver
{
    protected $logHelper;

    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }

    public function created(Ulo $ulo)
    {
        $this->logHelper->createLog(
            'created',
            'A new Ulo record has been created.',
            null,
            $ulo->toArray()
        );
    }

    public function updated(Ulo $ulo)
    {
        $this->logHelper->createLog(
            'updated',
            'A Ulo record has been updated.',
            $ulo->getOriginal(),
            $ulo->getChanges()
        );
    }

    public function deleted(Ulo $ulo)
    {
        $this->logHelper->createLog(
            'deleted',
            'A Ulo record has been deleted.',
            $ulo->toArray()
        );
    }
}
