<?php

namespace App\Observers;

use App\Helpers\LogHelper;
use App\Models\Admin\User;

class UserObserver
{
    protected $logHelper;

    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }

    public function created(User $user)
    {
        $this->logHelper->createLog(
            'created',
            'A new User has been created.',
            null,
            $user->toArray()
        );
    }

    public function updated(User $user)
    {
        $this->logHelper->createLog(
            'updated',
            'A User has been updated.',
            $user->getOriginal(),
            $user->getChanges()
        );
    }

    public function deleted(User $user)
    {
        $this->logHelper->createLog(
            'deleted',
            'A User has been deleted.',
            $user->toArray()
        );
    }
}
