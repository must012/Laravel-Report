<?php

namespace App\Providers;

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
//        $this->registerPolicies();
//      권한 처리를 위한 부분

        Gate::define('update',function ($user, $model){
            return $user->email === $model->writer;
        });

        Gate::define('delete',function ($user, $model){
            return $user->email === $model->writer;
        });

        Gate::define('comment_update',function ($user, $model){
            return $user->id === $model->user_id;
        });

        //
    }
}
