<?php

namespace App\Providers;

use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\UserPolicy;
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
        // 'App\Models\setting' => 'App\Policies\SettingPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('checkAccessAdminPage', function($user) {
            return $user->checkAccessAdminPage();
        });

        Gate::define('setting-view', [SettingPolicy::class, 'view']);
        Gate::define('setting-add', [SettingPolicy::class, 'create']);
        Gate::define('setting-update', [SettingPolicy::class, 'update']);
        Gate::define('setting-delete', [SettingPolicy::class, 'delete']);
        
        Gate::define('slider-view', [SettingPolicy::class, 'view']);
        Gate::define('slider-add', [SettingPolicy::class, 'create']);
        Gate::define('slider-update', [SettingPolicy::class, 'update']);
        Gate::define('slider-delete', [SettingPolicy::class, 'delete']);
        
        Gate::define('user-view', [UserPolicy::class, 'view']);
        Gate::define('user-add', [UserPolicy::class, 'create']);
        Gate::define('user-update', [UserPolicy::class, 'update']);
        Gate::define('user-delete', [UserPolicy::class, 'delete']);

        Gate::define('role-view', [RolePolicy::class, 'view']);
        Gate::define('role-add', [RolePolicy::class, 'create']);
        Gate::define('role-update', [RolePolicy::class, 'update']);
        Gate::define('role-delete', [RolePolicy::class, 'delete']);
    }
}
