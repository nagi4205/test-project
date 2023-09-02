<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CommunityController extends Controller
{
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
            'description' => 'nullable|string',
        ]);

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
        return view('communities.show', compact('community', 'communityPosts'));
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
