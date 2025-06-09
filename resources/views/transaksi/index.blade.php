@extends('layouts.main')
@section('Transaksi', 'active')
@section('container')
@section('title', "Transaksi | BdiM’s Stock")

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
        @include('layouts.components.alert-flash-messages')
        <div class="d-flex align-items-center mb-3">
            <div class="mb-3 row">
                <label for="tanggalbahan" class="col-sm-3 col-form-label me-2">Tanggal</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="tanggalbahan" name="date" value="{{ $date }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Transaksi</div>
                        <div>
                            <span id="tanggal-terformat"
                                class="badge bg-primary text-white ms-3">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableTransaksi" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <!-- Tombol trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#importModal">
                                        <i class="fa fa-upload me-2" aria-hidden="true"></i>Import Transaksi
                                    </button>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#tambahTransaksiModal">
                                        <i class="fa fa-plus me-2"></i>Manual
                                    </button>

                                    <div class="col-sm-4 float-end">
                                        <div class="d-flex gap-2 mb-2">
                                            <button class="btn btn-secondary filterCustom" data-bs-toggle="modal"
                                                data-bs-target="#filterModal">
                                                <i class="fa fa-filter"></i>
                                            </button>
                                            <form action="/transaksi" method="GET" class="d-inline">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm"
                                                    title="Refresh">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </form>
                                            <form action="/transaksi" method="get" class="form-inline d-flex">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Cari transaksi..."
                                                    value="{{ request('search') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                @if ($settings['show_image_transaksi'] ?? true)
                                                    <th style="width: 110px;">Gambar</th>
                                                @endif
                                                <th>Nama Menu</th>
                                                <th class="text-center">Jumlah</th>
                                                <th>Bahan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paginated as $key => $transaksi)
                                                <tr>
                                                    <td>{{ ($paginated->currentPage() - 1) * $paginated->perPage() + $loop->iteration }}
                                                    </td>
                                                    @if ($settings['show_image_transaksi'] ?? true)
                                                        <td class="text-center"><img
                                                                src="{{ asset($transaksi['menu_image'] ?? 'img/dummy/ss_menu.png') }}"
                                                                style="width: 100px; max-height: 100px;" alt="Img">
                                                        </td>
                                                    @endif
                                                    <td>{{ $transaksi['menu_name'] }}</td>
                                                    <td class="text-center">
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

                                                        <form action="{{ route('transaksi.delete') }}" method="POST"
                                                            class="d-inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="transaksi_id"
                                                                value="{{ $transaksi['transaksi_id'] }}">
                                                            <button class="btn btn-danger btn-sm" type="submit"
                                                                onclick="return confirm('Yakin akan mendelete data?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if($paginated->isEmpty())
                                                <tr>
                                                    <td colspan="100%" class="text-center text-muted py-3">Tidak ada data yang
                                                        ditemukan.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </div>
                            </table>
                            {{ $paginated->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
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
                        <h5 class="modal-title fs-5 fw-bold text-primary" id="importModalLabel">Import Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold" for="file">File Excel</label>
                            <input type="file" name="file" id="fileInput" class="form-control" accept=".xlsx,.csv" required>
                            <small class="form-text text-danger ml-2">*Format .xlsx, .xls, .csv</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold" for="date">Tanggal Transaksi</label>
                            <input type="date" name="date" style="width: initial;" class="form-control" required
                                value="{{ $date }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Mode Import</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" id="modeTambah" value="tambah"
                                    checked>
                                <label class="form-check-label" for="modeTambah">Tambahkan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" id="modeUpdate" value="update">
                                <label class="form-check-label" for="modeUpdate">Update</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="mode" id="modeRange" value="range">
                                <label class="form-check-label" for="modeRange">Range</label>
                            </div>
                        </div>

                        <div id="rangeDateFields" style="display: none;">
                            <div class="mb-2 row">
                                <label class="col-sm-3 col-form-label" style="width: 140px;">Dari Tanggal</label>
                                <input type="date" style="width: initial;" name="range_start" class="form-control col-sm-8">
                                <label class="col-sm-3 col-form-label" style="width: 50px;">s/d</label>
                                <input type="date" style="width: initial;" name="range_end" class="form-control col-sm-8">
                            </div>
                            <div class="mb-2">

                            </div>
                        </div>


                        <!-- Preview -->
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3" id="previewTable" style="display: none;">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
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
    <!-- Modal Tambah Transaksi -->
    <div class="modal fade" id="tambahTransaksiModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('transaksi.storeTransaksi') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary fw-bold" id="tambahModalLabel">Tambah Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="date" class="form-label fw-bold text-dark">Tanggal Transaksi</label>
                            <input type="date" name="date" style="width: initial;" class="form-control" required
                                value="{{ $date }}">
                        </div>
                        <div class="mb-3">
                            <label for="menu_id" class="form-label text-dark fw-bold">Nama Menu</label>
                            <select class="form-select" required autocomplete="off" id="menu_id" name="menu_id">
                                <option value="">-- Pilih Menu --</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label fw-bold text-dark">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control number0" value="0" required min="1"
                                max="999999999">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                            <label for="date" class="form-label fw-bold text-dark">Tanggal Transaksi</label>
                            <input type="date" readonly name="date" id="txtdate" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="menu_name" class="form-label fw-bold text-dark">Nama Menu</label>
                            <input type="text" readonly name="menu_name" id="txtname" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label fw-bold text-dark">Jumlah</label>
                            <input type="number" name="jumlah" id="txtjumlahMenu" class="form-control" required
                                max="999999999">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('user.setting.update') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold fs-5 text-primary" id="filterModalLabel">Filter Tampilan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Checkbox Kolom --}}
                        @php
                            $columns = [
                                'show_image_transaksi' => ['label' => 'Gambar', 'default' => true],
                            ];
                        @endphp

                        <label class="form-label fw-bold text-dark">Tampilan Kolom:</label>
                        @foreach ($columns as $key => $column)
                            <div class="form-check">
                                <input type="hidden" name="{{ $key }}" value="0">
                                <input class="form-check-input" type="checkbox" name="{{ $key }}" value="1" id="{{ $key }}" {{ ($settings[$key] ?? $column['default']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $key }}">
                                    {{ $column['label'] }}
                                </label>
                            </div>
                        @endforeach
                        <hr>

                        {{-- Select Pagination --}}
                        <div class="mb-3">
                            <label for="paginationSelect" class="form-label fw-bold text-dark">Jumlah Per Halaman</label>
                            <select class="form-select" name="pagination_transaksi" id="paginationSelect">
                                <option value="20" {{ ($settings['pagination_transaksi'] ?? 20) == 20 ? 'selected' : '' }}>20
                                </option>
                                <option value="50" {{ ($settings['pagination_transaksi'] ?? 20) == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ ($settings['pagination_transaksi'] ?? 20) == 100 ? 'selected' : '' }}>
                                    100
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('addScript')
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
                                                                                <td class="check-cell text-center">⏳</td>
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
                                        document.getElementById('previewTable').style.display = 'table';
                                    }
                                });
                        }

                        document.getElementById('previewTable').style.display = 'table';
                    }
                };
                reader.readAsArrayBuffer(file);
            }

            function toggleModeColumns() {
                const mode = document.querySelector('input[name="mode"]:checked').value;
                const previewCols = document.querySelectorAll('.preview-update-column');
                const rangeFields = document.getElementById('rangeDateFields');

                // if (mode === 'update') {
                //     previewCols.forEach(col => col.style.display = '');
                // } else {
                //     previewCols.forEach(col => col.style.display = 'none');
                // }

                rangeFields.style.display = (mode === 'range') ? 'block' : 'none';
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

            document.querySelectorAll('input[name="mode"]').forEach(radio => {
                radio.addEventListener('change', function () {
                    const showRange = this.value === 'range';
                    document.getElementById('rangeDateFields').style.display = showRange ? 'block' : 'none';
                });
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
        <script>
            const tanggalInput = document.getElementById('tanggalbahan');
            const tanggalTerformat = document.getElementById('tanggal-terformat');

            function formatTanggalIndo(tanggalStr) {
                const bulanIndo = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];

                const dateObj = new Date(tanggalStr);
                const tanggal = dateObj.getDate();
                const bulan = bulanIndo[dateObj.getMonth()];
                const tahun = dateObj.getFullYear();

                return `${tanggal} ${bulan} ${tahun}`;
            }

            tanggalInput.addEventListener('change', function () {
                const selectedDate = this.value;
                if (selectedDate) {
                    tanggalTerformat.textContent = formatTanggalIndo(selectedDate);
                    const baseUrl = "{{ url('/transaksi') }}";
                    window.location.href = `${baseUrl}?date=${selectedDate}`;
                }
            });
        </script>
    @endpush

@endsection