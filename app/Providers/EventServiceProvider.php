<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\Admin\Izin;
use App\Observers\IzinObserver;
use App\Models\Admin\Ulo;
use App\Observers\UloObserver;
use App\Models\Admin\Penomoran;
use App\Observers\PenomoranObserver;
use App\Models\Admin\User;
use App\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        //
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Izin::observe(IzinObserver::class);
        Ulo::observe(UloObserver::class);
        Penomoran::observe(PenomoranObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
