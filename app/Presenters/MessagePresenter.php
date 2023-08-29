<?php

namespace App\Presenters;

class MessagePresenter
{
    public function successMessage($key)
    {
        $messages = [
            'invitation_sent' => '招待が完了しました。',
            'community_join' => 'コミュニティへの参加が完了しました。'
        ];

        return $messages[$key] ?? '操作が完了しました。';
    }
}