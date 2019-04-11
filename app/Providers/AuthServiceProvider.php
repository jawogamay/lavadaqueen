<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('laundry',function($user){
            return $user->type === 'Laundry Shop';
        });

        Gate::define('customer',function($user){
            return $user->type === 'Customer';
        });

        Gate::define('admin',function($user){
            return $user->type = 'Admin';
        });

        Passport::routes();
        //
    }
}
