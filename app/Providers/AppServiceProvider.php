<?php

namespace App\Providers;
use App\AlertNotification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'layouts.admin',
            function ($view) {
                $view->with(
                    'notifications',
                    AlertNotification::where('user_id', Auth::user()->id)->orderByDesc('id')->limit(3)->get()
                );
            }
        );

        view()->composer(
            'layouts.admin',
            function ($view) {
                $view->with(
                    'notificationscount',
                    AlertNotification::where([['user_id', '=', Auth::user()->id], ['read', '=', 0]])->count()
                );
            }
        );
    }
}
