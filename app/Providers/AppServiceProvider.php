<?php

namespace App\Providers;

use App\Enums\RoleAccount;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('isAdmin', function () {
            return auth()->guard('admins')->check() && auth()->guard('admins')->user()->role == RoleAccount::Admin;
        });
        Blade::if('isManager', function () {
            return auth()->guard('admins')->check() &&
                (
                    auth()->guard('admins')->user()->role == RoleAccount::Manager
                    ||
                    auth()->guard('admins')->user()->role == RoleAccount::Admin
                );
        });
    }
}
