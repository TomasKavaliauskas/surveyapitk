<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class SurveyRepositoryProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\SurveyRepositoryInterface', 'App\Model\Repositories\SurveyRepository');
    }
	
}
