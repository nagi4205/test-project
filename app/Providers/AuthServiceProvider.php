<?php

namespace App\Providers;

//デフォルトではGateのUse宣言がコメントアウトされている。Gateを使う場合はコメントアウトを消す。
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // 'test'がGateの名前
        //$userがどこで定義されているのかわからない。久保さんに
        Gate::define('test', function (User $user) {
            if($user->id === 1) {
                return true;
            }
            return false;
        });
    }
}
