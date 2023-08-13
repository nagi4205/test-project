<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\NotificationResponseController;
use App\Http\Controllers\DailyMoodController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use App\Models\Notification; 
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

Route::get('delete_data', function() {
    $targetDate = Carbon::create(2023, 7, 25, 0, 0, 0);
    Notification::where('created_at', '<=', $targetDate)->delete();

    echo '削除しました。';
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['dailyForm'])->group(function() {
    Route::resource('posts', PostController::class);
    Route::resource('post.comment', CommentController::class);
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('fetchposts', [PostController::class, 'fetchposts'])->name('post.fetchposts');

Route::get('/test-notification', function () {
    $user = User::find(1);
    $user->notify(new AttendanceComfirmNotification());

    return 'Notification sent!';
});

Route::get('/test-notifications', function (){
    $users = User::all();
    foreach ($users as $user) {
        $user->notify(new AttendanceComfirmNotification);
    }

    return 'Notification Sent';
});

Route::get('comment/{comment}/reply/create', [CommentController::class, 'replyCreate'])->name('comment.reply.create');
Route::post('comment/{comment}/reply/store', [CommentController::class, 'replyStore'])->name('comment.reply.store');

Route::get('test', [TestController::class, 'test']);
Route::get('test2', [TestController::class, 'test2']);

Route::get('user/{id}/show', [UserController::class, 'show']);
Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('user/{user}/followings', [UserController::class, 'followings'])->name('user.followings');
Route::get('user/{user}/followers', [UserController::class, 'followers'])->name('user.followers');
Route::post('store', [FollowController::class, 'store'])->name('follows.store');
Route::post('follow', [FollowController::class, 'createFollowRequestJob'])->name('follows.createFollowRequestJob');
Route::delete('follow/{user}', [FollowController::class, 'destroy'])->name('follows.destroy');
Route::post('respondToFollowRequest', [FollowController::class, 'respondToFollowRequest'])->name('follows.respondToFollowRequest');



Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
Route::get('/notification2', [NotificationController::class, 'index2'])->name('notification.index2');

Route::get('post/search', [PostController::class, 'search'])->name('post.search');

Route::post('notification/{notification}/response', [NotificationResponseController::class, 'store'])->name('notification.response.store');
Route::get('notification/count', [PostController::class, 'count'])->name('notificaiton.count');

Route::get('post/api', [PostController::class, 'api'])->name('post.api');
Route::get('post/result', [PostController::class, 'currentLocation'])->name('post.currentLocation');


Route::post('likes', [LikeController::class, 'store'])->name('likes.store');
Route::get('/like', [likeController::class, 'index'])->name('like.index');
Route::get('/likes/test', [likeController::class, 'test'])->name('likes.test');

Route::post('daily_select', [DailyMoodController::class, 'store'])->name('daily_mood.store');
Route::get('daily_select', [DailyMoodController::class, 'show'])->name('daily_mood.show');
Route::get('daily_test', [DailyMoodController::class, 'test'])->name('daily_mood.test');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/{user}/store', [ProfileController::class, 'storeProfileImage'])->name('profile.storeImage');

});

require __DIR__.'/auth.php';
