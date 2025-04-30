@extends('layouts.main')
@section('StokBarang', 'active')
@section('container')

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Stok Barang</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Stok Barang - Master</li>
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

        <div>
            <a href="/barang/master"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/master') ? 'active' : '' }}">
                Master
            </a>

            <a href="/barang/masuk-keluar"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/masuk-keluar') ? 'active' : '' }}">
                Barang Masuk/Keluar
            </a>
            <!-- <a href="/barang/data-barang"
                                                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/data-barang') ? 'active' : '' }}">
                                                Data Barang
                                            </a> -->

            <a href="/barang/satuan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/satuan') ? 'active' : '' }}">
                Satuan
            </a>

            @if(Auth::check() && (Auth::user()->role == 'OWNER' || Auth::user()->role == 'MANAJER'))
                <a href="/barang/history"
                    class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/history') ? 'active' : '' }}">
                    Riwayat
                </a>
            @endif
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Barang </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBarang" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                                    </button>
                                    <div class="col-sm-3 float-end mt-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="" id="toggleImageColumn">
                                            <label class="form-check-label" for="toggleImageColumn">
                                                Tampilkan Gambar
                                            </label>
                                        </div>
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/barang/data-barang" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/barang/data-barang" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Search" value="{{ request('search') }}">
                                            </form>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th class="column-gambar" style="width: 110px; display: none;">Gambar</th>
                                                <th>Nama barang</th>
                                                <th>Deskripsi barang</th>
                                                <th>Stok</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($barangs->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($barangs as $barang)
                                                    <tr>
                                                        <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td class="column-gambar" style="display:none;">
                                                            <img src="{{ asset($barang->image) }}"
                                                                style="width: 100px; max-height: 100px;" alt="Img">
                                                        </td>
                                                        <td>
                                                            <a href="/barang/master/{{ Hashids::encode($barang->id) }}"
                                                                class="text-decoration-none text-dark">
                                                                {{ $barang->name ?? '-' }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $barang->description }}</td>
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($barang->stok_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                        <td>{{ $barang->satuanBarang->name ?? '-' }}</td>

                                                        <td>
                                                            <!-- Tombol Tambah -->
                                                            <button type="button" class="btn btn-outline-success btnTambahStok"
                                                                data-id="{{ $barang->id ?? 'NULL' }}"
                                                                data-name="{{ $barang->name ?? 'NULL'}}"
                                                                data-satuan="{{ $barang->satuanBarang->name ?? '-' }}"
                                                                data-bs-toggle="modal" data-bs-target="#barangModalM">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>


                                                            <!-- Tombol Kurangi -->
                                                            <button type="button" class="btn btn-outline-success btnKurangStok"
                                                                data-id="{{ $barang->id ?? 'NULL' }}"
                                                                data-name="{{ $barang->name ?? 'NULL'}}"
                                                                data-satuan="{{ $barang->satuanBarang->name ?? '-' }}"
                                                                data-bs-toggle="modal" data-bs-target="#barangModalK">
                                                                <i class="fa fa-minus " aria-hidden="true"></i>
                                                            </button>

                                                            <!-- Tombol 3 -->
                                                            <div class="dropdown" style="display:initial;">
                                                                <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                                    type="button" id="dropdownMenuButton{{ $barang->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false" style="height: 36px;">
                                                                    &#8942; 
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton{{ $barang->id }}">
                                                                    <li>
                                                                        <button class="dropdown-item btn_editbarang"
                                                                            data-id="{{ $barang->id ?? 'NULL' }}"
                                                                            data-name="{{ $barang->name ?? 'NULL' }}"
                                                                            data-description="{{ $barang->description ?? 'NULL' }}"
                                                                            data-jumlah="{{ $barang->jumlah ?? 'NULL' }}"
                                                                            data-satuan_id="{{ $barang->satuan_id ?? 'NULL' }}"
                                                                            data-image="{{ $barang->image ?? 'NULL' }}">
                                                                            <i class="fa fa-edit me-2"></i>Edit
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <form action="/barang/data-barang/delete/{{ $barang->id }}"
                                                                            method="post"
                                                                            onsubmit="return confirm('Yakin akan Mendelete Data?')">
                                                                            @method('PUT')
                                                                            @csrf
                                                                            <button class="dropdown-item text-danger" type="submit">
                                                                                <i class="fa fa-trash me-2"></i>Hapus
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                    <li>
                                                                        <a href="/barang/masuk-keluar/{{ Hashids::encode($barang->id) }}"
                                                                            class="dropdown-item">
                                                                            <i class="fa fa-eye me-2"></i>Lihat Masuk/Keluar
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $barangs->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Barang-->
    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/barang/data-barang/store' enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="date">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" required autocomplete="off" class="form-control" id="name" name="name"
                                placeholder="Ketik nama barang">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control" required id="description" name="description" rows="4"
                                autocomplete="off" placeholder="Ketik deskripsi barang"></textarea>

                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label text-dark fw-bold">Stok Awal</label>
                            <input type="number" required autocomplete="off" class="form-control number0" id="jumlah"
                                name="jumlah" value="0" placeholder="Ketik jumlah stok">
                        </div>
                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control" required autocomplete="off" id="satuan_id" name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuanBarangs as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Barang Masuk -->
    <div class="modal fade" id="barangModalM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Barang Masuk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/barang/master/storeM'>
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
                            <input type="number" min="1" class="form-control" name="jumlah" required>
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
                                name="keterangan" rows="4" placeholder="Catatan barang masuk"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="barangModalK" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Barang Keluar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/barang/master/storeK'>
                        @csrf
                        <input type="hidden" name="id" id="stokBarangIdK">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="stokDateK" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" readonly class="form-control" id="stokBarangNameK">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah</label>
                            <input type="number" min="1" class="form-control" name="jumlah" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Satuan</label>
                            <input type="text" disabled class="form-control  @error('satuan_id') is-invalid @enderror"
                                id="stokBarangSatuanK">
                            @error('satuan_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label text-dark fw-bold">Catatan</label>
                            <textarea class="form-control" autocomplete="off" id="stokKeteranganK" required
                                name="keterangan" rows="4" placeholder="Catatan barang keluar"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
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
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Form Edit Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/barang/data-barang/edit" id="editBarangForm" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="text" name="id" id="txtid">
                            <input hidden type="number" name="jumlah" id="txtjumlah">
                            <label for="name" class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" required autocomplete="off"
                                class="form-control @error('name') is-invalid @enderror" id="txtname" name="name">
                            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" autocomplete="off"
                                id="txtdescription" required name="description" rows="4"
                                placeholder="Ketik deskripsi barang"></textarea>
                            @error('description') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control select2" id="txtsatuan_id" required autocomplete="off"
                                name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuanBarangs as $satuan)
                                    <option value="{{ $satuan->id }}" {{ old('tsatuan_id', $bahan->satuan_id ?? '') == $satuan->id ? 'selected' : '' }}>
                                        {{ $satuan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="txtimage"
                                name="image">
                            <img id="previewImage" src="" alt="Preview Gambar" class="img-thumbnail mt-2"
                                style="display: none; width: 100px;">
                            @error('image') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white">Ubah</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>

        const checkbox = document.getElementById('toggleImageColumn');
        const imageColumns = document.querySelectorAll('.column-gambar');

        checkbox.addEventListener('change', function () {
            imageColumns.forEach(col => {
                col.style.display = this.checked ? '' : 'none';
            });
        });

    </script>

@endsection