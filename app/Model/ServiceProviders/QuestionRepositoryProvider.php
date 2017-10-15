<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class QuestionRepositoryProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\QuestionRepositoryInterface', 'App\Model\Repositories\QuestionRepository');
    }
	
}
