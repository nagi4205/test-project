<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityInvitation;
use App\Presenters\MessagePresenter;
use App\Jobs\SendCommunityInvitationNotificationJob;
use App\Jobs\SendRepliedCommunityInvitationNotificationJob;


class CommunityInvitationController extends Controller
{
    public function __construct(MessagePresenter $messagePresenter) {
        $this->messagePresenter = $messagePresenter;
    }

    public function show(Community $community) {
        $followingUsers = auth()->user()->followingUsers()->get();
        return view('communities.invitations.index', compact('followingUsers', 'community'));
    }

    public function store(Request $request) {
        $actionType = $request->input('action_type');

        switch ($actionType) {
            case 'invite':
                $validated = $request->validate([
                    'community_id' => 'required|integer|exists:communities,id', // communitiesテーブルに存在するIDかを確認
                    'invitee_id' => 'required|integer|exists:users,id' // usersテーブルに存在するIDかを確認
                ]);
        
                $validated['inviter_id'] = auth()->id();
                // community_membersテーブルにデータを保存（具体的な保存方法は、このテーブルのモデルや設定による）
                CommunityInvitation::create($validated);
        
                SendCommunityInvitationNotificationJob::dispatch($validated['invitee_id'], $validated['inviter_id'], $validated['community_id']);
                
                $message = $this->messagePresenter->successMessage('invitation_sent');
                
                // 保存後のリダイレクトやレスポンスを返す（例: コミュニティ詳細ページにリダイレクト）
                return redirect()->route('communities.show', $validated['community_id'])->with('success', $message);

            case 'join':
                $validated = $request->validate([
                    'community_id' => 'required|integer|exists:communities,id',
                    'inviter_id' => 'required|integer|exists:users,id',
                ]);

                CommunityMember::create([
                    'community_id' => $validated['community_id'],
                    'user_id' => auth()->id(),
                    'joined_at' => CommunityMember::currentTimestamp(),
                ]);
                CommunityInvitation::where('invitee_id', auth()->id())
                                   ->where('community_id', $validated['community_id'])
                                   ->delete();

                $notification_id = $request->input('notification_id');
                $validated['invitee_id'] = auth()->id();

                SendRepliedCommunityInvitationNotificationJob::dispatch($validated['inviter_id'], $validated['invitee_id'], $validated['community_id']);

                $notification = $request->user()->customNotifications()->where('id', $request->input('notification_id'))->first();
                if ($notification) {
                    $notification->delete();
                }

                $message = $this->messagePresenter->successMessage('community_join');
    
                return redirect()->route('communities.show', $validated['community_id'])->with('success', $message);
    
            default:
                return redirect()->back()->with('error', '無効な操作です。');
        }
    }
}
