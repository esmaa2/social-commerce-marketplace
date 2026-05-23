@extends('layouts.base')

@section('main_content')
<link rel="stylesheet" href="{{ asset('css/feed.css') }}">

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <h1 style="font-size: clamp(22px, 3.4vw, 32px); margin: 0; color: var(--text, #e6edf3);">
        Social Feed
    </h1>
    <div style="display: flex; gap: 12px; align-items: center;">
        <a href="{{ route('profile.show') }}">
            <img src="{{ auth()->user()->avatar_path ? asset('storage/' . auth()->user()->avatar_path) : asset('images/default-avatar.png') }}" 
                 alt="Profile" 
                 style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--border, rgba(255,255,255,.1)); object-fit: cover;">
        </a>
    </div>
</div>

<div style="display:flex; justify-content: flex-end; align-items:center; margin-bottom:16px;">
    @auth
        <a href="{{ route('feed.create') }}" 
           style="padding:8px 16px; font-weight:600; border-radius:50px; 
                  border: 1px solid var(--border, rgba(255,255,255,.1)); 
                  background: transparent; 
                  color: var(--text, #e6edf3); 
                  text-decoration: none; 
                  transition: all 0.2s ease;">
            + Add Post
        </a>
    @endauth
</div>



<div class="feed-layout">
<div class="feed-container">
    @foreach ($posts as $post)
        <div class="feed-post">
            <div class="feed-post-header">
                <img src="{{ $post->user->avatar_path ? asset('storage/' . $post->user->avatar_path) : asset('images/default-avatar.png') }}" 
                     alt="{{ $post->user->name }}" class="feed-user-avatar">
                <div class="feed-user-info">
                    <span class="feed-username">{{ $post->user->name }}</span>
                    <span class="feed-handle">
                        {{ $post->user->handle }} • {{ $post->created_at ? $post->created_at->diffForHumans() : 'N/A' }}
                    </span>
                </div>
            </div>

            @if($post->image_path)
            <div class="feed-post-image">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image">
            </div>
            @endif

            <div class="feed-post-content">
                <p class="feed-caption">{{ $post->content }}</p>
            </div>

            <!-- Footer INSIDE feed-post -->
            <div class="feed-post-footer">
                <div class="feed-actions">
                    <span class="feed-action"><i class="bi bi-heart"></i> {{ $post->likes_count ?? 0 }}</span>
                    <span class="feed-action"><i class="bi bi-chat"></i> {{ $post->comments_count ?? 0 }}</span>
                    <span class="feed-action"><i class="bi bi-share"></i> {{ $post->shares_count ?? 0 }}</span>
                </div>
                <a href="#" class="btn btn-primary feed-view-btn">View Details</a>
            </div>
        </div>
    @endforeach
</div>


    <!-- Who to Follow Sidebar
    <div class="sidebar-right">
        <div class="who-to-follow">
            <h3 class="who-title">Who to follow</h3>
            @php
                $suggestedUsers = [
                    ['id' => 'JM', 'name' => 'Jessica Miller', 'handle' => 'jessica_m'],
                    ['id' => 'DW', 'name' => 'David Wilson', 'handle' => 'david_w'],
                    ['id' => 'LB', 'name' => 'Lisa Brown', 'handle' => 'lisa_b'],
                ];
            @endphp
            @foreach ($suggestedUsers as $user)
                <div class="follow-item">
                    <div class="follow-initials">{{ $user['id'] }}</div>
                    <div class="follow-info">
                        <span class="follow-name">{{ $user['name'] }}</span>
                        <span class="follow-handle">@{{ $user['handle'] }}</span>
                    </div>
                    <button class="btn-follow">Follow</button>
                </div>
            @endforeach
        </div>
    </div>
</div> -->
@endsection
