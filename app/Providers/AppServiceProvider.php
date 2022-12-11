<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ChecklistObserver;//ini
use App\Model\Checklist; //ini

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
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
    	date_default_timezone_set('Asia/Jakarta');
    	Checklist::observe(ChecklistObserver::class);//ganti ini
    }
}
