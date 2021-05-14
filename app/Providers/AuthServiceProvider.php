<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->roles->first()->slug == 'admin';
        });

        Gate::define('isLecturer', function ($user) {
            return $user->roles->first()->slug == 'lecturer';
        });

        Gate::define('isSupervisor', function ($user) {
            return $user->roles->first()->slug == 'supervisor';
        });

        Gate::define('isUser', function ($user) {
            return $user->roles->first()->slug == 'user';
        });
        
    }
}
