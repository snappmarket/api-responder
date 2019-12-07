<?php

namespace SnappMarket\ApiResponder;


use Illuminate\Support\ServiceProvider;

class ApiResponderServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerSingletons();
    }



    /**
     * Registers the singleton.
     */
    protected function registerSingletons()
    {
        $this->registerResponseSingleton();
    }



    /**
     * Registers the singleton for the response.
     */
    protected function registerResponseSingleton()
    {
        $this->app->singleton('snappmarket.response', function () {
            return app()->make(Response::class);
        });
    }
}
