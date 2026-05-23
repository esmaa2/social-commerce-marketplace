@extends('layouts.base')  

@php
  $user = $user ?? auth()->user();
@endphp

<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Profile — {{ config('app.name','NotFbMarketplace') }}</title>

  <style>
    :root{
      --bg:#0c1116;--card:#0f1720;--text:#e6edf3;--muted:#a2b3c5;
      --primary:#14B8A6;--primary-600:#0D9488;--border:rgba(255,255,255,.10);
      --radius:16px;--shadow:0 12px 30px rgba(0,0,0,.35);--font:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Inter,Arial,"Noto Sans",sans-serif;
      --mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
    }
    *{box-sizing:border-box} html,body{height:100%} body{margin:0;color:var(--text);background:var(--bg);font:14px/1.5 var(--font);}
    .page{max-width:1100px;margin:24px auto;padding:0 24px;}
    .profile{background:color-mix(in srgb,var(--card) 92%,black 8%);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;}
    .cover{height:220px;background:#0e1723 center/cover no-repeat;position:relative;}
    .cover--img{background-size:cover;background-position:center;}
    .profile__head{display:grid;grid-template-columns:180px 1fr auto;gap:16px;padding:16px 18px;}
    .avatar{width:140px;height:140px;border-radius:50%;overflow:hidden;border:4px solid #0f1720;margin-top:-70px;position:relative;background:#0b131c;display:grid;place-items:center;}
    .avatar img{width:100%;height:100%;object-fit:cover;}
    .profile__meta{display:flex;flex-direction:column;gap:4px;align-self:end;}
    .profile__name{margin:0;font-size:20px;}
    .profile__user{color:#cfe6dd;font-family:var(--mono);opacity:.85;}
    .profile__stats{display:flex;gap:14px;flex-wrap:wrap;color:#cfe6dd;font-size:13px;}
    .profile__stats strong{color:#e6edf3;}
    .profile__actions{display:flex;gap:10px;justify-self:end;align-self:end;}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 14px;border-radius:12px;border:1px solid transparent;cursor:pointer;font-weight:600;user-select:none;}
    .btn-primary{background:linear-gradient(180deg,var(--primary),var(--primary-600));color:#051d1a;}
    .tabs{display:flex;gap:10px;padding:10px 18px;border-top:1px solid var(--border);border-bottom:1px solid var(--border);background:rgba(255,255,255,.02);justify-content:center;flex-wrap:wrap;}
    .tab{background:transparent;color:#cfe6dd;border:1px solid var(--border);padding:10px 14px;border-radius:999px;cursor:pointer;min-width:120px;}
    .tab.is-active{background: color-mix(in srgb,var(--primary) 18%,transparent);color:#d1faf5;}
    .panel{display:none;padding:18px} .panel.is-active{display:block;}
  </style>
</head>
<body>
<main class="page">
  <section class="profile">

    {{-- Cover --}}
   <div class="cover {{ $user->cover_path ? 'cover--img' : '' }}" 
     @if($user->cover_path) style="background-image:url('{{ asset('storage/' . $user->cover_path) }}')" @endif>

    @auth
    <button class="cover__edit" onclick="document.getElementById('coverInput').click()" title="Change Cover Image">
        ✎
    </button>
    <form method="POST" action="{{ route('profile.update-cover') }}" enctype="multipart/form-data" style="display:none;">
        @csrf
        <input type="file" id="coverInput" name="cover" accept="image/*" onchange="this.form.submit()">
    </form>
    @endauth
</div>


    <div class="profile__head">
<div class="avatar">
    <img src="{{ auth()->user()?->avatar_url ?: asset('images/default-avatar.png') }}" alt="User avatar">
</div>







     <div class="profile__meta">
    <h1 class="profile__name">{{ $user?->name ?? 'User' }}</h1>
    <div class="profile__user">{{ '@'.($user?->username ?? 'username') }}</div>
    
    {{-- Display bio --}}
    @if($user?->bio)
        <div class="profile__bio" style="color: var(--muted); font-size: 14px; margin-top: 4px;">
            {{ $user->bio }}
        </div>
    @endif

    <div class="profile__stats">
        <span><strong>12</strong> Posts</span>
        <span><strong>0</strong> Products</span>
        <span><strong>1,245</strong> Followers</span>
        <span><strong>182</strong> Following</span>
    </div>
</div>


      <div class="profile__actions">
        @auth
<a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        @endauth
        @guest
          <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
        @endguest
      </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs" role="tablist" aria-label="Profile sections">
      <button class="tab is-active" role="tab" aria-selected="true" aria-controls="panel-posts" id="tab-posts">Posts</button>
      <button class="tab" role="tab" aria-selected="false" aria-controls="panel-purchases" id="tab-purchases">Purchases</button>
      <button class="tab" role="tab" aria-selected="false" aria-controls="panel-market" id="tab-market">My Market</button>
    </div>

    <section class="panel is-active" id="panel-posts" role="tabpanel" aria-labelledby="tab-posts">
    @if($posts->isEmpty())
        <p>No posts yet.</p>
    @else
       <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
    @foreach ($posts as $post)
        <div class="card" style="width: 100%; background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: var(--radius, 16px); box-shadow: var(--shadow, 0 12px 30px rgba(0,0,0,.35)); overflow: hidden; display: flex; flex-direction: column; transition: box-shadow 0.3s ease, transform 0.3s ease;">
            
            <!-- Post Image -->
            @if($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" 
                 alt="Post Image" 
                 style="width:100%; height:192px; object-fit:cover; border-bottom: 1px solid var(--border, rgba(255,255,255,.1));"
                 onerror="this.onerror=null;this.src='{{ asset('images/default-post.jpg') }}';">
            @endif

            <div class="card-body" style="padding: 22px 26px 16px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">
                
                <div>
                    <!-- User Info -->
                    <div class="post-user-info" style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                        <img src="{{ $post->user->avatar_path ? asset('storage/' . $post->user->avatar_path) : asset('images/default-avatar.png') }}" 
                             alt="{{ $post->user->name }}" 
                             style="width:36px; height:36px; border-radius:50%; object-fit:cover;">
                        <div style="display:flex; flex-direction:column;">
                            <span style="font-weight:600; color:var(--text)">{{ $post->user->name }}</span>
                            <span style="font-size:12px; color:var(--muted)">{{ '@'.$post->user->username }} • {{ $post->created_at?->diffForHumans() ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <p style="margin:0; color:var(--text); font-size:14px; line-height:1.4; overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:5; -webkit-box-orient:vertical;">
                        {{ $post->content }}
                    </p>
                </div>

                <!-- Actions (optional like product price/view) -->
                <div class="actions" style="margin-top:16px; padding-top:10px; border-top:1px solid var(--border, rgba(255,255,255,.1)); display:flex; justify-content:flex-end; gap:10px;">
                    @auth
                    <a href="#" class="btn btn-primary" style="padding:6px 12px; font-size:13px;">Like</a>
                    <a href="#" class="btn btn-primary" style="padding:6px 12px; font-size:13px;">Comment</a>
                    @endauth
                </div>

            </div>
        </div>
    @endforeach
</div>

        </div>
    @endif
</section>

    <section class="panel" id="panel-purchases" role="tabpanel" aria-labelledby="tab-purchases">
      <p>No purchases yet.</p>
    </section>


     <section class="panel" id="panel-market" role="tabpanel" aria-labelledby="tab-market">
  @if($products->isEmpty())
    <p>No products yet.</p>
  @else
   <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
    @foreach ($products as $product)
        <div class="card" style="width: 100%; height: 420px; background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: var(--radius, 16px); box-shadow: var(--shadow, 0 12px 30px rgba(0,0,0,.35)); overflow: hidden; display: flex; flex-direction: column; transition: box-shadow 0.3s ease, transform 0.3s ease;">

            <!-- Product Image -->
            <img 
                src="{{ $product->image ? asset('images/' . $product->image) : asset('images/default-product.jpg') }}" 
                alt="{{ $product->name }}" 
                style="width: 100%; height: 192px; object-fit: cover; border-bottom: 1px solid var(--border, rgba(255,255,255,.1));"
                onerror="this.onerror=null;this.src='{{ asset('images/default-product.jpg') }}';">
            
            <div class="card-body" style="padding: 22px 26px 16px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <!-- Product Name -->
                    <h3 class="title card-title" style="font-size: clamp(16px, 2.0vw, 18px); margin-bottom: 8px; color: var(--text, #e6edf3); font-weight: 600; line-height: 1.35; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $product->name }}
                    </h3>

                    <!-- Product Description -->
                    <p class="product-description" style="margin: 0; color: var(--text, #e6edf3); overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; max-height: 72px; font-size: 14px; line-height: 1.4;">
                        {{ $product->description }}
                    </p>
                </div>

                <div class="actions d-flex justify-content-between align-items-center" style="margin-top: 16px; padding-top: 10px; border-top: 1px solid var(--border, rgba(255,255,255,.1)); padding-bottom: 15px;">
                    <span class="product-price" style="font-size: 18px; font-weight: 600; color: var(--text, #e6edf3);">
                        ${{ number_format($product->price, 2) }}
                    </span>

                    <!-- View button -->
                    <a href="{{ route('products.show', $product->id) }}" 
                       class="btn btn-primary" 
                       style="background: linear-gradient(180deg, var(--primary, #14B8A6), var(--primary-600, #0D9488)); color: #051d1a; border-color: transparent; padding: 8px 16px; display: inline-flex; align-items: center; gap: 10px; transition: box-shadow 0.3s ease, transform 0.3s ease;">
                        <i class="bi bi-eye"></i> View
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

  @endif
</section>


  </section>
</main>

<script>
  const tabs = document.querySelectorAll('.tab');
  const panels = document.querySelectorAll('.panel');
  tabs.forEach(tab=>{
    tab.addEventListener('click', ()=>{
      const id = tab.getAttribute('aria-controls');
      tabs.forEach(b=>b.classList.toggle('is-active', b===tab));
      panels.forEach(p=>p.classList.toggle('is-active', p.id===id));
    });
  });
</script>
</body>
</html>
