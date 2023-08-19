<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('notifications.notification', ['notifications' => $notifications,]);
    }

    public function fakeIndex()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->orderBy('created_at', 'desc')->paginate(10);
        
        $renderedNotifications = Notification::render($notifications);

        return view('notifications.notification', [
            'notifications' => $notifications,
            'renderedNotifications' => $renderedNotifications
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
