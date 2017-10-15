<?php

namespace App\Model\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class OauthRepositoryProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('App\Model\Contracts\OauthRepositoryInterface', 'App\Model\Repositories\OauthRepository');
    }
	
}
