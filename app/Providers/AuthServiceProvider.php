<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
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
		
		Passport::tokensCan([
			'graph-read' => 'Access tenant user information',
			'graph-write' => 'Update tenant user information',
			'edu-read' 	=> 'Access tenant user educational information',
			'edu-write' => 'Update tenant user educational information',
			'inventory-read' => 'Access tenant invetory information',
			'inventory-write' => 'Update tenant invetory information',
		]);
    }
}
