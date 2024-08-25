<?php

namespace App\Quoter;

use Illuminate\Support\ServiceProvider;

class QuoterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('quoter', function ($app) {
            return new QuoterManager($app);
        });
    }
}
