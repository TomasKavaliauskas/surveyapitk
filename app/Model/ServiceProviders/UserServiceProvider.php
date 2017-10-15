<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use App\Model\Services\UserService;

class UserServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\UserServiceInterface', 'App\Model\Services\UserService');
    }
	
	
}
