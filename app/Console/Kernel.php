<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Notifications\AttendanceComfirmNotification;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        Log::info('Scheduling notifications');

        $schedule->call(function () {
            $users = User::all();
            foreach ($users as $user) {
                // unreadNotification all unread notifications
                if($user->unreadNotifications->isNotEmpty()) {
                    foreach($user->unreadNotifications as $notification) {
                        $notification->markAsRead();
                    }
                }
                // new notification
                $user->notify(new AttendanceComfirmNotification);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
