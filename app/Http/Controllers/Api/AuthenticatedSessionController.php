<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
///あとで消す↓  
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            $data = $request->session()->all();
            Log::info('AuthenticatedSessionControllerのここまできたよ');
            
            
            $user = Auth::user();
            $user->image = $user->profile_image ? Storage::url($user->profile_image) : null;
            

            Log::info($request->headers);
            
            return response()->json($user);
        }

        return response()->json([], 401);
    }

    // public function store(LoginRequest $request): JsonResponse
    // {

    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $credentials['email'])->first();

    //     if (!$user || !Hash::check($credentials['password'], $user->password)) {

    //         throw ValidationException::withMessages([
    //             'email' => ['The provided credentials are incorrect.'],
    //         ]);
    //     }

    //     $token = $user->createToken('authToken')->plainTextToken;

    //     return response()->json([
    //         'success' => true,
    //         'user' => $user,
    //         'access_token' => $token,
    //         'message' => 'Login successful',
    //     ], Response::HTTP_OK);
    // }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Log::info('api/logoutにアクセスできました。');
        if (Auth::guard('web')->check()) {
            Log::info('l.47:ログアウトしていました。');
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json(['message' => 'ログアウトしていました。']);
        } else {
            return response()->json(['message' => 'ログインしていませんでした。']);
        }
    }
}
