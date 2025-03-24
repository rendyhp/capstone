<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="/css/Bootstrap.min.css" rel="stylesheet" >

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

</head>
<body class="bg-white">

    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="#">Stock Opname</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white @yield('Barang')" href="barang">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white @yield('UP')" href="up">UP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white @yield('ULP')" href="ulp">ULP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white @yield('transaksi')" href="transaksi">Transaksi</a>
                </li>
            </ul>
        </div>
    </nav>

@yield('container')
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
    

    <!-- Template Javascript -->
    <script src="{{ url('js/main.js')}}"></script>
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
    <script>
       $(document).ready(function () {
        var uniqueOptions = {}; // Objek untuk melacak opsi unik

        // Mendengarkan perubahan pada input pencarian
        $('#searchInput').on('input', function () {
            var keyword = $(this).val();

            // Hapus opsi sebelumnya
            $('#searchResults').empty();

            // Kirim permintaan AJAX ke controller autocomplete
            if (keyword.length > 0) {
                $.ajax({
                    url: '{{ route("transaksi.autocompletePost") }}', // Sesuaikan dengan route Anda
                    method: 'POST', // Sesuaikan dengan metode yang Anda gunakan di controller
                    data: {
                        _token: "{{ csrf_token() }}",
                        cari: keyword
                    },
                    success: function (data) {
                        // Tampilkan hasil autocomplete
                        data.forEach(function (item) {
                            // Periksa apakah opsi sudah ditambahkan
                            if (!uniqueOptions[item.barang_nama]) {
                                $('#searchResults').append('<option value="' + item.barang_nama + '"></option>');
                                uniqueOptions[item.barang_nama] = true; // Tandai opsi sebagai sudah ditambahkan
                            }
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
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
                var keyword = $('#searchInputKeluar').val();

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
        });
    </script>
    <script>
        $(document).ready(function () {
            // Mendengarkan perubahan pada input pencarian
            $('#searchInputKeluar').on('input', function () {
                var keyword = $(this).val();

                // Hapus opsi sebelumnya
                $('#searchResults').empty();

                // Kirim permintaan AJAX ke controller autocomplete
                if (keyword.length > 0) {
                    $.ajax({
                        url: '{{ route("transaksi.autocomplete") }}', // Sesuaikan dengan route Anda
                        method: 'POST', // Sesuaikan dengan metode yang Anda gunakan di controller
                        data: {
                            _token: "{{ csrf_token() }}",
                            cari: keyword
                        },
                        success: function (data) {
                            // Tampilkan hasil autocomplete sebagai pilihan
                            data.forEach(function (item) {
                                $('#searchResults').append('<option value="' + item.barang_code + '">' + item.barang_nama + '</option>');
                            });
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            });

            // Menangani pemilihan item autocomplete
            $('#searchResults').on('click', 'option', function () {
                var selectedValue = $(this).val();
                $('#searchInputKeluar').val(selectedValue);
                $('#searchResults').empty(); // Hapus pilihan setelah memilih
            });
        });
    </script>

    
</body>
</html>
