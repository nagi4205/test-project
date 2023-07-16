<?php

namespace App\Providers;

//デフォルトではGateのUse宣言がコメントアウトされている。Gateを使う場合はコメントアウトを消す。
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
        // 'test'がGateの名前
        Gate::define('test', function (User $user) {
            if($user->id === 1) {
                return true;
            }
            return false;
        });

        Gate::define('isAdmin', function(User $user) {
            return $user->role == 'admin';
        });

        // Gate::define('update-post', [PostPolicy::class, 'update']);
    }
}
