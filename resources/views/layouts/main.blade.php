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


    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


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
    <style>
        /* CSS untuk tampilan cetakan */
        @media print {

            /* Menyembunyikan elemen-elemen yang tidak perlu dicetak */
            .hide-on-print {
                display: none;
            }
        }
    </style>
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
                                data-bs-toggle="dropdown" aria-expanded="true">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/stok-barang" class="nav-link @yield('DataBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Stok Barang</a>
                                <a href="/stok-bahan" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Stok
                                    Bahan</a>
                                <a href="/stock-opname" class="nav-link @yield('StockOpname')"><i
                                        class="fa fa-file me-2"></i>Stock Opname</a>

                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="dataMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="true">Data</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="dataDropdownMenu">

                                <a href="/data-bahan" class="nav-link @yield('DataBahan')"><i
                                        class="fa fa-file me-2"></i>Data
                                    Bahan</a>

                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="menuTransaksiDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false">Menu & Transaksi</a>
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
                                data-bs-toggle="dropdown" aria-expanded="true">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/stok-barang" class="nav-link @yield('DataBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Stok Barang</a>
                                <a href="/stok-bahan" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Stok
                                    Bahan</a>
                                <a href="/stock-opname" class="nav-link @yield('StockOpname')"><i
                                        class="fa fa-file me-2"></i>Stock Opname</a>

                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="dataMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="true">Data</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="dataDropdownMenu">

                                <a href="/data-bahan" class="nav-link @yield('DataBahan')"><i
                                        class="fa fa-file me-2"></i>Data
                                    Bahan</a>

                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="menuTransaksiDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false">Menu & Transaksi</a>
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
                                data-bs-toggle="dropdown" aria-expanded="true">Stok</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="stokDropdownMenu">
                                <a href="/stok-barang" class="nav-link @yield('DataBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Stok Barang</a>
                                <a href="/stok-bahan" class="nav-link @yield('StokBahan')"><i
                                        class="fa fa-file me-2"></i>Stok
                                    Bahan</a>
                                <a href="/stock-opname" class="nav-link @yield('StockOpname')"><i
                                        class="fa fa-file me-2"></i>Stock Opname</a>

                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="dataMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="true">Data</a>
                            <div class="dropdown-menu bg-transparent border-0 " id="dataDropdownMenu">

                                <a href="/data-bahan" class="nav-link @yield('DataBahan')"><i
                                        class="fa fa-file me-2"></i>Data
                                    Bahan</a>

                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="menuTransaksiDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="false">Menu & Transaksi</a>
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
    <!-- jQuery (wajib sebelum DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- tambahanku -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="vendor/select2/dist/js/select2.min.js"></script>

    <!-- Template Javascript -->
    <!-- Template Javascript -->
    <script src="{{ url('js/main.js')}}"></script>
    <!-- JavaScript Libraries -->
    <script src="{{ url('js/jquery-3.4.1.min.js')}}"></script>
    <!-- ... (other script tags) -->

    <script>
        const currentUrl = window.location.pathname;

        if (currentUrl.includes('/stok-barang') || currentUrl.includes('/stok-bahan') || currentUrl.includes('/stock-opname')) {
            document.getElementById('stokDropdownMenu').classList.add('show');
        }
        if (currentUrl.includes('/data-bahan')) {
            document.getElementById('dataDropdownMenu').classList.add('show');
        }
        if (currentUrl.includes('/daftar-menu') || currentUrl.includes('/transaksi')) {
            document.getElementById('menuTransaksiDropdownMenu').classList.add('show');
        }
        if (currentUrl.includes('/admin-only/log') || currentUrl.includes('/admin-only/user-data')) {
            document.getElementById('lainnyaDropdownMenu').classList.add('show');
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Cari atau pilih satuan",
                allowClear: true
            });

            $(document).on('click', '.btn_editbahan', function () {
                var satuan_id = $(this).data('satuan_id');
                $("#satuan_id").val(satuan_id).trigger('change'); 
            });
        });
    </script>

    <script>
        document.querySelectorAll("#jumlah, #txtjumlah, #txtminimum, #minimum").forEach(function (input) {
            input.addEventListener("keydown", function (e) {
                if (e.key === "ArrowUp") {
                    e.preventDefault();
                    this.value = (parseFloat(this.value) || 0) + 1;
                } else if (e.key === "ArrowDown") {
                    e.preventDefault();
                    this.value = (parseFloat(this.value) || 0) - 1;
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.btn_editbarang', function (e) {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var jumlah = $(this).data('jumlah');
            var satuan_id = $(this).data('satuan_id');
            var image = $(this).data('image');

            console.log(id, name, description, jumlah, satuan_id, image);

            var formattedJumlah = (jumlah % 1 === 0) ? parseInt(jumlah) : jumlah;

            $("#txtid").val(id);
            $("#txtname").val(name);
            $("#txtdescription").val(description);
            $("#txtjumlah").val(formattedJumlah);
            $("#txtsatuan_id").val(satuan_id);

            if (image) {
                $("#previewImage").attr("src", "/storage/" + image).show();
            } else {
                $("#previewImage").hide();
            }

            $("#editBarangModal").modal('toggle');
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.btn_editbahan', function (e) {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var minimum = $(this).data('minimum');
            var satuan_id = $(this).data('satuan_id');

            if (!description || description.trim() === "") {
                description = "-";
            }

            console.log(id, name, description, minimum, satuan_id);

            var formattedMinimum = (minimum % 1 === 0) ? parseInt(minimum) : minimum;

            $("#txtid").val(id);
            $("#txtname").val(name);
            $("#txtdescription").val(description);
            $("#txtminimum").val(formattedMinimum);
            $("#txtsatuan_id").val(satuan_id);

            $("#editBarangModal").modal('toggle');
        });

    </script>
    <script type="text/javascript">
        $(document).on('click', '.btn_editstokbahan', function (e) {
            var id = $(this).data('id');
            var date = $(this).data('date');
            var jumlah = $(this).data('jumlah');
            var satuan_name = $(this).data('satuan_name');

            console.log(id, date, jumlah, satuan_name);

            var formattedJumlah = (jumlah % 1 === 0) ? parseInt(jumlah) : jumlah;

            $("#txtid").val(id);
            $("#txtdate").val(date);
            $("#txtjumlah").val(formattedJumlah);

            $("#txtsatuan_name").val(satuan_name);

            $("#editBarangModal").modal('toggle');
        });

    </script>
    <script type="text/javascript">
        $(document).on('click', '.btn_editbahan_akhir', function (e) {
            var id = $(this).data('id');
            var date = $(this).data('date');
            var bahan_id = $(this).data('bahan_id');
            var jumlah = $(this).data('jumlah');

            console.log(id, name, description, minimum, satuan_id);
            var formattedJumlah = (jumlah % 1 === 0) ? parseInt(jumlah) : jumlah;

            $("#txtid").val(id);
            $("#txtdate").val(date);
            $("#txtbahan_id").val(bahan_id);
            $("#txtjumlah").val(formattedJumlah);

            $("#editBarangModal").modal('toggle');
        });

    </script>
    <script>
        function toggleInput(inputId, buttonId) {
            let inputField = document.getElementById(inputId);
            let button = document.getElementById(buttonId);

            if (inputField.readOnly) {
                inputField.readOnly = false;

                button.style.display = "none"; 
                inputField.focus(); 
                inputField.select();
                
                inputField.addEventListener('focusout', function lockInput() {
                    inputField.readOnly = true;
                    button.style.display = "inline"; 
                    inputField.removeEventListener('focusout', lockInput);
                });
            }
        }

        document.getElementById('toggleMinimum').addEventListener('click', function () {
            toggleInput('minimum', 'toggleMinimum');
        });

        document.getElementById('toggleMinimum2').addEventListener('click', function () {
            toggleInput('txtminimum', 'toggleMinimum2');
        });


    </script>
    <script>
        document.querySelectorAll('input[type="number"].number0').forEach(function (input) {
            input.addEventListener("focusout", function () {
                if (this.value.trim() === "") {
                    this.value = "0"; 
                }
            });
        });

        document.querySelectorAll(".number0").forEach(function (inputField) {
            inputField.addEventListener("focus", function () {
                this.select(); 
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            const bahanOptionsHtml = $('#bahanOptions select').html();

            function renderBahanRow(index, selectedBahanId = '', jumlah = '', satuan = '') {
                const bahanOptionsTemplate = document.querySelector('#bahanOptions select');
                const bahanSelect = bahanOptionsTemplate.cloneNode(true);
                bahanSelect.name = `bahan[${index}][id]`;
                bahanSelect.classList.add('bahan-dropdown');

                if (selectedBahanId) {
                    Array.from(bahanSelect.options).forEach(option => {
                        if (option.value == selectedBahanId) {
                            option.selected = true;
                        }
                    });
                }

                function formatJumlah(jumlah) {
                    if (!jumlah) return ''; 
                    const num = parseFloat(jumlah);
                    return Number.isInteger(num) ? num.toString() : num.toFixed(3).replace(/\.?0+$/, '');
                }

                const jumlahInput = document.createElement('input');
                jumlahInput.type = 'number';
                jumlahInput.name = `bahan[${index}][jumlah]`;
                jumlahInput.placeholder = 'Jumlah';
                jumlahInput.required = true;
                jumlahInput.step = '0.001';
                jumlahInput.className = 'form-control';
                jumlahInput.value = formatJumlah(jumlah);

                const satuanInput = document.createElement('input');
                satuanInput.type = 'text';
                satuanInput.name = `bahan[${index}][satuan]`;
                satuanInput.placeholder = 'Satuan';
                satuanInput.className = 'form-control satuan-input';
                satuanInput.required = true;
                satuanInput.disabled = true;
                satuanInput.value = satuan;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger removeBahan';
                removeBtn.textContent = '-';

                const row = document.createElement('div');
                row.className = 'input-group mb-2 bahan-item';
                row.appendChild(bahanSelect);
                row.appendChild(jumlahInput);
                row.appendChild(satuanInput);
                row.appendChild(removeBtn);

                return row;
            }

            function refreshSatuan($container) {
                $container.on('change', '.bahan-dropdown', function () {
                    const satuan = $(this).find('option:selected').data('satuan') || '';
                    $(this).closest('.bahan-item').find('.satuan-input').val(satuan);
                });

                $container.on('click', '.removeBahan', function () {
                    $(this).closest('.bahan-item').remove();
                });
            }

            $('#addBahan').on('click', function () {
                const container = $('#bahanContainer');
                const index = container.find('.bahan-item').length;
                container.append(renderBahanRow(index));
            });

            $('.btn_editmenu').on('click', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const description = $(this).data('description');
                let komposisi = $(this).data('komposisi');

                if (typeof komposisi === 'string') komposisi = JSON.parse(komposisi);
                $('#editMenuForm').attr('action', '/daftar-menu/' + id);
                $('#editMenuId').val(id);
                $('#editMenuName').val(name);
                $('#editMenuDescription').val(description);

                const container = $('#editBahanContainer');
                container.empty();

                komposisi.forEach((item, index) => {
                    const selectedBahanId = item.bahan_id;
                    const jumlah = item.jumlah;
                    const satuan = item.bahan?.satuan?.name || '';

                    const row = renderBahanRow(index, selectedBahanId, jumlah, satuan);
                    container.append(row);
                });


                $('#editBarangModal').modal('show');
            });

            $('#addEditBahan').on('click', function () {
                const container = $('#editBahanContainer');
                const index = container.find('.bahan-item').length;
                container.append(renderBahanRow(index));
            });

            refreshSatuan($('#bahanContainer'));
            refreshSatuan($('#editBahanContainer'));
        });
    </script>

    <script>
        $(document).ready(function () {
            const bahanOptionsTemplate = document.querySelector('#bahanOptions select');

            function renderBahanAwalRow(index) {
                const bahanSelect = bahanOptionsTemplate.cloneNode(true);
                bahanSelect.name = `bahan_awal[${index}][bahan_id]`;
                bahanSelect.classList.add('form-select', 'bahan-dropdown');

                const jumlahInput = document.createElement('input');
                jumlahInput.type = 'number';
                jumlahInput.name = `bahan_awal[${index}][jumlah]`;
                jumlahInput.placeholder = 'Jumlah';
                jumlahInput.required = true;
                jumlahInput.step = '0.001';
                jumlahInput.min = '0.001';
                jumlahInput.className = 'form-control mx-2';
                jumlahInput.style.maxWidth = '120px';

                const satuanInput = document.createElement('input');
                satuanInput.type = 'text';
                satuanInput.placeholder = 'Satuan';
                satuanInput.className = 'form-control satuan-input';
                satuanInput.disabled = true;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger removeBahanAwal';
                removeBtn.textContent = '-';

                const row = document.createElement('div');
                row.className = 'input-group mb-2 bahan-item';
                row.appendChild(bahanSelect);
                row.appendChild(jumlahInput);
                row.appendChild(satuanInput);
                row.appendChild(removeBtn);

                return row;
            }

            function refreshEventListeners($container) {
                $container.on('change', '.bahan-dropdown', function () {
                    const satuan = $(this).find('option:selected').data('satuan') || '';
                    $(this).closest('.bahan-item').find('.satuan-input').val(satuan);
                });

                $container.on('click', '.removeBahanAwal', function () {
                    $(this).closest('.bahan-item').remove();
                });
            }

            $('#addBahanAwal').on('click', function () {
                const container = $('#bahanAwalContainer');
                const index = container.find('.bahan-item').length;
                container.append(renderBahanAwalRow(index));
            });

            refreshEventListeners($('#bahanAwalContainer'));
        });
    </script>
    <script>
        $(document).ready(function () {
            const bahanOptionsTemplate = document.querySelector('#bahanOptions select');

            function renderBahanAkhirRow(index) {
                const bahanSelect = bahanOptionsTemplate.cloneNode(true);
                bahanSelect.name = `bahan_akhir[${index}][bahan_id]`;
                bahanSelect.classList.add('form-select', 'bahan-dropdown');

                const jumlahInput = document.createElement('input');
                jumlahInput.type = 'number';
                jumlahInput.name = `bahan_akhir[${index}][jumlah]`;
                jumlahInput.placeholder = 'Jumlah';
                jumlahInput.required = true;
                jumlahInput.step = '0.001';
                jumlahInput.min = '0.001';
                jumlahInput.className = 'form-control mx-2';
                jumlahInput.style.maxWidth = '120px';

                const satuanInput = document.createElement('input');
                satuanInput.type = 'text';
                satuanInput.placeholder = 'Satuan';
                satuanInput.className = 'form-control satuan-input';
                satuanInput.disabled = true;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger removeBahanAkhir';
                removeBtn.textContent = '-';

                const row = document.createElement('div');
                row.className = 'input-group mb-2 bahan-item';
                row.appendChild(bahanSelect);
                row.appendChild(jumlahInput);
                row.appendChild(satuanInput);
                row.appendChild(removeBtn);

                return row;
            }

            function refreshEventListeners($container) {
                $container.on('change', '.bahan-dropdown', function () {
                    const satuan = $(this).find('option:selected').data('satuan') || '';
                    $(this).closest('.bahan-item').find('.satuan-input').val(satuan);
                });

                $container.on('click', '.removeBahanAkhir', function () {
                    $(this).closest('.bahan-item').remove();
                });
            }

            $('#addBahanAkhir').on('click', function () {
                const container = $('#bahanAkhirContainer');
                const index = container.find('.bahan-item').length;
                container.append(renderBahanAkhirRow(index));
            });

            refreshEventListeners($('#bahanAkhirContainer'));
        });
    </script>

    <script>
        $(document).on('click', '.btn_editbahan_akhir', function () {
            var bahanId = $(this).data('id');
            var modal = $('#editBarangModal');

            $('#editBahanAkhirId').val(bahanId);

            $.ajax({
                url: '/your-endpoint/' + bahanId, 
                method: 'GET',
                success: function (data) {
                    $('#editDate').val(data.date);
                    $('#editBahanAkhirContainer').empty();

                    data.bahans.forEach(function (bahan) {
                        var bahanHtml = `
                            <div class="bahan-row">
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-bold">Bahan</label>
                                    <select class="form-select bahan-select" data-id="${bahan.id}" name="bahans[]">
                                        <option value="${bahan.id}" selected>${bahan.name}</option>
                                    </select>
                                    <label class="form-label text-dark fw-bold">Jumlah</label>
                                    <input type="number" class="form-control bahan-quantity" name="quantities[]" value="${bahan.quantity}" required>
                                    <input type="hidden" name="bahanIds[]" value="${bahan.id}">
                                </div>
                            </div>
                        `;
                        $('#editBahanAkhirContainer').append(bahanHtml);
                    });
                },
                error: function () {
                    alert('Error loading bahan data.');
                }
            });

            modal.modal('show');
        });

        $('#addEditBahanAkhir').click(function () {
            var newRow = `
                <div class="bahan-row">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">Bahan</label>
                        <select class="form-select bahan-select" name="bahans[]">
                            
                        </select>
                        <label class="form-label text-dark fw-bold">Jumlah</label>
                        <input type="number" class="form-control bahan-quantity" name="quantities[]" required>
                    </div>
                </div>
            `;
            $('#editBahanAkhirContainer').append(newRow);
        });

        $('#editBahanAkhir').submit(function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '/your-endpoint/' + $('#editBahanAkhirId').val(),
                method: 'PUT',
                data: formData,
                success: function () {
                    alert('Bahan Akhir successfully updated.');
                    $('#editBarangModal').modal('hide');
                },
                error: function () {
                    alert('Error saving Bahan Akhir.');
                }
            });
        });

    </script>
    <script>
        document.querySelectorAll(".toggle-jumlah").forEach(function (button) {
            button.addEventListener("click", function () {
                let inputField = this.parentElement.querySelector(".jumlah-input");
                let editButton = this.parentElement.querySelector(".toggle-jumlah"); 

                if (inputField.readOnly) {
                    inputField.readOnly = false; 
                    editButton.style.display = "none"; 
                    inputField.focus(); 
                    inputField.select(); 

                    inputField.addEventListener("focusout", function lockInput() {
                        inputField.readOnly = true;
                        editButton.style.display = "inline";
                        inputField.removeEventListener("focusout", lockInput);
                    });
                }
            });
        });
    </script>
    <script>
        function updateSubmitButton() {
            const submitBtn = document.getElementById("submitBtn");
            const allConfirmed = [...document.querySelectorAll(".btn-konfirmasi")].every(button =>
                button.classList.contains("btn-success")
            );

            if (allConfirmed) {
                submitBtn.disabled = false;
                submitBtn.classList.remove("btn-danger");
                submitBtn.classList.add("btn-primary");
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove("btn-primary");
                submitBtn.classList.add("btn-danger");
            }
        }

        document.querySelectorAll(".btn-konfirmasi").forEach(function (button) {
            button.addEventListener("click", function () {
                let row = this.closest("tr");
                let editButton = row.querySelector(".toggle-jumlah");

                if (this.classList.contains("btn-primary")) {
                    this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = '<i class="fa fa-check"></i>';
                        this.classList.remove("btn-primary");
                        this.classList.add("btn-success");
                        this.disabled = false;
                        if (editButton) editButton.style.display = "none"; 
                        updateSubmitButton();
                    }, 500); 
                } else {
                    this.innerHTML = "Konfirmasi";
                    this.classList.remove("btn-success");
                    this.classList.add("btn-primary");
                    if (editButton) editButton.style.display = "inline-block";
                    updateSubmitButton();
                }
            });
        });

        
        document.querySelectorAll(".toggle-jumlah").forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                let inputField = this.previousElementSibling;

                if (inputField.readOnly) {
                    inputField.readOnly = false;
                    inputField.focus();
                    inputField.select(); 

                    
                    inputField.addEventListener("focusout", function lockInput() {
                        inputField.readOnly = true;
                        inputField.removeEventListener("focusout", lockInput);
                    });
                }
            });
        });

        updateSubmitButton();
    </script>
    <script>
        const menuSelect = document.getElementById('menu_id');
        const jumlahInput = document.getElementById('jumlah');
        const komposisiPreview = document.getElementById('komposisiPreview');

        function formatJumlah(jumlah) {
            return jumlah % 1 === 0 ? jumlah : parseFloat(jumlah.toFixed(3));
        }

        function updateKomposisi() {
            const selectedOption = menuSelect.options[menuSelect.selectedIndex];
            const komposisiData = selectedOption.getAttribute('data-komposisi');
            const jumlahPesanan = parseInt(jumlahInput.value) || 1;

            komposisiPreview.innerHTML = '';

            if (komposisiData) {
                const komposisi = JSON.parse(komposisiData);
                komposisi.forEach(item => {
                    const totalJumlah = item.jumlah * jumlahPesanan;
                    const li = document.createElement('li');
                    li.textContent = `${item.bahan.name} - ${formatJumlah(totalJumlah)} ${item.bahan.satuan.name}`;
                    komposisiPreview.appendChild(li);
                });
            }
        }

        menuSelect.addEventListener('change', updateKomposisi);
        jumlahInput.addEventListener('input', updateKomposisi);
    </script>
</body>

</html>