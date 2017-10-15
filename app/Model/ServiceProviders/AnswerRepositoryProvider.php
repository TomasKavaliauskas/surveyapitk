<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class AnswerRepositoryProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\AnswerRepositoryInterface', 'App\Model\Repositories\AnswerRepository');
    }
	
}
