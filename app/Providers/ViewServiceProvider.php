<?php

namespace App\Providers;

use App\Http\View\Composers\ProfileComposer;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Traits\CommonDataTrait;

class ViewServiceProvider extends ServiceProvider
{
    use CommonDataTrait;
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
        View::composer('*', function ($view) {
            $pages_data = Setting::where('is_custom_page',1)->where('status',1)->get();
            $view->with('categories', $this->getCategoriesList() );
            $view->with('pages_data', $pages_data );

        });
    }
}
