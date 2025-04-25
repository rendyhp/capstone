<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title class="hide-on-print">BdiM's Stock</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ url('css/swap.css') }}" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <!-- <link href="fontawesome/css/all.min.css" rel="stylesheet"> -->
    <link href="{{ url('fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ url('/font/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ url('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ url('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- tambahanku -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ url('css/mycss.css') }}" rel="stylesheet">
</head>

<body>
    <div class="position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary hide-on-print">
                        <p class="fs-5">
                            <img src="/img/logo1.png" style="width: 35px; height: 35px;" class="me-2" alt="Logo">STOCK
                            OPNAME
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
                        <a href="/notification" class="nav-link @yield('Notifikasi')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Notifikasi</a>

                        <li class="nav-header fw-bold fs-5 ms-4 mb-2">Laporan</li>
                        <a href="/laporan" class="nav-link @yield('Laporan')"><i class="fa fa-file me-2"></i>
                            Laporan</a>

                        <div class="nav-item dropdown">
                            <a href="#" id="stokMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-controls="stokMasterDropdown">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/barang/master" class="nav-link @yield('StokBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Barang</a>
                                <a href="/bahan/master" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Bahan</a>
                                <a href="/stock-opname" class="nav-link @yield('StockOpname')"><i
                                        class="fa fa-file me-2"></i>Stock Opname</a>

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
                                <a href="/admin-only/log" class="nav-link @yield('LogActivities')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Log Aktifitas</a>
                                <a href="/admin-only/user-data" class="nav-link @yield('UserData')"><i
                                        class="fa fa-file me-2"></i>Data User</a>
                            </div>
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->role == 'MANAJER')
                        <a href="/dashboard" class="nav-link @yield('Dashboard')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Dashboard</a>
                        <a href="/notification" class="nav-link @yield('Notifikasi')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Notifikasi</a>
                        <div class="nav-item dropdown">
                            <a href="#" id="stokMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-controls="stokMasterDropdown">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/barang/master" class="nav-link @yield('StokBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Barang</a>
                                <a href="/bahan/master" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Bahan</a>
                                <a href="/stock-opname" class="nav-link @yield('StockOpname')"><i
                                        class="fa fa-file me-2"></i>Stock Opname</a>
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
                                <a href="/admin-only/log" class="nav-link @yield('LogActivities')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Log Aktifitas</a>
                                <a href="/admin-only/user-data" class="nav-link @yield('UserData')"><i
                                        class="fa fa-file me-2"></i>Data User</a>
                            </div>
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->role == 'STAF')
                        <a href="/dashboard" class="nav-link @yield('Dashboard')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Dashboard</a>
                        <a href="/report" class="nav-link @yield('Report')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Lapor</a>

                        <div class="nav-item dropdown">
                            <a href="#" id="stokMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false" aria-controls="stokMasterDropdown">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/barang/master" class="nav-link @yield('StokBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Barang</a>
                                <a href="/bahan/master" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Bahan</a>
                                <a href="/stock-opname" class="nav-link @yield('StockOpname')"><i
                                        class="fa fa-file me-2"></i>Stock Opname</a>
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
                    <div class="fs-7 fw-bold ms-4">{{Auth::user()->up_nama}}</div>
                    <div class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
    <script>
    $('#editBarangModal').on('shown.bs.modal', function () {
        $('#id_bahan.select2-hidden-accessible').select2('destroy');
        $('#id_bahan').select2({
            placeholder: "Cari bahan...",
            allowClear: true,
            dropdownParent: $('#editBarangModal')
        });
        

        $('#txtsatuan_id').select2({
            placeholder: "Cari atau pilih satuan...",
            allowClear: true,
            dropdownParent: $('#editBarangModal')
        });

        setTimeout(() => {
            $('.select2-container--open .select2-search__field').focus();
        }, 100);
    });

    $('#barangModal').on('shown.bs.modal', function () {
        $('#satuan_id.select2-hidden-accessible').select2('destroy');
        $('#satuan_id').select2({
            placeholder: "Cari atau pilih satuan...",
            allowClear: true,
            dropdownParent: $('#barangModal')
        });
        $('#menu_id').select2({
            placeholder: "Cari atau pilih menu...",
            allowClear: true,
            dropdownParent: $('#barangModal')
        });

        setTimeout(() => {
            $('.select2-container--open .select2-search__field').focus();
        }, 100);
    });

    $(document).ready(function () {
        $('.select2').select2({
            templateResult: function (state) {
                if (!state.id) return state.text;
                return $(
                    '<span><img src="' + $(state.element).data('image') + '" class="img-flag" style="width: 20px; height: 20px; margin-right: 10px;" /> ' + state.text + '</span>'
                );
            },
            templateSelection: function (state) {
                if (!state.id) return state.text;
                return $(
                    '<span><img src="' + $(state.element).data('image') + '" class="img-flag" style="width: 20px; height: 20px; margin-right: 10px;" /> ' + state.text + '</span>'
                );
            }
        });
    });
</script>


    <script src="{{ url('js/myjs.js')}}"></script>
</body>

</html>