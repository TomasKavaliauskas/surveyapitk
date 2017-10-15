<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class SurveyServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\SurveyServiceInterface', 'App\Model\Services\SurveyService');
    }
	
}
