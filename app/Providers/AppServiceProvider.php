<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('model_exists', function ($attribute, $value, $parameters, $validator) {
            $model = new $parameters[0];
            $result = $model->select([$parameters[1]])
                            ->where($parameters[1], $value)
                            ->first();
            return !empty($result);
        });

        Validator::extend('model_unique', function ($attribute, $value, $parameters, $validator) {
            $model = new $parameters[0];
            $result = $model->select([$parameters[1]])
                            ->where($parameters[1], $value)
                            ->first();
            return empty($result);
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
