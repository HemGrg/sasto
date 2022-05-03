<?php

namespace App\Providers;

use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        Paginator::useBootstrap();

        $charts->register([
            \App\Charts\SalesChart::class,
            \App\Charts\PaymentTypePieChart::class,
        ]);


        // \DB::listen(function($query) {
        //     \Log::info(
        //         $query->sql,
        //         $query->bindings,
        //         $query->time
        //     );
        // });

        // Disable the auto refresh of laravel-debugbar
        // \Debugbar::getJavascriptRenderer()->setAjaxHandlerAutoShow(false);
    }
}
