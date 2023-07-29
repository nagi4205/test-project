<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function storeProfileImage(Request $request, User $user)
    {   
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $currentDateTime = now()->format('Ymd');
            $filename = $currentDateTime.'_'.$request->file('profile_image')->getClientOriginalName();
            $path = $request->file('profile_image')->storePubliclyAs('images', $filename);

            try {
                DB::beginTransaction();
    
                $isUpdated = $user->update(['profile_image' => $path]);
    
                if ($isUpdated) {
                    DB::commit();
                    return back()->with('success', 'You have successfully upload image.');
                } else {
                    DB::rollback();
                    return back()->with('error', 'Image upload was successful, but failed to update the user profile.');
                }
            } catch (Exception $e) {
                DB::rollback();
                return back()->with('error', 'Failed to update due to a DB error: ' . $e->getMessage());
            }
        }
    
        return back()->with('error', 'No profile image file found.');

    }

}
