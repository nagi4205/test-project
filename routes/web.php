<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// ->middleware('can:test');
//↑'test'Gateを有効化
// ->middleware('auth'); 
//↑middlewareを使ってログインしないとwelcome.blade.phpを表示できないようにする
//middleware('guest')にすると非ログイン状態でないと表示できないようになる

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//リソースコントローラの導入のためコメントアウト
//投稿処理のルーティング
Route::get('post/create', [PostController::class, 'create'])->middleware(['auth'])->name('post.create');
Route::post('post', [PostController::class, 'store'])->name('post.store');
Route::get('post', [PostController::class, 'index'])->name('post.index');
//個別表示のルーティングP.265
Route::get('post/{post}/show', [PostController::class, 'show'])->name('post.show');
Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::patch('post/{post}', [PostController::class, 'update'])->name('post.update');
Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
//検索画面のルーティング
Route::get('post/search', [PostController::class, 'search'])->name('post.search');

//コメントCRUDのルーティング
// ある投稿に対するコメント作成画面↓
Route::get('post/{post}/comment/create', [CommentController::class, 'create'])->name('comment.create');
Route::post('post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::get('post/{post}/comment/{comment}/show', [CommentController::class, 'show'])->name('comment.show');
Route::get('post/{post}/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
Route::patch('post/{post}/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
Route::delete('post/{post}/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');





//APIの埋め込み画面表示用のルーティング
Route::get('post/api', [PostController::class, 'api'])->name('post.api');
Route::get('post/result', [PostController::class, 'currentLocation'])->name('post.currentLocation');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
