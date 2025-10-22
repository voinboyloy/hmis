<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'MediCare Hospital')</title>
  <link rel="stylesheet" href="{{ asset('css/hmis.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <header class="site-header">
    <div class="wrap header-inner">
      <a href="{{ url('/') }}" class="brand">Medi<span class="accent">Care</span></a>
      <nav class="main-nav">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/about') }}">About</a>
        <a href="{{ route('portal.login') }}" class="btn-primary">Patient Portal</a>
      </nav>
    </div>
  </header>

  <main class="site-main">
    @yield('content')
  </main>

  <footer class="site-footer">
    <div class="wrap">
      <p>&copy; {{ date('Y') }} MediCare Hospital. Powered by MediCare HMIS.</p>
      <p><a href="/privacy">Privacy Policy</a> | <a href="/terms">Terms</a></p>
    </div>
  </footer>

  <script>
    // small helper to read JSON-encoded messages from session flash
    (function(){
      const flash = @json(session('flash_message'));
      if(flash){
        alert(flash);
      }
    })();
  </script>
  @stack('scripts')
</body>
</html>
