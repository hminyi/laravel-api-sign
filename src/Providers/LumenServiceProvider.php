<?php

namespace Zsirius\Signature\Providers;

use Illuminate\Support\ServiceProvider;
use Zsirius\Signature\Services\Signature;

class LumenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('signature', Signature::class);
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
