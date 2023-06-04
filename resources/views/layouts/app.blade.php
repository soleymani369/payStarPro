<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Nunito">
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('bootstrap/css/checkout.css') }}">

  <!-- Scripts -->
</head>

<body style="direction:rtl;text-align:right;">
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        @auth

        <a href="{{ route('user.commodity.orderList') }}" class="navbar-brand">
سبد خرید
        </a>
        @endauth
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarSupportedContent" class="navbar-collapse collapse">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav me-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @guest
              @if (Route::has('login'))
                <li class="nav-item">
                  <a href="{{ route('login') }}"
                     class="nav-link">{{ __('Login') }}</a>
                </li>
              @endif

              @if (Route::has('register'))
                <li class="nav-item">
                  <a href="{{ route('register') }}"
                     class="nav-link">{{ __('Register') }}</a>
                </li>
              @endif
            @else
              <li class="nav-item dropdown">
                <a href="#" id="navbarDropdown"
                   class="nav-link dropdown-toggle" role="button"
                   data-bs-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end"
                     aria-labelledby="navbarDropdown">
                     <a href="http://" target="_blank" rel="noopener noreferrer"></a>
                  <a href="{{ route('logout') }}" class="dropdown-item"
                     onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>

                  <form method="POST" action="{{ route('logout') }}"
                        id="logout-form" class="d-none">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>
    @include('errors.error')

    <main class="py-4">
      @yield('content')
    </main>
  </div>
</body>

</html>
