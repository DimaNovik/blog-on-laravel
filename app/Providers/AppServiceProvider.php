<?php

namespace App\Providers;
use App\Anonses;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        view()->composer('pages._right-sidebar', function($view) {
            $now = date('Y-m-d');
           $view->with('anonses', Anonses::where('date', '>=', $now)->orderBy('id', 'desc')->take(5)->get());
        });

        view()->composer('pages._navigate', function($view) {
            $view->with('menu', Category::all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
