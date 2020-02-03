<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\CityComposer;
use App\Http\ViewComposers\CategoryComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'client.register',
            'client.users.profile',
            'client.orders.index',
        ], CityComposer::class);
        view()->composer([
            'client.layouts.header',
            'admin.categories.detail',
            'admin.categories.create',
            'admin.products.create',
            'admin.products.detail',
            ], CategoryComposer::class
        );
    }
}
