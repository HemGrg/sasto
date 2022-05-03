<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
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
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Gate::define('viewWebSocketsDashboard', function ($user = null) {
            return in_array($user->email, [
                'info@user.com',
                'subash@gmail.com'
            ]);
        });

        foreach (get_class_methods(new \App\Policies\AlternativeUserPolicy) as $method) {
            if ($method == 'before') {
                continue;
            }
            Gate::define($method, [\App\Policies\AlternativeUserPolicy::class, $method]);
        }
    }
}
