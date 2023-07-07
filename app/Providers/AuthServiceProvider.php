<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\policies\admin;
use App\Models\User;
use App\Models\Perfil;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => admin::class,
        Perfil::class => admin::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('administrador', 'App\Policies\admin@administrador');
        Gate::define('coordenador', 'App\Policies\coord@coordenador');

    }
}
