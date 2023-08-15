<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('notifications.notification', [
            'notifications' => $notifications
        ]);
    } 

    public function test()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->paginate(10);

        return view('notifications.test', [
            'notifications' => $notifications
        ]);
    }
}
