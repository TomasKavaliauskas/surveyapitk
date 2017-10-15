<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use App\Model\Services\QuestionService;

class QuestionServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\QuestionServiceInterface', 'App\Model\Services\QuestionService');
    }
	
	
}
