<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class UserRepositoryProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\UserRepositoryInterface', 'App\Model\Repositories\UserRepository');
    }
	
}
