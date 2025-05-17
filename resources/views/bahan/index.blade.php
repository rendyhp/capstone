@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')
@section('title', 'Manajemen Bahan | Bdim’s Stock')

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Manajemen Bahan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Stok Bahan - Manajemen Bahan</li>
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

        <form action="/bahan/master" method="GET" class="d-flex align-items-center mb-3">
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

        <div>
            <a href="/bahan/master"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/master') ? 'active' : '' }}">
                Manajemen Bahan
            </a>
            <a href="/bahan/data-bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/data-bahan') ? 'active' : '' }}">
                Master Bahan
            </a>

            <a href="/bahan/satuan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/satuan') ? 'active' : '' }}">
                Satuan
            </a>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Bar </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">

                                    <div class="col-sm-3 float-end">
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/bahan/master" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/bahan/master" method="get" class="form-inline d-flex">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search1" placeholder="Search" value="{{ request('search1') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Bahan</th>
                                                <th>Awal</th>
                                                <th>Masuk</th>
                                                <th>Terpakai</th>
                                                <th>Sisa</th>
                                                <th>Akhir<br>Sebenarnya</th>
                                                <th>Terbuang</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($bahan_bars->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($bahan_bars as $bahan)
                                                    <tr>
                                                        <td>{{ ($bahan_bars->currentPage() - 1) * $bahan_bars->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td>{{ $bahan->name }}</td>

                                                        <td class="text-end editable {{ $bahan->awal_manual ? 'bg-khaki' : '' }}"
                                                            ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'awal', '{{ $bahan->jumlah_awal }}')">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_awal, 3, ',', '.'), '0'), ',') }}
                                                        </td>

                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_masuk, 3, ',', '.'), '0'), ',') }}
                                                        </td>

                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_terpakai, 3, ',', '.'), '0'), ',') }}
                                                        </td>

                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>

                                                        <td class="text-end editable {{ $bahan->akhir_manual ? 'bg-khaki' : '' }}"
                                                            ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'akhir', '{{ $bahan->bahan_akhir }}')">
                                                            {{ rtrim(rtrim(number_format($bahan->bahan_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>

                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->bahan_terbuang, 3, ',', '.'), '0'), ',') }}
                                                        </td>

                                                        <td>{{ $bahan->satuan->name ?? '-' }}</td>

                                                        <td>
                                                            <!-- Tombol Tambah -->
                                                            <button type="button" class="btn btn-outline-success btnTambahStok"
                                                                data-id="{{ $bahan->id ?? 'NULL' }}"
                                                                data-name="{{ $bahan->name ?? 'NULL'}}"
                                                                data-satuan="{{ $bahan->satuan->name ?? '-' }}"
                                                                data-bs-toggle="modal" data-bs-target="#barangModalM">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>

                                                            <button type="button" class="btn btn-outline-secondary"
                                                                onclick="window.location.href='{{ route('bahan.indexBahanMKbyID', ['encryptedId' => Hashids::encode($bahan->id)]) }}'">
                                                                <i class="fa fa-info me-2"></i>History
                                                            </button>
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $bahan_bars->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title fs-5 fw-bold mt-2"> Tabel Kitchen </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                            <div class="mb-3">

                                <div class="col-sm-3 float-end">
                                    <div class="d-flex gap-2 mb-2">
                                        <a href="/bahan/master" class="btn btn-outline-secondary btn-sm" title="Refresh">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                        <form action="/bahan/master" method="get" class="form-inline d-flex">
                                            <input type="hidden" name="date"
                                                value="{{ request('date', now()->toDateString()) }}">
                                            <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                name="search2" placeholder="Search" value="{{ request('search2') }}">
                                        </form>
                                    </div>
                                    <div>
                                    </div>
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Bahan</th>
                                            <th>Awal</th>
                                            <th>Masuk</th>
                                            <th>Terpakai</th>
                                            <th>Sisa</th>
                                            <th>Akhir<br>Sebenarnya</th>
                                            <th>Terbuang</th>
                                            <th>Satuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bahan_kitchens->isEmpty())
                                            <p>Tidak ada data yang ditemukan.</p>
                                        @else
                                            @foreach ($bahan_kitchens as $bahan)
                                                <tr>
                                                    <td>{{ ($bahan_kitchens->currentPage() - 1) * $bahan_kitchens->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td>{{ $bahan->name }}</td>

                                                    <td class="text-end editable {{ $bahan->awal_manual ? 'bg-khaki' : '' }}"
                                                        ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'awal', '{{ $bahan->jumlah_awal }}')">
                                                        {{ rtrim(rtrim(number_format($bahan->jumlah_awal, 3, ',', '.'), '0'), ',') }}
                                                    </td>

                                                    <td class="text-end">
                                                        {{ rtrim(rtrim(number_format($bahan->jumlah_masuk, 3, ',', '.'), '0'), ',') }}
                                                    </td>

                                                    <td class="text-end">
                                                        {{ rtrim(rtrim(number_format($bahan->jumlah_terpakai, 3, ',', '.'), '0'), ',') }}
                                                    </td>

                                                    <td class="text-end">
                                                        {{ rtrim(rtrim(number_format($bahan->jumlah_akhir, 3, ',', '.'), '0'), ',') }}
                                                    </td>

                                                    <td class="text-end editable {{ $bahan->akhir_manual ? 'bg-khaki' : '' }}"
                                                        ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'akhir', '{{ $bahan->bahan_akhir }}')">
                                                        {{ rtrim(rtrim(number_format($bahan->bahan_akhir, 3, ',', '.'), '0'), ',') }}
                                                    </td>

                                                    <td class="text-end">
                                                        {{ rtrim(rtrim(number_format($bahan->bahan_terbuang, 3, ',', '.'), '0'), ',') }}
                                                    </td>


                                                    <td>{{ $bahan->satuan->name ?? '-' }}</td>

                                                    <td>
                                                        <!-- Tombol Tambah -->
                                                        <button type="button" class="btn btn-outline-success btnTambahStok"
                                                            data-id="{{ $bahan->id ?? 'NULL' }}"
                                                            data-name="{{ $bahan->name ?? 'NULL'}}"
                                                            data-satuan="{{ $bahan->satuan->name ?? '-' }}" data-bs-toggle="modal"
                                                            data-bs-target="#barangModalM">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>




                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="window.location.href='{{ route('bahan.indexBahanMKbyID', ['encryptedId' => Hashids::encode($bahan->id)]) }}'">
                                                            <i class="fa fa-info me-2"></i>History
                                                        </button>
                                                    </td>


                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                        </table>
                        {{ $bahan_kitchens->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Input bahan awal dan akhir dengandouble click -->
    <div class="modal fade" id="modalEditJumlah" tabindex="-1" aria-labelledby="modalEditJumlahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="modalEditJumlahLabel">Edit Jumlah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditJumlah">
                        @csrf
                        <input type="hidden" name="bahan_id" id="bahan_id">
                        <input type="hidden" name="date" id="date">
                        <input type="hidden" name="type" id="type">

                        <div class="mb-3">
                            <label for="jumlah_input" class="form-label">Jumlah:</label>
                            <input type="number" step="0.001" min="0" id="jumlah_input" name="jumlah"
                                class="form-control number0" required>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <!-- Tombol Reset -->
                            <button type="button" class="btn btn-danger" id="resetJumlahBtn">Reset</button>

                            <!-- Tombol Simpan -->
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bahan Masuk -->
    <div class="modal fade" id="barangModalM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Bahan Masuk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/bahan/master/storeM'>
                        @csrf

                        <div class="mb-3">
                            <input type="text" hidden name="id" id="stokBarangIdM">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="stokDateM" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" disabled class="form-control  @error('name') is-invalid @enderror"
                                id="stokBarangNameM">
                            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah</label>
                            <input type="number" min="0" class="form-control number0" name="jumlah" step="0.001" value="0"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Satuan</label>
                            <input type="text" disabled class="form-control  @error('satuan') is-invalid @enderror"
                                id="stokBarangSatuanM">
                            @error('satuan') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label text-dark fw-bold">Catatan</label>
                            <textarea class="form-control" autocomplete="off" id="stokKeteranganM" required
                                name="keterangan" rows="4" placeholder="Misalnya: Cash"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <script>
        function editJumlah(bahan_id, date, type, currentJumlah) {
            // Format angka: jika bilangan bulat, tampilkan tanpa desimal
            var formattedJumlah = currentJumlah % 1 === 0 ? parseInt(currentJumlah) : currentJumlah;

            // Isi form modal dengan data yang dikirim
            document.getElementById('bahan_id').value = bahan_id;
            document.getElementById('date').value = date;
            document.getElementById('type').value = type;
            document.getElementById('jumlah_input').value = formattedJumlah;

            // Tampilkan modal (Bootstrap 5)
            var myModal = new bootstrap.Modal(document.getElementById('modalEditJumlah'));
            myModal.show();
        }


        document.getElementById('formEditJumlah').addEventListener('submit', function (e) {
            e.preventDefault();

            let form = e.target;
            let bahan_id = form.bahan_id.value;
            let date = form.date.value;
            let type = form.type.value; // 'awal' or 'akhir'
            let jumlah = form.jumlah.value;
            let _token = form.querySelector('input[name="_token"]').value;

            let url = type === 'awal' ? '/bahanAwal/save' : '/bahanAkhir/save';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': _token
                },
                body: JSON.stringify({ bahan_id, date, jumlah })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Data berhasil disimpan!');
                        location.reload(); // refresh page supaya update data muncul
                    } else if (data.error2) {
                        alert('Hanya bisa edit Bahan Awal pada Tanggal 01')
                    } else {
                        alert('Gagal menyimpan data');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan.');
                });
        });
    </script>
    <script>
        document.getElementById('resetJumlahBtn').addEventListener('click', function () {
            const bahan_id = document.getElementById('bahan_id').value;
            const date = document.getElementById('date').value;
            const type = document.getElementById('type').value;
            const _token = document.querySelector('input[name="_token"]').value;

            if (!confirm('Yakin ingin menghapus jumlah ini?')) return;

            let url = type === 'awal' ? '/bahanAwal/delete' : '/bahanAkhir/delete';

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': _token
                },
                body: JSON.stringify({ bahan_id, date })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Data berhasil dihapus!');
                        location.reload();
                    } else {
                        alert('Data tidak ditemukan.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat menghapus data.');
                });
        });
    </script>

@endsection