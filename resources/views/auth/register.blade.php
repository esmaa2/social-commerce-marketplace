{{-- Custom full-page register (Blade) --}}
<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Create Account — {{ config('app.name','Laravel') }}</title>

  {{-- Vite assets (app) + page-specific CSS/JS --}}
  @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/css/register.css',
    'resources/js/register.js',
  ])
</head>
<body>
<main class="page" role="main">
    <!-- VISUAL / BRAND SIDE -->
    <aside class="aside" aria-hidden="true">
      <div class="grid"></div>
      <div class="pitch">
        <div class="brand">
          <div class="logo" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round"/>
              <rect x="4" y="7" width="16" height="14" rx="3" stroke="white" stroke-width="2"/>
            </svg>
          </div>
          NotFbMarketplace
        </div>
        <h1>Join the community. Shop smarter. Sell faster.</h1>
        <p class="lead">One account for everything. Create your profile and start today.</p>
        <div class="badges">
          <span class="badge">Fast onboarding</span>
          <span class="badge">Social profile</span>
          <span class="badge">Shop & chat</span>
        </div>
      </div>
    </aside>

    <!-- FORM SIDE -->
    <section class="panel">
      <div class="card" role="region" aria-labelledby="signup-title">
        <header class="card-head">
          <h2 id="signup-title" class="title">Create your account</h2>
          <p class="subtitle">Just the essentials.</p>
        </header>

        <div class="card-body">
          {{-- Server-side global errors (optional) --}}
          @if ($errors->any())
            <div class="error" role="alert" style="margin-bottom:10px">
              {{ __('There were some problems with your input.') }}
            </div>
          @endif

          <form id="signupForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- Hidden field that will be filled with "first last" before submit --}}
            <input type="hidden" name="name" id="full_name">

            <div class="form-grid">
              <!-- First name -->
              <label for="first">First name</label>
              <div>
                <div class="field @error('first_name') input-error @enderror">
                  <input id="first" name="first_name" type="text" autocomplete="given-name" placeholder="Sara" value="{{ old('first_name') }}" required />
                </div>
                @error('first_name') <p class="error">{{ $message }}</p> @enderror
              </div>

              <!-- Last name -->
              <label for="last">Last name</label>
              <div>
                <div class="field @error('last_name') input-error @enderror">
                  <input id="last" name="last_name" type="text" autocomplete="family-name" placeholder="Ali" value="{{ old('last_name') }}" required />
                </div>
                @error('last_name') <p class="error">{{ $message }}</p> @enderror
              </div>

              <!-- Username (optional for backend) -->
           <!-- Username (now required) -->
<label for="username">Username</label>
<div>
  <div class="field @error('username') input-error @enderror">
    <span style="font-family:var(--mono);opacity:.8">@</span>
    <input id="username" name="username" type="text" inputmode="latin"
           pattern="^[a-zA-Z0-9_\.]{3,18}$" placeholder="sara.ali"
           autocomplete="username" value="{{ old('username') }}"
           required aria-required="true" />
  </div>
  <p class="hint">3–18 chars: letters, numbers, underscores, dots</p>
  @error('username') <p class="error">{{ $message }}</p> @enderror
</div>


              <!-- Email -->
              <label for="email">Email</label>
              <div>
                <div class="field @error('email') input-error @enderror">
                  <input id="email" name="email" type="email" placeholder="you@example.com" autocomplete="email" value="{{ old('email') }}" required />
                </div>
                @error('email') <p class="error">{{ $message }}</p> @enderror
              </div>

              <!-- Password -->
              <label for="password">Password</label>
              <div>
                <div class="field @error('password') input-error @enderror">
                  <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" required />
                  <button class="eyebtn" type="button" aria-label="Show password" data-eye="#password">👁</button>
                </div>
                <p class="hint">Use 8+ characters with a mix of letters &amp; numbers.</p>
                @error('password') <p class="error">{{ $message }}</p> @enderror
              </div>

              <!-- Confirm Password -->
              <label for="password_confirmation">Confirm</label>
              <div>
                <div class="field @error('password_confirmation') input-error @enderror">
                  <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" required />
                  <button class="eyebtn" type="button" aria-label="Show password" data-eye="#password_confirmation">👁</button>
                </div>
                @error('password_confirmation') <p class="error">{{ $message }}</p> @enderror
              </div>
              <!-- Bio (optional) -->
<label for="bio">Bio</label>
<div>
  <div class="field @error('bio') input-error @enderror">
    <textarea id="bio" name="bio" rows="4"
              placeholder="Tell people a little about yourself (max 300 chars)"
              maxlength="300">{{ old('bio') }}</textarea>
  </div>
  <p class="hint">You can add or edit this later in your profile.</p>
  @error('bio') <p class="error">{{ $message }}</p> @enderror
</div>


              <!-- Image upload (optional; controller may ignore if not handled) -->
              <label for="avatar">Profile image</label>
              <div>
                <div class="avatar @error('avatar') input-error @enderror" id="avatarWrap">
                  <div class="preview" id="preview">No image</div>
                  <div>
                    <input id="avatar" name="avatar" type="file" accept="image/png, image/jpeg" />
                    <div class="hint">JPG or PNG, up to ~2 MB. Square works best.</div>
                  </div>
                </div>
                @error('avatar') <p class="error">{{ $message }}</p> @enderror
              </div>
            </div>

            <div class="actions">
              <a class="btn btn-ghost" href="{{ route('login') }}">{{ __('Sign in') }}</a>
              <button class="btn btn-primary" type="submit">{{ __('Create account') }}</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
</body>
</html>