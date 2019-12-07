<?php

namespace SnappMarket\ApiResponder;


use Emyoutis\WhiteHouseResponder\ErrorsRepository;
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

        $this
             ->app
             ->when(Response::class)
             ->needs(ErrorsRepository::class)
             ->give(function () {
                 return app('whitehouse.errors');
             })
        ;
    }
}
