<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', "BdiM’s Stock")</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/img/logo-bdim.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ url('css/swap.css') }}" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="{{ url('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('/font/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ url('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ url('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Tambahanku -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="{{ url('css/mycss.css') }}" rel="stylesheet">
    @stack('addStyle')
</head>

<body>
    <div class="position-relative bg-white d-flex p-0">
        @stack('spinner')


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary hide-on-print">
                        <p class="fs-5">
                            <img src="/img/logo-bdim.png" style="width: 35px; height: 35px;" class="me-2"
                                alt="Logo">BdiM's Stock
                        </p></i>
                    </h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <i class="fa fa-user fs-4 ms-2"></i>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ Auth::user()->name }} </h6>
                        <span>{{ Auth::user()->role }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    @if(Auth::check() && (Auth::user()->role == 'OWNER' || Auth::user()->role == 'MANAJER'))
                        <li class="nav-header fw-bold fs-5 ms-4 mb-2">Setting</li>
                        <a href="/my/profile" class="nav-link @yield('Profile')">Profil</a>
                        @if(Auth::check() && Auth::user()->role == 'OWNER')
                            <a href="/my/set-api-token" class="nav-link @yield('SetApiToken')">Atur Token API</a>
                        @endif
                        <a href="/my/notifikasi-api" class="nav-link @yield('Notifapi')">API Notifikasi</a>
                        <a href="/my/password" class="nav-link @yield('Password')">Ubah Password</a>
                    @endif

                    @if(Auth::check() && Auth::user()->role == 'STAF')
                        <li class="nav-header fw-bold fs-5 ms-4 mb-2">Setting</li>
                        <a href="/my/profile" class="nav-link @yield('Profile')">Profil</a>
                        <a href="/my/password" class="nav-link @yield('Password')">Ubah Password</a>
                    @endif


                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0  hide-on-print"
                style="width: 100%; height: 60px;">
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    @if(Auth::check() && Auth::user()->role == 'STAF')
                        {{-- Tombol Report --}}
                        <button class="btn btn-outline-danger btn-sm me-3" data-bs-toggle="modal"
                            data-bs-target="#reportModal">
                            <i class="fa fa-flag me-1"></i> Report
                        </button>
                    @endif

                    <div class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/dashboard">
                                Dashboard
                            </a>
                            <a class="dropdown-item" href="/" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    @yield('container')
                </div>
            </div>
            <!-- Widgets End -->
            <footer class="bg-gray-200 py-4 me-5 mb-4">
                <p class="text-end text-gray-700 text-sm">
                    &copy;2025 B.di.M Cafe & Chill Mulawarman
                </p>
            </footer>

        </div>
        <!-- Content End -->

        <a href="#" class="back-to-top2 align-items-center justify-content-center"><i
            class="fa-solid fa-arrow-up"></i></a>

        @if(Auth::check() && Auth::user()->role == 'STAF')
            <!-- Modal Report -->
            <!-- Modal Report -->
            <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('send.report') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Form Laporan ke Admin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label class="form-label">Lapor</label>
                                    <select name="kategori" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Barang">Barang</option>
                                        <option value="Bahan">Bahan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alasan</label>
                                    <select name="alasan" class="form-select" required>
                                        <option value="">-- Pilih Alasan --</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="4"
                                        placeholder="Masukkan detail laporan..." required></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Kirim Laporan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endif
    </div>

    <script>
        window.addEventListener('scroll', function () {
            const btn = document.querySelector('.back-to-top2');
            if (window.scrollY > 200) {
                btn.style.display = 'flex';
            } else {
                btn.style.display = 'none';
            }
        });
    </script>
    @stack('addScript')

    <!-- JavaScript Libraries -->
    <script src="{{ url('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ url('lib/chart/chart.min.js')}}"></script>
    <script src="{{ url('lib/easing/easing.min.js')}}"></script>
    <script src="{{ url('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ url('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{ url('lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{ url('lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{ url('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{ url('js/popper.min.js') }} "></script>
    <script src="{{ url('js/bootstrap.min.js')}}"></script>

    <!-- tambahanku -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="vendor/select2/dist/js/select2.min.js"></script>
    <!-- Template Javascript -->
    <script src="{{ url('js/main.js')}}"></script>
    <!-- ... (other script tags) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- My Select2 script-->
    <script src="{{ url('js/myselect2.js')}}"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ url('js/myjs.js')}}"></script>
</body>

</html>