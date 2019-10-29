<?php

namespace App\Providers;

use App\Sage\CreditPaymentGateway;
use App\Sage\PaymentGateway;
use App\Sage\PaymentGatewayContract;
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
        $this->app->singleton(PaymentGatewayContract::class, function() {
            if (request()->has('credit')) {
                return new CreditPaymentGateway('zar');
            }

            return new PaymentGateway('zar');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
