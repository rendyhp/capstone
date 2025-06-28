<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', "B.di.M’s Stock")</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/img/logo-bdim.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ url('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('/font/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- CSS Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}">

    <!-- CSS Main -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('addStyle')


    <!-- =======================================================
  * Template Name: Vesperr
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/vesperr-free-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <h1>
                    <a href="/" class="text-decoration-none text-primary d-flex align-items-center">
                        <img src="/img/logo-bdim.png" style="width: 40px; height: 40px;" class="img-fluid me-2"
                            alt="Logo">
                        B.di.M’s Stock
                    </a>
                </h1>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @auth
                                    <a href="/dashboard" class="dropdown-item">
                                        Dashboard
                                    </a>
                                @endauth

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                    <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header>
    <footer class="bg-gray-200 py-4">
        <p class="text-center text-gray-700 text-sm mb-4">
            &copy;2025 B.di.M | Cafe & Chill Mulawarman
        </p>
    </footer>

    @stack('addScript')
    <script>
        const dropdownToggle = document.getElementById('navbarDropdown');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        let isDropdownOpen = false;

        dropdownToggle.addEventListener('click', function () {
            if (!isDropdownOpen) {
                dropdownMenu.classList.add('show');
                dropdownToggle.setAttribute('aria-expanded', 'true');
                isDropdownOpen = true;
            } else {
                dropdownMenu.classList.remove('show');
                dropdownToggle.setAttribute('aria-expanded', 'false');
                isDropdownOpen = false;
            }
        });
    </script>

</body>
@yield('container')

</html>