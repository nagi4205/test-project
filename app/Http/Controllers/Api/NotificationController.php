<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        Log::info('発火hakka');
        $user = Auth::user();

        Log::info($user);
        $notifications = $user->unreadNotifications()->orderBy('created_at', 'desc')->get();

        // $multipliedNotifications = $notifications->map(function ($notification) {
        //     $notificationData = json_decode($notification->data, true);
        //     $notification->data = $notificationData;
        //     return $notification;
        // });
        
        return response()->json($notifications);
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
