<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use App\Model\Services\AnswerService;

class AnswerServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\AnswerServiceInterface', 'App\Model\Services\AnswerService');
    }
	
	
}
