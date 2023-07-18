<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationResponseController;
use App\Http\Controllers\DailyMoodController;
use Illuminate\Support\Facades\Route;
// あとでけす
use App\Models\User;
// use App\Notifications\AttendanceConfirmation;
// use Illuminate\Notifications\Notification;
use App\Notifications\AttendanceComfirmNotification;
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

// Route::middleware(['auth', 'redirect.if.unread.notifications'])->group(function () {
//     // ここに、認証後に適用されるルートを記述します
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     });
// });

Route::middleware(['dailyForm'])->group(function() {
    Route::resource('post', PostController::class);
    Route::resource('post.comment', CommentController::class);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'redirect.if.unread.notifications'])->name('dashboard');

// あとで消す
Route::get('/test-notification', function () {
    $user = User::find(1);
    $user->notify(new AttendanceComfirmNotification());

    return 'Notification sent!';
});
// あとで消す
Route::get('/test-notifications', function (){
    $users = User::all();
    foreach ($users as $user) {
        $user->notify(new AttendanceComfirmNotification);
    }

    return 'Notification Sent';
});

//構文テスト用
Route::get('test', [TestController::class, 'test']);
Route::get('test', [TestController::class, 'test2']);


Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');

//リソースコントローラの導入のためコメントアウト
//投稿処理のルーティング
// Route::get('post/create', [PostController::class, 'create'])->middleware(['auth'])->name('post.create');
// Route::post('post', [PostController::class, 'store'])->name('post.store');
// Route::get('post', [PostController::class, 'index'])->name('post.index');
// //個別表示のルーティングP.265
// Route::get('post/{post}/show', [PostController::class, 'show'])->name('post.show');
// Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
// Route::patch('post/{post}', [PostController::class, 'update'])->name('post.update');
// Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

// //検索画面のルーティング
// Route::get('post/search', [PostController::class, 'search'])->name('post.search');

//コメントCRUDのルーティング
// ある投稿に対するコメント作成画面↓
// Route::get('post/{post}/comment/create', [CommentController::class, 'create'])->name('comment.create');
// Route::post('post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
// Route::get('post/{post}/comment/{comment}/show', [CommentController::class, 'show'])->name('comment.show');
// Route::get('post/{post}/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
// Route::patch('post/{post}/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
// Route::delete('post/{post}/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');


// routes/web.php

Route::post('notification/{notification}/response', [NotificationResponseController::class, 'store'])->name('notification.response.store');
Route::get('notification/count', [PostController::class, 'count'])->name('notificaiton.count');

//APIの埋め込み画面表示用のルーティング
Route::get('post/api', [PostController::class, 'api'])->name('post.api');
Route::get('post/result', [PostController::class, 'currentLocation'])->name('post.currentLocation');


Route::post('post/{post}/like', [LikeController::class, 'like'])->name('like');
//テスト用にlikes.indexからlikes.testに変更↓
Route::get('/like', [likeController::class, 'index'])->name('like.index');
Route::get('/likes/test', [likeController::class, 'test'])->name('likes.test');

Route::post('daily_select', [DailyMoodController::class, 'store'])->name('daily_mood.store');
Route::get('daily_select', [DailyMoodController::class, 'show'])->name('daily_mood.show');
// テスto
Route::get('daily_test', [DailyMoodController::class, 'test'])->name('daily_mood.test');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
