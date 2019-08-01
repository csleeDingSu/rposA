<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
		 'App\Events\UserLoggedIn' => [
            'App\Listeners\WriteMessageToFile',
        ],
		 'App\Events\GenerateVoucher' => [
            'App\Listeners\GenerateVouchertoDb',
        ],
		'App\Events\ImportSoftpins' => [
            'App\Listeners\LisImportSoftpins',
        ],
		'App\Events\ImportAds' => [
            'App\Listeners\LisImportAds',
        ],
		'Illuminate\Auth\Events\Authenticated' => [
        	'App\Listeners\LogAuthenticated',
    	],    
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
