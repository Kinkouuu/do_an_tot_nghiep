<?php

namespace App\Providers;

use App\Events\BookingChangeStatus;
use App\Events\BookingEvent;
use App\Listeners\SendBookingNotification;
use App\Listeners\SeperatedRooms;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BookingEvent::class => [
            SeperatedRooms::class,
            SendBookingNotification::class,
        ],
        BookingChangeStatus::class => [
            SendBookingNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
