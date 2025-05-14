@extends('layouts.main')
@section('Transaksi', 'active')
@section('container')

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Transaksi</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-exclamation-triangle me-2" aria-hidden="true"></i>
                        &nbsp{{ session()->get('error') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <form action="/transaksi" method="GET" class="d-flex align-items-center mb-3">
            <div class="mb-3 row">
                <label for="tanggalbahan" class="col-sm-2 col-form-label me-2">Tanggal</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="tanggalbahan" name="date" value="{{ $date }}">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Transaksi</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableTransaksi" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <!-- Tombol trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah menu
                                    </button>
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#importModal">
                                        <i class="fa fa-upload me-2" aria-hidden="true"></i>Import Transaksi
                                    </button>

                                    <div class="col-sm-3 float-end">
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/transaksi" class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/transaksi" method="get" class="form-inline d-flex">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Search" value="{{ request('search') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th class="column-gambar" style="width: 110px;">Gambar</th>
                                                <th>Nama Menu</th>
                                                <th>Jumlah</th>
                                                <th>Bahan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($paginated as $key => $transaksi)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="column-gambar">
                                                        <img src="{{ asset($transaksi['menu_image']) }}"
                                                            style="width: 100px; max-height: 100px;" alt="Img">
                                                    </td>
                                                    <td>{{ $transaksi['menu_name'] }}</td>
                                                    <td class="text-end">
                                                        {{ rtrim(rtrim(number_format($transaksi['total_jumlah'], 3, ',', '.'), '0'), ',') }}
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach($transaksi['bahans'] as $bahan)
                                                                <li>{{ $bahan['bahan_name'] }} -
                                                                    {{ rtrim(rtrim(number_format($bahan['total_bahan'], 3, ',', '.'), '0'), ',') }}
                                                                    {{ $bahan['satuan_name'] }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm btn_edittransaksi"
                                                            data-id="{{ $transaksi['transaksi_id'] }}"
                                                            data-date="{{ $transaksi['date'] ?? 'NULL' }}"
                                                            data-menu-id="{{ $transaksi['menu_id'] }}"
                                                            data-jumlah="{{ $transaksi['total_jumlah'] ?? 'NULL' }}"
                                                            data-menu-name="{{ $transaksi['menu_name'] ?? 'NULL' }}"
                                                            data-komposisi="{{ json_encode($transaksi['komposisi']) }}">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </button>

                                                        <form action="/transaksi/delete/{{ $transaksi['transaksi_id'] }}"
                                                            class="d-inline" method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-danger btn-sm" type="submit"
                                                                onclick="return confirm('Yakin akan Mendelete Data?')"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>

                                                    </td>


                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Tidak ada data yang
                                                        ditemukan.</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                            </table>
                            {{ $paginated->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Upload Excel -->
    <div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('transaksi.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadExcelModalLabel">Upload File Excel / CSV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="file" class="form-control" name="file" accept=".csv,.xlsx" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Transaksi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action='/transaksi'>
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                        </div>

                        <div class="mb-3">
                            <label for="menu_id" class="form-label text-dark fw-bold">Nama Menu</label>
                            <select class="form-control select2" required id="menu_id" name="menu_id">
                                <option value="">-- Pilih Menu --</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}" data-komposisi='@json($menu->komposisi)'>
                                        {{ $menu->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="jumlah" class="form-label text-dark fw-bold me-2">Jumlah</label>
                            <input type="number" step="1" min="1" required class="form-control number0" id="jumlahMenu"
                                name="jumlah" value="1" style="max-width: 150px;">

                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Komposisi</label>
                            <div class="mb-3">
                                <ul id="komposisiPreview" class="list-group small"></ul>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" name="SaveButton">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="importForm" action="{{ route('transaksi.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="file">File Excel</label>
                            <input type="file" name="file" id="fileInput" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="date">Tanggal Transaksi</label>
                            <input type="date" name="date" class="form-control" required value="{{ $date }}">
                        </div>

                        <div class="mb-3">
                            <label>Mode Import</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" id="modeTambah" value="tambah"
                                    checked>
                                <label class="form-check-label" for="modeTambah">Tambahkan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" id="modeUpdate" value="update">
                                <label class="form-check-label" for="modeUpdate">Update (hapus & ganti)</label>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3" id="previewTable" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Menu</th>
                                        <th>Check</th>
                                        <th class="preview-update-column">Jumlah Sebelumnya</th>
                                        <th>Jumlah Baru</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Barang-->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Edit Transaksi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="editBarangForm">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="id" id="txtid" hidden>
                            <input type="hidden" name="menu_id" id="txtmenuId">


                            <input type="date" name="date" id="txtdate" class="form-control">
                            <label for="menu_name" class="form-label">Nama Menu</label>
                            <input type="text" readonly name="menu_name" id="txtname" class="form-control">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" id="txtjumlahMenu" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fileInput').addEventListener('change', handleFile, false);
        document.getElementsByName('mode').forEach(radio => {
            radio.addEventListener('change', toggleModeColumns);
        });

        let pendingFetches = 0;


        function handleFile(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                const rows = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

                const tbody = document.querySelector('#previewTable tbody');
                tbody.innerHTML = "";

                let mode = document.querySelector('input[name="mode"]:checked').value;
                const selectedDate = document.querySelector('input[name="date"]').value;

                if (rows.length > 1) {
                    for (let i = 1; i < rows.length; i++) {
                        const namaMenuExcel = (rows[i][0] || '').trim();
                        const jumlahBaru = parseInt(rows[i][2] || 0);

                        if (!namaMenuExcel || jumlahBaru <= 0) continue;

                        const tr = document.createElement('tr');
                        tr.innerHTML = `

                                            <td>${i}</td>
                                            <td class="nama-menu">${namaMenuExcel}</td>
                                            <td class="check-cell">⏳</td>
                                            <td class="jumlah-sebelumnya preview-update-column">Memuat...</td>
                                            <td>${jumlahBaru}</td>
                                        `;
                        tbody.appendChild(tr);

                        pendingFetches++; // Sebelum fetch

                        fetch(`/transaksi/jumlah-sebelumnya?menu=${encodeURIComponent(namaMenuExcel)}&date=${selectedDate}`)
                            .then(res => res.json())
                            .then(data => {
                                const sebelumnya = parseInt(data.jumlah || 0);
                                const cellJumlah = tr.querySelector('.jumlah-sebelumnya');
                                cellJumlah.textContent = sebelumnya;

                                const checkCell = tr.querySelector('.check-cell');
                                if (data.menu_name && data.menu_name.trim().toLowerCase() === namaMenuExcel.toLowerCase()) {
                                    checkCell.textContent = '✅';
                                    tr.classList.remove('table-danger');
                                    tr.classList.add('table-success');
                                } else {
                                    checkCell.textContent = '❌';
                                    tr.classList.remove('table-success');
                                    tr.classList.add('table-danger');
                                }
                            })
                            .catch(() => {
                                tr.querySelector('.jumlah-sebelumnya').textContent = '-';
                                tr.querySelector('.check-cell').textContent = '❌';
                                tr.classList.add('table-danger');
                            })
                            .finally(() => {
                                pendingFetches--;
                                if (pendingFetches === 0) {
                                    document.getElementById('loadingStatus').textContent = 'Selesai memuat semua data.';
                                }
                            });


                    }

                    document.getElementById('previewTable').style.display = 'table';
                }
            };
            reader.readAsArrayBuffer(file);
        }

        function toggleModeColumns() {
            // Kalau memang semua mode pakai kolom yang sama sekarang, cukup tampilkan saja tanpa reload
            const updateCols = document.querySelectorAll('.preview-update-column');
            updateCols.forEach(col => col.style.display = '');

            // Tidak perlu reload ulang preview
        }


    </script>




    <script>
        document.getElementById('uploadForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let fileInput = document.getElementById('fileInput');
            if (!fileInput.files.length) {
                document.getElementById('uploadMessage').innerHTML = '<div class="text-danger">Pilih file terlebih dahulu!</div>';
                return;
            }

            let formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ url("/transaksi/import") }}', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('uploadMessage').innerHTML = '<div class="text-success">' + data.success + '</div>';
                        setTimeout(() => location.reload(), 1500); // Reload setelah sukses
                    } else {
                        document.getElementById('uploadMessage').innerHTML = '<div class="text-danger">' + data.error + '</div>';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let transaksiId = this.dataset.id;
                    fetch(`/transaksi/${transaksiId}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById("transaksiId").value = data.id;
                            document.getElementById("editJumlah").value = data.jumlah;
                            $('#editModal').modal('show');
                        });
                });
            });

            document.getElementById("editForm").addEventListener("submit", function (event) {
                event.preventDefault();
                let transaksiId = document.getElementById("transaksiId").value;
                let jumlah = document.getElementById("editJumlah").value;
                fetch(`/transaksi/${transaksiId}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({ jumlah: jumlah })
                }).then(response => response.json())
                    .then(() => location.reload());
            });
        });
    </script>
@endsection