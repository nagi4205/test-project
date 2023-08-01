<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // サイドバーのビューにログイン中のユーザー情報を渡すクロージャを設定
        View::composer('layouts.sidebar', function ($view) {
            // ログイン中のユーザー情報を取得
            $user = Auth::user();
            // ビューにログイン中のユーザー情報を渡す
            $view->with('user', $user);
        });
    }
}
