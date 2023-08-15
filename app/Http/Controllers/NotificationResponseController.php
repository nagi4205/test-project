<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationResponse;
use App\Models\Notification;

class NotificationResponseController extends Controller
{
    //いらない？
    public function store(Notification $notification, Request $request) {
        
        $validated = $request->validate([
            'response' => 'required|in:Yes,No',
        ]);

        $response = new NotificationResponse;
        $response->user_id = auth()->id();
        $response->notification_id = $notification->id;
        $response->response = $request->response;
        $response->save();

        $notification->markAsRead();

        return redirect()->route('notification.index');
    }
}
