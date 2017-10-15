<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class AnsweredSurveyRepositoryProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\AnsweredSurveyRepositoryInterface', 'App\Model\Repositories\AnsweredSurveyRepository');
    }
	
}
