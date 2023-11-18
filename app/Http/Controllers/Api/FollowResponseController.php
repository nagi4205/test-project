<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\FollowResponseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follow;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class FollowResponseController extends Controller
{
    public function store(FollowResponseRequest $request)
    {
        try{
            Log::info('$request:'.$request);
            $followRequest = Follow::where('follower_id', $request->input('follower_id'))
                                    ->where('followee_id', $request->user()->id)
                                    ->firstOrFail();

            $notification = $request->user()->notifications()->where('id', $request->input('notification_id'))
                                    ->firstOrFail();

            if ($request->input('action') == 'approve') {
                $followRequest->status = 'approved';
                $followRequest->save();
            } elseif ($request->input('action') == 'reject') {
                $followRequest->status = 'rejected';
                $followRequest->rejected_at = Carbon::now();
                $followRequest->save();
            }

            Log::info('通知のread_atを更新');
            $notification->markAsRead();
                
            return response()->json('処理が完了しました->'.$followRequest->status);
        } catch(ModelNotFoundException $e) {
           // モデルが見つからない場合の特定の処理
            Log::error('Model not found: ' . $e->getMessage());
            return response()->json(['error' => 'Resource not found.'], 404);
        } catch (\Exception $e) {
            // その他の例外の処理
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
