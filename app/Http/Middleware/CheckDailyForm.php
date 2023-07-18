<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserDailyStatus;

class CheckDailyForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        $today = Carbon::now()->startOfDay();
        $tomorrow = Carbon::now()->addDay(1)->startOfDay();

        if (Carbon::now()->gte(Carbon::createFromTime(9, 0, 0))) {
            $status = UserDailyStatus::where('user_id', $user->id)
                ->whereBetween('created_at', [$today, $tomorrow])
                ->first();

            if (is_null($status)) {
                return redirect()->route('daily_mood.create');
            }
        }

        return $next($request);
    }
}
