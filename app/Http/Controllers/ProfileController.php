<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
   // Show profile page
public function show(): View
{
    $user = auth()->user();

    // Load user products
    $products = $user->products()->latest()->get();

    // Load user posts
    $posts = $user->posts()->latest()->get();

    // Pass all variables to the view
    return view('profile.profile', compact('user', 'products', 'posts'));
}


    // Edit profile page
   public function edit()
{
    $user = auth()->user();
    return view('profile.edit', compact('user'));
}


    // Update profile
    public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'bio' => 'nullable|string|max:500',
        'current_password' => 'required_with:new_password|string',
        'new_password' => 'nullable|string|min:8|confirmed',
    ]);

    $user->name = $request->name;
    $user->username = $request->username;
    $user->bio = $request->bio;

    if ($request->filled('new_password')) {
        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        $user->password = \Hash::make($request->new_password);
    }

    $user->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
}


    // Delete account
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

        return redirect('/');
    }


    // Update avatar
public function updateAvatar(Request $request)
{
    $request->validate([
        'avatar' => 'required|image|max:2048', // max 2MB
    ]);

    $user = auth()->user();

    if ($request->file('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar_path = $path;
        $user->save();
    }

    return redirect()->back()->with('success', 'Avatar updated!');
}

// Update cover
public function updateCover(Request $request)
{
    $request->validate([
        'cover' => 'required|image|max:4096', // max 4MB
    ]);

    $user = auth()->user();

    if ($request->file('cover')) {
        $path = $request->file('cover')->store('covers', 'public');
        $user->cover_path = $path;
        $user->save();
    }

    return redirect()->back()->with('success', 'Cover image updated!');
}





}
