<?php

namespace App\Providers;

use App\Models\Privilege;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('USER_MANAGER', function (User $user) {
            $privileges = $user->roles->pluck('name')->toArray();
            if(in_array(Privilege::USER_MANAGER, $privileges)){
                return true;
            }
            return false;
        });

        Gate::define('TERM_MANAGER', function (User $user) {
            $privileges = $user->roles->pluck('name')->toArray();
            if(in_array(Privilege::TERM_MANAGER, $privileges)){
                return true;
            }
            return false;
        });

        Gate::define('TERMBASE_MANAGER', function (User $user) {
            $privileges = $user->roles->pluck('name')->toArray();
            if(in_array(Privilege::TERMBASE_MANAGER, $privileges)){
                return true;
            }
            return false;
        });
    }
}
