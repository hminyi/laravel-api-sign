<?php

namespace Zsirius\Signature\Providers;

use Illuminate\Support\ServiceProvider;
use Zsirius\Signature\Services\ApiSign;

class LumenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Signature', ApiSign::class);
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
