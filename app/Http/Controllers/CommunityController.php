<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use App\Services\CommunityService;
use Illuminate\Support\Facades\Log;

class CommunityController extends Controller
{
    protected $communityService;

    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communities = Community::all();
        return view('communities.index', compact('communities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:32',
            'description' => 'required|string',
            'community_image' => 'nullable | max:2048 | mimes:jpg,jpeg,png,gif',
            'latitude' => 'nullable | numeric',
            'longitude' => 'nullable | numeric',
            'location_name' => 'nullable',
        ]);

        if ($request->hasFile('community_image')) {
            $currentDateTime = now()->format('Ymd');
            $filename = $currentDateTime.'_'.$request->file('community_image')->getClientOriginalName();
            $path = $request->file('community_image')->storePubliclyAs('images', $filename);
            $validated['community_image'] = $path;
        } else {
            $path = null;
        }

        $validated['status'] = $request->has('status'); 
        $validated['owner_id'] = auth()->id();

        $community = Community::create($validated);
        $community->communityMembers()->attach(auth()->id(), ['joined_at' => CommunityMember::currentTimestamp() ]);

        return redirect()->route('communities.index')->with('success', 'コミュニティが作成されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Community $community)
    {
        $communityPosts = $community->communityPosts()->get();
        $communityMembers = $community->communityMembers()->get();

        $communityAvatarGroup = $this->communityService->getCommunityAvatarGroup($community->id);
        $visibleMembers = $communityAvatarGroup['visible_members'];
    
        $additionalMembersCount = $communityAvatarGroup['additional_members_count'];

        return view('communities.show', compact('community', 'communityPosts', 'communityMembers', 'visibleMembers', 'additionalMembersCount'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
