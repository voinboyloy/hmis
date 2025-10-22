@extends('layouts.app')

@section('title', 'Patient Login')

@section('content')
<div class="wrap auth-wrap">
  <div class="auth-card card">
    <h2>Patient Login</h2>
    <form method="POST" action="{{ route('portal.login.post') }}">
      @csrf
      <label for="identifier">Email or Phone</label>
      <input id="identifier" name="identifier" type="text" required>

      <label for="password">Password</label>
      <input id="password" name="password" type="password" required>

      <button type="submit" class="btn-primary">Sign In</button>
    </form>

    <p class="muted">Don't have an account? Contact the hospital reception to register.</p>
  </div>
</div>
@endsection
