{{-- resources/views/auth/login.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sign in — {{ config('app.name','Laravel') }}</title>

  {{-- Tailwind (app.css) + page-specific CSS/JS --}}
  @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/css/login.css',
    'resources/js/login.js',
  ])
</head>
<body>
  <main class="page" role="main">
    {{-- Aside / Visual --}}
    <aside class="aside" aria-hidden="true">
      <div class="grid"></div>
      <div class="pitch">
        <div class="brand">
          <div class="logo" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round"/>
              <rect x="4" y="7" width="16" height="14" rx="3" stroke="white" stroke-width="2"/>
            </svg>
          </div>
          {{ config('app.name','NotFbMarketplace') }}
        </div>
        <h1>Welcome back.</h1>
        <p class="lead">Sign in to manage your shop, follow creators, and check out faster.</p>
        <div class="badges">
          <span class="badge">Password protected</span>
          <span class="badge">One account for all</span>
        </div>
      </div>
    </aside>

    {{-- Form side --}}
    <section class="panel">
      <div class="card" role="region" aria-labelledby="login-title">
        <header class="card-head">
          <h2 id="login-title" class="title">Sign in</h2>
          <p class="subtitle">Use your email and password.</p>
        </header>

        <div class="card-body">
          <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="form-grid">
              {{-- Email --}}
              <label for="email">Email</label>
              <div>
                <div class="field @error('email') is-invalid @enderror">
                  <span style="font-family:var(--mono);opacity:.8">@</span>
                  <input id="email" name="email" type="email"
                         placeholder="you@example.com"
                         autocomplete="username"
                         value="{{ old('email') }}" required>
                </div>
                @error('email')<p class="error">{{ $message }}</p>@enderror
              </div>

              {{-- Password --}}
              <label for="password">Password</label>
              <div>
                <div class="field @error('password') is-invalid @enderror">
                  <input id="password" name="password" type="password" autocomplete="current-password" required>
                  <button class="eyebtn" type="button" aria-label="Show password" data-eye="#password">👁</button>
                </div>
                @error('password')<p class="error">{{ $message }}</p>@enderror
              </div>
            </div>

            {{-- Global errors --}}
            @if ($errors->any())
              <div class="hint" style="color:#ff7a85">Please check the highlighted fields.</div>
            @endif

            <div class="row-minor">
              <label style="display:flex;gap:8px;align-items:center">
                <input type="checkbox" name="remember"> Remember me
              </label>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
              @endif
            </div>

            <div class="actions">
              <button class="btn btn-primary" type="submit" id="loginBtn">Sign in</button>
            </div>
          </form>

          <div class="footer">
            <span>New here?</span>
            <a href="{{ route('register') }}">Create your account</a>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>