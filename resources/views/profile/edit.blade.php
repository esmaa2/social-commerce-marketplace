@php
  $user = $user ?? auth()->user();
@endphp

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Edit Profile — NotFbMarketplace</title>
  <style>
    body {
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Inter, Arial, "Noto Sans", sans-serif;
      background: #0c1116;
      color: #e6edf3;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 40px 20px;
    }

    form {
      background: #111827;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0,0,0,.5);
      width: 100%;
      max-width: 500px;
      display: grid;
      gap: 18px;
    }

    h1 {
      text-align: center;
      color: #14B8A6;
      margin-bottom: 24px;
      font-size: 26px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      font-size: 13px;
      color: #cfe6dd;
    }

    input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid #1f2937;
      background: #0f1720;
      color: #e6edf3;
      font-size: 14px;
    }

    .password-field {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #14B8A6;
      cursor: pointer;
      font-weight: 600;
      font-size: 12px;
    }

    .btn {
      padding: 12px 0;
      border-radius: 12px;
      background: linear-gradient(180deg, #14B8A6, #0D9488);
      color: #051d1a;
      border: none;
      font-weight: 600;
      cursor: pointer;
      font-size: 16px;
      transition: transform 0.2s ease;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    input:focus {
      outline: none;
      border-color: #14B8A6;
      box-shadow: 0 0 0 2px rgba(20,184,166,.3);
    }
  </style>
</head>
<body>
  <form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <label for="name">Full Name</label>
    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}">

    <label for="username">Username</label>
    <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}">

    <label for="bio">Bio</label>
    <input id="bio" name="bio" type="text" value="{{ old('bio', $user->bio) }}">

    <label for="current_password">Current Password</label>
    <input id="current_password" name="current_password" type="password">

    <label for="new_password">New Password</label>
    <input id="new_password" name="new_password" type="password">

    <label for="new_password_confirmation">Confirm New Password</label>
    <input id="new_password_confirmation" name="new_password_confirmation" type="password">

    <button type="submit" class="btn">Save Changes</button>
</form>


  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>
