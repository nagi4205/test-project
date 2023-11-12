<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\AuthenticatedSessionController;
use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\TestApiController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('register', [RegisteredUserController::class, 'store']);


Route::get('/profile', function() {
    Log::info('/profileまできた');
    $auth = auth()->user();
    $auth->image = $auth->profile_image ? Storage::url($auth->profile_image) : null;


    return response()->json([
        'user' => [
            'id' => $auth->id,
            'name' => $auth->name,
            'email' => $auth->email,
            'profile_image' => $auth->image,
        ]
    ]);
});

// Route::get('users', function () {
//     if (Auth::check()) {
//         // ユーザーは認証されています。
//         Log::info('ユーザーは承認されています。toire');
//         $user = User::all();
//         return response()->json($user);
//     }
//     Log::info('承認されていません。');
//     return response()->json('だめ！');
// });

Route::middleware('auth:sanctum')->get('users', function () {
         return User::all();
});

Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);
Route::delete('posts/{post}', [PostController::class, 'destroy']);
Route::put('posts/{post}', [PostController::class, 'update']);

Route::get('/ping', function() {
    return response()->json(['message' => 'pong'], 200);
});

Route::middleware('auth:sanctum')->post('/likes', [LikeController::class, 'store'])->name('likes.store');

// Route::post('/likes', function() {
//     return response()->json("masahiro");
// });

// テストすぐ消す
Route::get('readUsersTable', [TestApiController::class, 'readUsersTable']);
Route::post('location', [LocationController::class, 'store']);
