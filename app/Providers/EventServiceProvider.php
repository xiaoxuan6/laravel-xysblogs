<?php

namespace App\Providers;

use App\Events\RegisterSendMail;
use App\Events\ReplySendMail;
use App\Listeners\RegisterSendMailListener;
use App\Listeners\ReplySendMailListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        ReplySendMail::class => [
            ReplySendMailListener::class,
        ],

        RegisterSendMail::class => [
            RegisterSendMailListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
