<?php

namespace Mediusware\Affiliate;

use Illuminate\Support\ServiceProvider;

class AffiliateServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'affiliate');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->mergeConfigFrom(
            __DIR__.'/config/affiliate.php', 'affiliate'
        );

        $this->publishes([
            __DIR__.'/config/affiliate.php' => config_path('affiliate.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__.'/path/to/config/courier.php', 'courier'
        // );
    }

}

