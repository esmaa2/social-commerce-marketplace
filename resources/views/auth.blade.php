<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Auth — {{ config('app.name', 'Laravel') }}</title>
  <!-- Reference CSS directly from public/css -->
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <!-- Optionally include app.css if it exists -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<main class="page">
  <aside class="aside">
    <div class="grid"></div>
    <div class="pitch">
      <div class="brand">
        <div class="logo">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <rect x="5" y="11" width="14" height="10" rx="2" stroke="white" stroke-width="2"/>
          </svg>
        </div>
        <span>{{ config('app.name', 'Laravel') }}</span>
      </div>
      <h1>Welcome Back</h1>
      <p class="lead">Access your account with your credentials</p>
    </div>
  </aside>

  <section class="panel">
    <!-- Login Card -->
    <div id="loginCard" class="card active-card">
      <div class="card-head">
        <h2 class="title">Login</h2>
        <p class="subtitle">Enter your email and password</p>
      </div>
      <div class="card-body">
        <form id="loginForm" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-grid">
            <label for="email">Email</label>
            <div class="field"><input id="email" type="email" name="email" required></div>
            <label for="password">Password</label>
            <div class="field">
              <input id="password" type="password" name="password" required>
              <button type="button" class="eyebtn" data-eye="#password" aria-label="Show password">👁️</button>
            </div>
          </div>
          <div class="actions">
            <button id="loginBtn" type="submit" class="btn btn-primary">Login</button>
            <button type="button" class="btn btn-ghost" onclick="switchCard('register')">Sign Up</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Register Card -->
    <div id="registerCard" class="card slide-in">
      <div class="card-head">
        <h2 class="title">Sign Up</h2>
        <p class="subtitle">Create a new account</p>
      </div>
      <div class="card-body">
        <form id="signupForm" method="POST" action="{{ route('register') }}">
          @csrf
          <input type="hidden" id="full_name" name="name">
          <div class="form-grid">
            <label for="first">First Name</label>
            <div class="field"><input id="first" name="first_name" type="text" required></div>
            <label for="last">Last Name</label>
            <div class="field"><input id="last" name="last_name" type="text" required></div>
            <label for="email">Email</label>
            <div class="field"><input id="email" name="email" type="email" required></div>
            <label for="password">Password</label>
            <div class="field">
              <input id="passwordReg" name="password" type="password" required>
              <button type="button" class="eyebtn" data-eye="#passwordReg" aria-label="Show password">👁️</button>
            </div>
          </div>
          <div class="actions">
            <button type="submit" class="btn btn-primary">Register</button>
            <button type="button" class="btn btn-ghost" onclick="switchCard('login')">Login</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>
<!-- Reference JS directly from public/js -->
<script src="{{ asset('js/auth.js') }}"></script>
<!-- Optionally include app.js if it exists -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>