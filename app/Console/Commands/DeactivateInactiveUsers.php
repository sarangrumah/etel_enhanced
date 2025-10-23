<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeactivateInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:deactivate-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate users who have been inactive for a month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $inactiveUsers = User::where('last_login_at', '<', Carbon::now()->subMonth())
            ->where('status', true)
            ->get();

        foreach ($inactiveUsers as $user) {
            $user->update(['status' => false]);
            $user->notify(new \App\Notifications\AccountDeactivated());
        }

        Log::info($inactiveUsers->count() . ' users deactivated.');

        return 0;
    }
}
