<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDailyStatus;
use App\Models\Mood;

class DailyMoodController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'attendance' => 'required | boolean',
            'mood_id' => 'required | exists:moods,id', 
        ]);
        $validated['user_id'] = auth()->id();
        $user_daily_status = UserDailyStatus::create($validated);
        
        return view('dashboard');
    }

    public function show()
    {
        $moods = Mood::all();

        return view('daily.select_mood', compact('moods'));
    }

    public function test()
    {
        $moods = Mood::all();

        $user_daily_status = UserDailyStatus::find(1);
        $mood = $user_daily_status->mood;
        $moodValue = $mood->mood;

        return view('daily.select_mood', compact(['moods', 'moodValue']));
    }
}
