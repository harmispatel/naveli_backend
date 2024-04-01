<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('first_not_null', function ($attribute, $value, $parameters, $validator) {
            if (!is_null($value) && is_array($value) && count($value) > 0) {
                return !is_null($value[0]);
            }
            return false;
        });

        Validator::replacer('first_not_null', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must have at least one non-null value.');
        });
    }
}
