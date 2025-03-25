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
                        <a href="/report" class="nav-link @yield('Report')"><i
                                class="fa fa-tachometer-alt me-2 mb-2"></i>Lapor</a>
                        <li class="nav-header fw-bold fs-5 ms-4 mb-2">Data</li>
                        <a href="/laporan" class="nav-link @yield('Laporan')"><i class="fa fa-file me-2"></i>
                            Laporan</a>



                        <div class="nav-item dropdown">
                            <a href="#" id="dataMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="true">Stok</a>
                            <div class="dropdown-menu bg-transparent show border-0 ">
                                <a href="/data-barang" class="nav-link @yield('DataBarang')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Data Barang</a>
                                <a href="/data-bahan" class="nav-link @yield('DataBahan')"><i
                                        class="fa fa-file me-2"></i>Data
                                    Bahan</a>
                                <a href="/stock-opname" class="nav-link @yield('StockOpname')"><i
                                        class="fa fa-file me-2"></i>Stock Opname</a>
                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="dataMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="true">Menu & Transaksi</a>
                            <div class="dropdown-menu bg-transparent show border-0 ">
                                <a href="/daftar-menu" class="nav-link @yield('DaftarMenu')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Daftar Menu</a>
                                <a href="/transaksi" class="nav-link @yield('Transaksi')"><i
                                        class="fa fa-file me-2"></i>Transaksi</a>
                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="#" id="dataMasterDropdown" class="nav-link dropdown-toggle fs-5 text-secondary mt-2"
                                data-bs-toggle="dropdown" aria-expanded="true">Lainnya</a>
                            <div class="dropdown-menu bg-transparent show border-0 ">
                                <a href="/admin-only/log" class="nav-link @yield('LogActivities')"><i
                                        class="fa fa-credit-card-alt me-2"></i>Log Aktifitas</a>
                                <a href="/admin-only/user-data" class="nav-link @yield('UserData')"><i
                                        class="fa fa-file me-2"></i>Data User</a>
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
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Cari atau pilih satuan",
                allowClear: true
            });

            $(document).on('click', '.btn_editbahan', function () {
                var satuan_id = $(this).data('satuan_id');
                $("#satuan_id").val(satuan_id).trigger('change'); // Set nilai di Select2
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
            var satuan = $(this).data('satuan');
            var image = $(this).data('image');

            console.log(id, name, description, jumlah, satuan, image);

            var formattedJumlah = (jumlah % 1 === 0) ? parseInt(jumlah) : jumlah;

            $("#txtid").val(id);
            $("#txtname").val(name);
            $("#txtdescription").val(description);
            $("#txtjumlah").val(formattedJumlah);
            $("#txtsatuan").val(satuan);
            // Tampilkan preview gambar jika ada
            if (image) {
                $("#previewImage").attr("src", "/storage/" + image).show();
            } else {
                $("#previewImage").hide();
            }
            // Tampilkan modal
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
            // Set nilai ke input field
            $("#txtid").val(id);
            $("#txtname").val(name);
            $("#txtdescription").val(description);
            $("#txtminimum").val(formattedMinimum);
            $("#txtsatuan_id").val(satuan_id);


            // Tampilkan modal
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
            // Set nilai ke input field
            $("#txtid").val(id);
            $("#txtdate").val(date);
            $("#txtbahan_id").val(bahan_id);
            $("#txtjumlah").val(formattedJumlah);

            // Tampilkan modal
            $("#editBarangModal").modal('toggle');
        });

    </script>
    <script>
        $(document).on('click', '.btn_editmenu', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let description = $(this).data('description') || "-";
            let komposisi = $(this).data('komposisi'); // Ambil daftar bahan dalam JSON

            // Pastikan komposisi adalah objek, bukan string
            if (typeof komposisi === 'string') {
                komposisi = JSON.parse(komposisi);
            }

            $("#editMenuId").val(id);
            $("#editMenuName").val(name);
            $("#editMenuDescription").val(description);

            let bahanContainer = $("#editBahanContainer");
            bahanContainer.empty();

            komposisi.forEach((item, index) => {
                let bahanHtml = `
                    <div class="input-group mb-2">
                        <select name="bahan[${index}][id]" class="form-select bahan-dropdown" required>
                            <option value="${item.bahan_id}" selected>${item.bahan.name}</option>
                        </select>
                        <input type="number" step="0.001" name="bahan[${index}][jumlah]" class="form-control" value="${item.jumlah}" required>
                    </div>
                `;
                bahanContainer.append(bahanHtml); // Ini harus ada!
            });


            $("#editBarangModal").modal("show");
        });


    </script>
    <script>
        function toggleInput(inputId, buttonId) {
            let inputField = document.getElementById(inputId);
            let button = document.getElementById(buttonId);

            if (inputField.readOnly) {
                inputField.readOnly = false; // Aktifkan input

                button.style.display = "none"; // Sembunyikan tombol edit
                inputField.focus(); // Fokus ke input
                inputField.select(); // Blok langsung isi input agar mudah diubah

                // Tambahkan event listener untuk mengunci kembali saat kehilangan fokus
                inputField.addEventListener('focusout', function lockInput() {
                    inputField.readOnly = true; // Kunci kembali input

                    button.style.display = "inline"; // Tampilkan kembali tombol edit

                    // Hapus event listener agar tidak menumpuk setiap kali tombol diklik
                    inputField.removeEventListener('focusout', lockInput);
                });
            }
        }

        // Event untuk tombol pertama
        document.getElementById('toggleMinimum').addEventListener('click', function () {
            toggleInput('minimum', 'toggleMinimum');
        });

        // Event untuk tombol kedua
        document.getElementById('toggleMinimum2').addEventListener('click', function () {
            toggleInput('txtminimum', 'toggleMinimum2');
        });


    </script>
    <script>
        document.querySelectorAll('input[type="number"].number0').forEach(function (input) {
            input.addEventListener("focusout", function () {
                if (this.value.trim() === "") {
                    this.value = "0"; // Setel kembali ke 0 jika kosong
                }
            });
        });

        document.querySelectorAll(".number0").forEach(function (inputField) {
            inputField.addEventListener("focus", function () {
                this.select(); // Memilih semua teks dalam input saat difokuskan
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let bahanIndex = 1;
            const bahanDropdownHtml = document.querySelector(".bahan-dropdown").innerHTML; // Simpan daftar bahan untuk cloning

            document.querySelector(".addBahan").addEventListener("click", function () {
                let container = document.getElementById("bahanContainer");
                let newBahan = document.createElement("div");
                newBahan.classList.add("input-group", "mb-2", "bahan-item");

                newBahan.innerHTML = `
            <select name="bahan[${bahanIndex}][id]" class="form-select bahan-dropdown" required>
                ${bahanDropdownHtml}  <!-- Gunakan dropdown yang sudah dibuat -->
            </select>
            <input type="number" step="0.001" name="bahan[${bahanIndex}][jumlah]" class="form-control" placeholder="Jumlah" required>
            <input type="text" name="bahan[${bahanIndex}][satuan]" class="form-control satuan-input" placeholder="Satuan" required disabled>
            <button type="button" class="btn btn-danger removeBahan">x</button>
        `;
                container.appendChild(newBahan);
                bahanIndex++;
            });

            document.getElementById("bahanContainer").addEventListener("click", function (event) {
                if (event.target.classList.contains("removeBahan")) {
                    event.target.parentElement.remove();
                }
            });

            // Otomatis set satuan saat bahan dipilih
            document.getElementById("bahanContainer").addEventListener("change", function (event) {
                if (event.target.classList.contains("bahan-dropdown")) {
                    let selectedOption = event.target.options[event.target.selectedIndex];
                    let satuanInput = event.target.parentElement.querySelector(".satuan-input");
                    satuanInput.value = selectedOption.dataset.satuan || "";
                }
            });
        });

    </script>

    <script>
        document.querySelectorAll(".toggle-jumlah").forEach(function (button) {
            button.addEventListener("click", function () {
                let inputField = this.parentElement.querySelector(".jumlah-input");
                let editButton = this.parentElement.querySelector(".toggle-jumlah"); // Cari tombol dalam parent yang sama

                if (inputField.readOnly) {
                    inputField.readOnly = false; // Aktifkan input
                    editButton.style.display = "none"; // Sembunyikan tombol edit
                    inputField.focus(); // Fokus ke input
                    inputField.select(); // Blok teks untuk langsung diubah

                    // Kunci kembali saat kehilangan fokus
                    inputField.addEventListener("focusout", function lockInput() {
                        inputField.readOnly = true; // Kunci input lagi
                        editButton.style.display = "inline"; // Tampilkan kembali tombol edit

                        // Hapus event listener agar tidak terus bertambah
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

        // Event Listener untuk tombol Konfirmasi
        document.querySelectorAll(".btn-konfirmasi").forEach(function (button) {
            button.addEventListener("click", function () {
                let row = this.closest("tr");
                let editButton = row.querySelector(".toggle-jumlah");

                if (this.classList.contains("btn-primary")) {
                    // Tombol berubah jadi loading saat diklik pertama kali
                    this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    this.disabled = true;

                    setTimeout(() => {
                        // Setelah loading, ubah jadi checklist
                        this.innerHTML = '<i class="fa fa-check"></i>';
                        this.classList.remove("btn-primary");
                        this.classList.add("btn-success");
                        this.disabled = false;
                        if (editButton) editButton.style.display = "none"; // Sembunyikan tombol edit
                        updateSubmitButton();
                    }, 500); // Simulasi loading 0.5 detik
                } else {
                    // Jika checklist diklik lagi, ubah kembali ke tombol konfirmasi
                    this.innerHTML = "Konfirmasi";
                    this.classList.remove("btn-success");
                    this.classList.add("btn-primary");
                    if (editButton) editButton.style.display = "inline-block"; // Tampilkan kembali tombol edit
                    updateSubmitButton();
                }
            });
        });

        // Event Listener untuk tombol Edit
        document.querySelectorAll(".toggle-jumlah").forEach(function (editButton) {
            editButton.addEventListener("click", function () {
                let inputField = this.previousElementSibling;

                if (inputField.readOnly) {
                    inputField.readOnly = false;
                    inputField.focus();
                    inputField.select(); // Blok teks agar mudah diedit

                    // Kunci kembali saat kehilangan fokus
                    inputField.addEventListener("focusout", function lockInput() {
                        inputField.readOnly = true;
                        inputField.removeEventListener("focusout", lockInput);
                    });
                }
            });
        });

        updateSubmitButton(); // Periksa status saat halaman dimuat
    </script>
    <script type="text/javascript">
        $(document).on('click', '.btn_editUP', function (e) {
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
        $(document).on('click', '.btn_editULP', function (e) {
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
        $(document).on('click', '.btn_edituser', function (e) {
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
            $('#searchButtonKeluar').on('click', function (e) {
                e.preventDefault();
                var keyword = $('#searchInput').val();

                $.ajax({
                    url: '{{ route("transaksi.keluarPost") }}',
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        cari: keyword
                    },
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
        $(document).ready(function () {
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