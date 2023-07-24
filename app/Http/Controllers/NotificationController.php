<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->paginate(10);

        return view('notification.notifications', [
            'notifications' => $notifications
        ]);
    }

    public function index2()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->paginate(10);

        return view('notification/weeklyRainMoodNotification', [
            'notifications' => $notifications
        ]);
    }    

    
}
