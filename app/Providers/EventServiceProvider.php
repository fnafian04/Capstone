<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\TransaksiDibuat;
use App\Events\TransaksiDibayar;
use App\Listeners\KirimWABelumDibayar;
use App\Listeners\KirimWASudahDibayar;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\TransaksiDibuat::class => [
            \App\Listeners\KirimWAPending::class,
        ],
        \App\Events\TransaksiDibayar::class => [
            \App\Listeners\KirimWADiproses::class,
        ],
    ];

}
