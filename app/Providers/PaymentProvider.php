<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Paypal;

class PaymentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Paypal::class, function ($app) {
            return new Paypal(env('PAYPAL_ID'), env('PAYPAL_SECRET'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
