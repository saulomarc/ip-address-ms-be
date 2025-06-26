<?php

namespace App\Providers;

use App\Models\IpAddress;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-ip_address', function (User $user, IpAddress $ip_address) {
            return $user->id === $ip_address->user_id;
        });
    }
}
