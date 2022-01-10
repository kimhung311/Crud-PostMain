<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      // require_once __DIR__.'/../Helpers/hepler';
      
      // $file = app_path('Helpers/hepler.php');
      // if(file_exists($file)){
      //   require_once ($file);
      // }
      // foreach(glob(app_path().'Helpers/*.php')as $file){
      //   require_once($file);
      // }
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Paginator::useBootstrap();

    }
}