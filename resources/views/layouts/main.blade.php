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
                    @if(Auth::check() && Auth::user()->role == 'OWNER')
                        <a href="/dashboard" class="nav-link @yield('Dashboard')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Dashboard</a>
                        <li class="nav-header fw-bold fs-5 ms-4 mb-2">Laporan</li>
                        <a href="/laporan" class="nav-link @yield('Laporan')"><i class="fa fa-file me-2"></i>
                            Laporan</a>

                        <div class="nav-item dropdown">
                            <a href="#" id="stokMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-controls="stokMasterDropdown">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/barang/manajemen-barang" class="nav-link @yield('StokBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Barang</a>
                                <a href="/bahan/manajemen-bahan" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Bahan</a>
                            </div>
                        </div>


                        <div class="nav-item dropdown">
                            <a href="#" id="menuTransaksiDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                aria-controls="menuTransaksiDropdownMenu">Menu & Transaksi</a>
                            <div class="dropdown-menu bg-transparent border-0" id="menuTransaksiDropdownMenu">
                                <a href="/daftar-menu" class="nav-link @yield('DaftarMenu')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Daftar Menu</a>
                                <a href="/transaksi" class="nav-link @yield('Transaksi')"><i
                                        class="fa fa-file me-2"></i>Transaksi</a>
                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="lainnyaDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false">Lainnya</a>
                            <div class="dropdown-menu bg-transparent border-0" id="lainnyaDropdownMenu">
                                <a href="/protected/user-data" class="nav-link @yield('UserData')"><i
                                        class="fa fa-file me-2"></i>Data User</a>
                            </div>
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->role == 'MANAJER')
                        <a href="/dashboard" class="nav-link @yield('Dashboard')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Dashboard</a>
                        <li class="nav-header fw-bold fs-5 ms-4 mb-2">Laporan</li>
                        <a href="/laporan" class="nav-link @yield('Laporan')"><i class="fa fa-file me-2"></i>
                            Laporan</a>

                        <div class="nav-item dropdown">
                            <a href="#" id="stokMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-controls="stokMasterDropdown">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/barang/manajemen-barang" class="nav-link @yield('StokBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Barang</a>
                                <a href="/bahan/manajemen-bahan" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Bahan</a>
                            </div>
                        </div>


                        <div class="nav-item dropdown">
                            <a href="#" id="menuTransaksiDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                aria-controls="menuTransaksiDropdownMenu">Menu & Transaksi</a>

                            <div class="dropdown-menu bg-transparent border-0" id="menuTransaksiDropdownMenu">
                                <a href="/daftar-menu" class="nav-link @yield('DaftarMenu')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Daftar Menu</a>
                                <a href="/transaksi" class="nav-link @yield('Transaksi')"><i
                                        class="fa fa-file me-2"></i>Transaksi</a>
                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="lainnyaDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false">Lainnya</a>
                            <div class="dropdown-menu bg-transparent border-0" id="lainnyaDropdownMenu">
                                <a href="/protected/user-data" class="nav-link @yield('UserData')"><i
                                        class="fa fa-file me-2"></i>Data User</a>
                            </div>
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->role == 'STAF')
                        <a href="/dashboard" class="nav-link @yield('Dashboard')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Dashboard</a>
                        <div class="nav-item dropdown">
                            <a href="#" id="stokMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-controls="stokMasterDropdown">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/barang/manajemen-barang" class="nav-link @yield('StokBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Barang</a>
                                <a href="/bahan/manajemen-bahan" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Bahan</a>
                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="menuTransaksiDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                aria-controls="menuTransaksiDropdownMenu">Menu & Transaksi</a>
                            <div class="dropdown-menu bg-transparent border-0" id="menuTransaksiDropdownMenu">
                                <a href="/daftar-menu" class="nav-link @yield('DaftarMenu')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Daftar Menu</a>
                                <a href="/transaksi" class="nav-link @yield('Transaksi')"><i
                                        class="fa fa-file me-2"></i>Transaksi</a>
                            </div>
                        </div>
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
                            <a class="dropdown-item" href="/my">
                                Setting
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

        </div>
        <!-- Content End -->
    </div>

    @if(Auth::check() && Auth::user()->role == 'STAF')
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

                            <!-- Kategori -->
                            <label class="form-label">Lapor</label>
                            <div class="mb-3 d-flex gap-3">
                                <div>
                                    <input type="radio" name="kategori" value="Barang" id="kategori_barang" required>
                                    <label for="kategori_barang">Barang</label>
                                </div>
                                <div>
                                    <input type="radio" name="kategori" value="Bahan" id="kategori_bahan">
                                    <label for="kategori_bahan">Bahan</label>
                                </div>
                                <div>
                                    <input type="radio" name="kategori" value="Lainnya" id="kategori_lainnya">
                                    <label for="kategori_lainnya">Lainnya</label>
                                </div>
                            </div>
                            <div class="mb-3" id="input_kategori_lainnya" style="display: none;">
                                <input type="text" name="kategori_lainnya" class="form-control"
                                    placeholder="Isi kategori lainnya" autocomplete="off">
                            </div>

                            <!-- Alasan -->
                            <label class="form-label">Alasan</label>
                            <div class="mb-3 d-flex gap-3">
                                <div>
                                    <input type="radio" name="alasan" value="Rusak" id="alasan_rusak" required>
                                    <label for="alasan_rusak">Rusak</label>
                                </div>
                                <div>
                                    <input type="radio" name="alasan" value="Lainnya" id="alasan_lainnya">
                                    <label for="alasan_lainnya">Lainnya</label>
                                </div>
                            </div>
                            <div class="mb-3" id="input_alasan_lainnya" style="display: none;">
                                <input type="text" name="alasan_lainnya" class="form-control"
                                    placeholder="Isi alasan lainnya" autocomplete="off">
                            </div>

                            <!-- Keterangan -->
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

        <script>
            const kategoriRadios = document.querySelectorAll('input[name="kategori"]');
            const alasanRadios = document.querySelectorAll('input[name="alasan"]');

            kategoriRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const input = document.getElementById('input_kategori_lainnya');
                    input.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });
            });

            alasanRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const input = document.getElementById('input_alasan_lainnya');
                    input.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });
            });
        </script>
    @endif

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