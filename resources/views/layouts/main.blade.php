<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title class="hide-on-print">STOK OPNAME</title>
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

    <!-- Template Stylesheet -->
    <link href="{{url ('css/style.css')}}" rel="stylesheet">
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
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
                        <img src="/img/logo1.png" style="width: 35px; height: 35px;" class="me-2" alt="Logo">STOCK OPNAME</p></i></h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <i class="fa fa-user fs-4 ms-2"></i>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ Auth::user()->name }} </h6>
                        <span>{{ Auth::user()->role }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">  
                    @if(Auth::check() && Auth::user()->role == 'admin')
                        <a href="/dashboard" class="nav-link @yield('Dashboard')"><i class="fa fa-tachometer-alt me-2 mb-2"></i>Dashboard</a>
                        <li class="nav-header fw-bold fs-5 ms-4 mb-2">Data Transaksi</li>
                        <a href="/transaksi" class="nav-link @yield('Transaksi')"><i class="fa fa-credit-card-alt me-2"></i>Transaksi</a>
                        <a href="/report" class="nav-link @yield('Report')"><i class="fa fa-file me-2"></i>Report</a>
                        
                        <div class="nav-item dropdown">
                            <a href="#" id="dataMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2" data-bs-toggle="dropdown" aria-expanded="true">Data Master</a>
                            <div class="dropdown-menu bg-transparent show border-0 ">
                                <a href="/barang" class="dropdown-item nav-link @yield('Barang') "><i class="fa fa-database me-2"></i>Data Barang</a>
                                @if(Auth::user()->unit == '13000')
                                <a href="/up" class="dropdown-item nav-link @yield('UP')"><i class="fa fa-building me-2"></i>Data UP</a>
                                @endif
                                <a href="/ulp" class="dropdown-item nav-link @yield('ULP')"><i class="fa fa-building-shield me-2"></i>Data ULP</a>
                                <a href="/user" class="dropdown-item nav-link @yield('User')"><i class="fa fa-users me-2 mb-2"></i>Data User</a>
                            </div>
                        </div>
                    @endif
                    
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
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
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0  hide-on-print" style="width: 100%; height: 60px;">
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
                            <a class="dropdown-item" href="/"
                                onclick="event.preventDefault();
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    


    <!-- Template Javascript -->
    <!-- Template Javascript -->
    <script src="{{ url('js/main.js')}}"></script>
    <!-- JavaScript Libraries -->
    <script src="{{ url('js/jquery-3.4.1.min.js')}}"></script>
    <!-- ... (other script tags) -->
    
    <script type="text/javascript">
        $(document).on('click', '.btn_editbarang', function(e){
         var id = $(this).data('id');
         var barang_code = $(this).data('kode');
         var barang_nama = $(this).data('nama');
         var barang_merk = $(this).data('merk');
         var barang_jenis = $(this).data('jenis');
         var barang_tipe = $(this).data('tipe');
         var barang_satuan = $(this).data('satuan');
         console.log(id);
         console.log(barang_code);
         console.log(barang_nama);
         console.log(barang_merk);
         console.log(barang_jenis);
         console.log(barang_tipe);
         console.log(barang_satuan);
         $("#editBarangModal").modal('toggle');
         $("#txtid").val(id);
         $("#txtkodebarang").val(barang_code);
         $("#txtnamabarang").val(barang_nama);
         $("#txtmerkbarang").val(barang_merk);
         $("#txtjenisbarang").val(barang_jenis);
         $("#txttipebarang").val(barang_tipe);
         $("#txtsatuan").val(barang_satuan);
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.btn_editUP', function(e){
         var id = $(this).data('id');
         var up_nama = $(this).data('nama');
         var up_alamat = $(this).data('alamat');
         var latitude = $(this).data('latitude');
         var longitude = $(this).data('longitude');
         console.log(id);
         console.log(up_nama);
         console.log(up_alamat);
         console.log(latitude);
         console.log(longitude);
         $("#editUPModal").modal('toggle');
         $("#txtid").val(id);
         $("#txtnamaUP").val(up_nama);
         $("#txtalamatUP").val(up_alamat);
         $("#txtlatitude").val(latitude);
         $("#txtlongitude").val(longitude);

        });
    </script>
    <script type="text/javascript">
    $(document).on('click', '.btn_editULP', function(e){
        var id = $(this).data('id');
        var ulp_nama = $(this).data('nama');
        var ulp_alamat = $(this).data('alamat');
        var ulp_latitude = $(this).data('latitude');
        var ulp_longitude = $(this).data('longitude');
        var up_id = $(this).data('up');
        console.log(id);
        console.log(ulp_nama);
        console.log(ulp_alamat);
        console.log(ulp_latitude);
        console.log(ulp_longitude);
        console.log(up_id);
        $("#editULPModal").modal('toggle');
        $("#txtulp").val(id);
        $("#txtnamaULP").val(ulp_nama);
        $("#txtalamatULP").val(ulp_alamat);
        $("#txtlatitude").val(ulp_latitude);
        $("#txtlongitude").val(ulp_longitude);
        $("#slcup").val(up_id);
    });
    </script>
    <script type="text/javascript">
    $(document).on('click', '.btn_edituser', function(e){
        var id = $(this).data('no');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var password = $(this).data('password');
        var role = $(this).data('role');
        console.log(id);
        console.log(name);
        console.log(email);
        console.log(password);
        console.log(role);
        $("#editUserModal").modal('toggle');
        $("#txtno").val(id);
        $("#txtusername").val(name);
        $("#txtemail").val(email);
        $("#txtpassword").val(password);
        $("#txtrole").val(role);
    });
    </script>
    <script>
       $(document).ready(function () {
        var uniqueOptions = {}; // Objek untuk melacak opsi unik

        // Mendengarkan perubahan pada input pencarian
        // $('#searchInput').on('keyup', function () {
        //     var keyword = $(this).val();
        //     console.log('okok');
        //     // Hapus opsi sebelumnya
        //    // $('#searchResults').empty();
        //    $('#searchResults').append('<option value="ndak bapitih"></option>');
        //     // Kirim permintaan AJAX ke controller autocomplete
        //     if (keyword.length > 0) {
                
        //     }
            
        // });
        $.ajax({
                    url: '{{ route("transaksi.autocomplete") }}', // Sesuaikan dengan route Anda
                    method: 'POST', // Sesuaikan dengan metode yang Anda gunakan di controller
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        // Tampilkan hasil autocomplete
                        data.forEach(function (item) {
                            // Periksa apakah opsi sudah ditambahkan
                            if (!uniqueOptions[item.barang_nama]) {
                                $('#searchResults').append('<option value="' + item.barang_nama + '"></option>');
                                uniqueOptions[item.barang_nama] = true; // Tandai opsi sebagai sudah ditambahkan
                            }
                            console.log(item);
                        });
                       
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

        // Menangani pemilihan item autocomplete
        $('#searchResults').on('click', 'option', function () {
            var selectedValue = $(this).val();
            $('#searchInput').val(selectedValue);
            $('#searchResults').empty(); // Hapus pilihan setelah memilih
        });

        
    });
    </script>

    <script>
        $(document).ready(function () {
            $('#searchButton').on('click', function (e) {
                e.preventDefault();
                var keyword = $('#searchInput').val();

                $.ajax({
                    url: '{{ route("transaksi.inputPost") }}',
                    method: 'POST',
                    data: {
                        _token : "{{ csrf_token() }}",
                        cari: keyword },
                    success: function (data) {
                        console.log(data);
                        // Replace the content of the table with the search results
                        $('#tampilBarang').append(data);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                    
                });
            });
            // Fungsi untuk menghapus baris
            function deleteRow(button) {
                // Dapatkan referensi ke baris yang akan dihapus (elemen <tr>)
                var row = button.closest('tr');

                // Hapus baris dari tabel
                row.remove();
            }

            // Menambahkan event handler untuk tombol "Hapus" dalam tabel
            $('#tampilBarang').on('click', 'button.btn-danger', function () {
                deleteRow(this);
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#searchButtonKeluar').on('click', function (e) {
                e.preventDefault();
                var keyword = $('#searchInput').val();

                $.ajax({
                    url: '{{ route("transaksi.keluarPost") }}',
                    method: 'POST',
                    data: {
                        _token : "{{ csrf_token() }}",
                        cari: keyword },
                    success: function (data) {
                        console.log(data);
                        // Replace the content of the table with the search results
                        $('#tampilBarangKeluar').append(data);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                    
                });
            });
            // Fungsi untuk menghapus baris
            function deleteRow(button) {
                // Dapatkan referensi ke baris yang akan dihapus (elemen <tr>)
                var row = button.closest('tr');

                // Hapus baris dari tabel
                row.remove();
            }

            // Menambahkan event handler untuk tombol "Hapus" dalam tabel
            $('#tampilBarangKeluar').on('click', 'button.btn-danger', function () {
                deleteRow(this);
            });
            // Fungsi untuk membatasi input jumlah berdasarkan stok
            $('#tampilBarangKeluar').on('input', 'input[name="barang_quantity[]"]', function () {
                var input = $(this);
                var stock = parseFloat(input.closest('tr').find('.tdStock').text());
                var quantity = parseFloat(input.val());

                if (quantity > stock) {
                    input.val(stock); // Set nilai input menjadi stok maksimal jika melebihi stok
                }
            });
        });
    </script>
    <script>
    $(document).ready(function(){
        // Aktifkan semua komponen Bootstrap yang memerlukannya
        $('.dropdown-toggle').dropdown();
    });
    </script>
    <script>
        const transaksiPerPageSelect = document.getElementById('transaksi-per-page');
        const tabelTransaksi = document.getElementById('tabeltransaksi'); 

        transaksiPerPageSelect.addEventListener('change', function () {
            const selectedValue = this.value;

            if (selectedValue === "-1") {
          
                for (let i = 0; i < tabelTransaksi.rows.length; i++) {
                    tabelTransaksi.rows[i].style.display = '';
                }
            } else {
               
                const rowsToDisplay = parseInt(selectedValue);
                for (let i = 0; i < tabelTransaksi.rows.length; i++) {
                    if (i < rowsToDisplay) {
                        tabelTransaksi.rows[i].style.display = '';
                    } else {
                        tabelTransaksi.rows[i].style.display = 'none';
                    }
                }
            }
        });
    </script>
    <script>
        const tersediaPerPageSelect = document.getElementById('tersedia-per-page');
        const tabelTersedia = document.getElementById('tabeltersedia');

        tersediaPerPageSelect.addEventListener('change', function () {
            const selectedValue = this.value;

            if (selectedValue === "-1") {
                // Tampilkan semua data
                for (let i = 0; i < tabelTersedia.rows.length; i++) {
                    tabelTersedia.rows[i].style.display = '';
                }
            } else {
                // Tampilkan jumlah data yang dipilih
                const rowsToDisplay = parseInt(selectedValue);
                for (let i = 0; i < tabelTersedia.rows.length; i++) {
                    if (i < rowsToDisplay) {
                        tabelTersedia.rows[i].style.display = '';
                    } else {
                        tabelTersedia.rows[i].style.display = 'none';
                    }
                }
            }
        });
    </script>
    
</body> 
</html>