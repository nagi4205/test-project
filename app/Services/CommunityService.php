<?php

namespace App\Services;

use App\Models\Community;
use App\Models\CommunityMember;

class CommunityService
{
    public function getFilteredCommunitiesByLocation($lat, $lng, $radius)
    {
        return Community::withinEasyDistance($lat, $lng, $radius)
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    public function getCommunityAvatarGroup($communityId)
    {
        $members = Community::find($communityId)->communityMembers()->get();
        
        $maxVisibleMembers = config('community.max_visible_members');
        $visibleMembers = $members->take($maxVisibleMembers);
        $additionalMembersCount = $members->count() - $maxVisibleMembers;

        return [
            'visible_members' => $visibleMembers,
            'additional_members_count' => $additionalMembersCount
        ];
    }
}
