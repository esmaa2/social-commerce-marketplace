<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Forgot Password</title>
    <!-- Tailwind (app.css) + page-specific CSS/JS -->
    @vite(['resources/css/login.css'])
</head>
<body>
    <div class="page">
        <!-- Left side - Branding -->
        <aside class="aside">
            <div class="grid"></div>
            <div class="pitch">
                <div class="brand">
                    <div class="logo" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round"/>
              <rect x="4" y="7" width="16" height="14" rx="3" stroke="white" stroke-width="2"/>
            </svg>
                    </div>
                    <span>{{ config('app.name', 'NotFbMarketplace') }}</span>
                </div>
                <h1>Reset Your Password</h1>
                <p class="lead">
                    No worries! Enter your email address and we'll send you a link to reset your password.
                </p>
                <div class="badges">
                    <span class="badge">🔒 Secure Process</span>
                    <span class="badge">⚡ Quick Recovery</span>
                    <span class="badge">📧 Instant Email</span>
                </div>
            </div>
        </aside>

        <!-- Right side - Form -->
        <main class="panel">
            <div class="card">
                <header class="card-head">
                    <h2 class="title">Password Recovery</h2>
                    <p class="subtitle">We'll email you instructions to reset your password</p>
                </header>

                <div class="card-body">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div style="padding: 12px 14px; background: color-mix(in srgb, var(--primary) 15%, transparent); border: 1px solid var(--primary); border-radius: 12px; color: #d1faf5; font-size: 13px; margin-bottom: 16px;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-grid">
                            <label for="email">Email Address</label>
                            <div class="field {{ $errors->get('email') ? 'input-error' : '' }}">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0; opacity:.6">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <path d="m2 7 10 6 10-6"/>
                                </svg>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="your@email.com"
                                    required 
                                    autofocus
                                    autocomplete="email"
                                >
                            </div>

                            @if ($errors->get('email'))
                                <div style="grid-column: 2"></div>
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="actions">
                            <a href="{{ route('login') }}" class="btn btn-ghost">
                                <svg width="20" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                                </svg>
                                Back to Login
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Send Reset Link
                                <svg width="20" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <div class="footer">
                        Remember your password?
                        <a href="{{ route('login') }}">Sign in here</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>