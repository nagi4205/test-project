<?php

namespace App\Console;

use App\Models\User;
use App\Models\Mood;
use App\Models\UserDailyStatus;
use Illuminate\Support\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Notifications\AttendanceComfirmNotification;
use App\Notifications\RainyMoodWeeklyNotification;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        logger('test', ['file' => __FILE__, 'line' => __LINE__]);
    
        $schedule->call(function () {
        
        $userDailyStatuses = UserDailyStatus::all();
        Log::info($userDailyStatuses);

        $lastWeekStart = Carbon::now()->subDays(7)->startOfDay();
        $lastWeekEnd = Carbon::now()->subDay()->endOfDay();

        // すべてのユーザーに対してループ
        foreach (User::all() as $user) {


            $userMoods = UserDailyStatus::where('user_id', $user->id)
                        ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                        ->get()
                        ->pluck('mood_id');

            Log::info("UserDailyStatus records for user_id={$user->id} between {$lastWeekStart} and {$lastWeekEnd}:", $userMoods->toArray());


            $moodValues = $userMoods->map(function ($moodId) {
                $mood = Mood::find($moodId);
                switch ($mood->mood) {
                    case '晴れ':
                        return 100;
                    case '曇り':
                        return 60;
                    case '雨':
                        return 40;
                    default:
                        return 0;
                }
            });

            Log::info($moodValues);

            $averageMood = $moodValues->average();

            if ($averageMood < 100) {
                Log::info("Sending RainyMoodWeeklyNotification to user_id={$user->id}");
                $user->notify(new RainyMoodWeeklyNotification());
                Log::info("Sent RainyMoodWeeklyNotification to user_id={$user->id}");
            }
        }

        })->everyMinute();
        // ->weekly->sundays()->at('9:00')->description('RainyMoodWeeklyNotification');
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
