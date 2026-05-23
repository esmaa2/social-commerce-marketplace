<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class FeedController extends Controller
{
    public function index()
    {
        // Fetch posts with the user relationship
        $posts = Post::with('user')->latest()->get();

        // Pass $posts to the Blade
return view('feed', compact('posts'));
    }



    // Show create post form
    public function create()
    {
        return view('post'); // Your Blade form file
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string|max:5000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id'    => auth()->id(),
            'content'    => $request->caption,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('feed.index')->with('success', 'Post created successfully!');
    }
}
