@extends('layouts.main')
@section('StokBarang', 'active')
@section('container')
@section('title', "Manajemen Barang | B.di.M’s Stock")

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
                                <li class="breadcrumb-item active" aria-current="page">Stok Barang - Manajemen Barang</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.components.alert-flash-messages')
        <div>
            <a href="/barang/manajemen-barang"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/manajemen-barang') ? 'active' : '' }}">
                Manajemen Barang
            </a>

            <a href="/barang/masuk-keluar"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/masuk-keluar') ? 'active' : '' }}">
                Barang Masuk/Keluar
            </a>
            <a href="/barang/satuan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/satuan') ? 'active' : '' }}">
                Satuan
            </a>

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
                                    <div class="col-sm-4 float-end mt-3">
                                        <div class="d-flex gap-2 mb-2">
                                            <button class="btn btn-secondary filterCustom" data-bs-toggle="modal"
                                                data-bs-target="#filterModal">
                                                <i class="fa fa-filter"></i>
                                            </button>
                                            <a href="/barang/manajemen-barang" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/barang/manajemen-barang" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Cari barang..."
                                                    value="{{ request('search') }}">
                                            </form>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="column-nomor-brg">No.</th>
                                                @if ($settings['show_image_barang'] ?? false)
                                                    <th class="column-image-brg">Gambar</th>
                                                @endif
                                                <th class="column-name-brg">Nama Barang</th>
                                                @if ($settings['show_keteranganB'] ?? true)
                                                    <th class="column-description-brg">Deskripsi</th>
                                                @endif
                                                @if ($settings['show_awalB'] ?? true)
                                                    <th class="text-center column-awal-brg">Awal</th>
                                                @endif
                                                @if ($settings['show_masukB'] ?? true)
                                                    <th class="text-center column-masuk-brg">Stok Masuk</th>
                                                @endif
                                                @if ($settings['show_total_beliB'] ?? true)
                                                    <th class="text-center column-totalB-brg">Total Beli</th>
                                                @endif
                                                @if ($settings['show_keluarB'] ?? true)
                                                    <th class="text-center column-keluar-brg">Keluar</th>
                                                @endif
                                                @if ($settings['show_sisaB'] ?? true)
                                                    <th class="text-center column-sisa-brg">Sisa</th>
                                                @endif
                                                @if ($settings['show_minimumB'] ?? false)
                                                    <th class="text-center column-minimum-brg">Minimum</th>
                                                @endif
                                                <th class="column-satuan-brg">Satuan</th>
                                                <th class="column-action-brg">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangs as $barang)
                                                <tr>
                                                    <td class="column-nomor-brg">
                                                        {{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}
                                                    </td>
                                                    @if ($settings['show_image_barang'] ?? false)
                                                        <td class="text-center column-image-brg">
                                                            <img src="{{ asset($barang->image ?? 'img/dummy/ss_barang.png') }}"
                                                                style="width: 100px; max-height: 100px;" alt="Img">
                                                        </td>
                                                    @endif
                                                    <td>
                                                        {{ $barang->name ?? '-' }}
                                                    </td>
                                                    @if ($settings['show_keteranganB'] ?? true)
                                                        <td class="column-description-brg">{!! nl2br(e($barang->description)) !!}
                                                        </td>
                                                    @endif
                                                    @if ($settings['show_awalB'] ?? true)
                                                        <td class="text-center column-awal-brg">
                                                            {{ rtrim(rtrim(number_format($barang->awal, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif
                                                    @if ($settings['show_masukB'] ?? true)
                                                        <td class="text-center column-masuk-brg">
                                                            {{ rtrim(rtrim(number_format($barang->masuk, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif
                                                    @if ($settings['show_total_beliB'] ?? true)
                                                        <td class="text-center column-totalB-brg">
                                                            {{ rtrim(rtrim(number_format($barang->total_beli, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif
                                                    @if ($settings['show_keluarB'] ?? true)
                                                        <td class="text-center column-keluar-brg">
                                                            {{ rtrim(rtrim(number_format($barang->keluar, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif
                                                    @if ($settings['show_sisaB'] ?? true)
                                                        <td class="text-center column-sisa-brg">
                                                            {{ rtrim(rtrim(number_format($barang->sisa, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif
                                                    @if ($settings['show_minimumB'] ?? false)
                                                        <td class="text-center column-minimum-brg">
                                                            {{ rtrim(rtrim(number_format($barang->minimum, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif
                                                    <td class="column-satuan-brg">{{ $barang->satuanBarang->name ?? '-' }}</td>
                                                    <td class="column-action-brg">
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
                                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                                style="height: 36px;">
                                                                &#8942;
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton{{ $barang->id }}">
                                                                <li>
                                                                    <button class="dropdown-item btn_editbarang"
                                                                        data-id="{{ $barang->id }}"
                                                                        data-name="{{ $barang->name }}"
                                                                        data-description="{{ $barang->description }}"
                                                                        data-minimum="{{ $barang->minimum }}"
                                                                        data-stok_awal="{{ $barang->stok_awal }}"
                                                                        data-satuan_id="{{ $barang->satuan_id }}"
                                                                        data-image="{{ $barang->image }}">
                                                                        <i class="fa fa-edit me-2"></i>Edit
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('barang.deleteDataBarang') }}"
                                                                        method="post">
                                                                        @method('PUT')
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $barang->id }}">
                                                                        <button
                                                                            class="btn btn-danger btn-sm dropdown-item text-danger"
                                                                            type="submit"
                                                                            onclick="return confirm('Yakin akan Mendelete Data?')">
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
                                            @if($barangs->isEmpty())
                                                <tr>
                                                    <td colspan="100%" class="text-center text-muted py-3">Tidak ada data yang
                                                        ditemukan.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </div>
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
                    <h1 class="modal-title text-primary fw-bold fs-5" id="exampleModalLabel">Tambah Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/barang/data-barang/store' enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" style="width: initial;" class="form-control" name="date" required id="date">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                            <input type="file" class="form-control" id="image" name="image" onchange="previewImage(this)">
                            <small class="form-text text-danger">*Format: jpeg,jpg,png,webp | max:3 MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" required autocomplete="off" class="form-control" id="name" name="name"
                                placeholder="Ketik nama barang...">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control" required id="description" name="description" rows="4"
                                autocomplete="off" placeholder="Ketik deskripsi barang..."></textarea>
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="minimum" class="form-label text-dark fw-bold me-2">Pengingat Stok Minimum</label>
                            <input type="number" min="0" required autocomplete="off" class="form-control number0"
                                max="999999999" id="minimum" name="minimum" value="0" readonly style="max-width: 150px;">
                            <button type="button" class="btn btn-primary ms-2" id="toggleMinimum1">
                                <i id="iconMinimum1" class="fa fa-edit" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="stok_awal" class="form-label text-dark fw-bold">Stok Awal</label>
                            <input type="number" required autocomplete="off" class="form-control number0" id="stok_awal"
                                max="999999999" min="1" name="stok_awal" value="0" placeholder="Ketik stok awal">
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
                    <h1 class="modal-title text-primary fw-bold fs-5" id="exampleModalLabel">Barang Masuk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/barang/manajemen-barang/storeM'>
                        @csrf

                        <div class="mb-3">
                            <input type="text" hidden name="id" id="stokBarangIdM">
                            <label class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" style="width: initial;" class="form-control" name="date" id="stokDateM"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" disabled class="form-control  @error('name') is-invalid @enderror"
                                id="stokBarangNameM">
                            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Jumlah</label>
                            <input type="number" min="1" autocomplete="off" value="0" class="form-control number0"
                                max="999999999" name="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Satuan</label>
                            <input type="text" disabled class="form-control  @error('satuan') is-invalid @enderror"
                                id="stokBarangSatuanM">
                            @error('satuan') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label text-dark fw-bold">Catatan</label>
                            <textarea class="form-control" autocomplete="off" id="stokKeteranganM" required
                                name="keterangan" rows="4" placeholder="Misal: Beli baru atau Beli cash..."></textarea>
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
                    <h1 class="modal-title text-primary fw-bold fs-5" id="exampleModalLabel">Barang Keluar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/barang/manajemen-barang/storeK'>
                        @csrf
                        <input type="hidden" name="id" id="stokBarangIdK">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" style="width: initial;" class="form-control" name="date" id="stokDateK"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" readonly class="form-control" id="stokBarangNameK">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Jumlah</label>
                            <input type="number" min="1" value="0" class="form-control number0" name="jumlah" required
                                max="999999999" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Satuan</label>
                            <input type="text" disabled class="form-control  @error('satuan_id') is-invalid @enderror"
                                id="stokBarangSatuanK">
                            @error('satuan_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label  text-dark fw-bold">Catatan</label>
                            <textarea class="form-control" autocomplete="off" id="stokKeteranganK" required
                                name="keterangan" rows="4" placeholder="Misal: Barang rusak..."></textarea>
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
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Edit Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/barang/data-barang/edit" id="editBarangForm" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="text" name="id" id="txtid">
                            <input hidden type="number" name="stok_awal" id="txtstok_awal">
                            <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="txtimage"
                                name="image">
                            <small class="form-text text-danger">*Format: jpeg,jpg,png,webp | max:3 MB</small>
                            @error('image') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3" id="previewGambar" style="display:none;">
                            <label for="previewGambar" class="form-label text-dark fw-bold">Gambar sebelumnya</label>
                            <img id="previewImage" src="" alt="Preview Gambar" class="img-thumbnail mt-2"
                                style="display: none; width: 100px;">
                            <button type="button" class="btn btn-danger btn-sm mt-2 ms-2" id="btnHapusGambar">
                                <i class="fa fa-trash"></i> Hapus Gambar
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" required autocomplete="off" placeholder="Ketik nama barang"
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
                        <div class="mb-3 d-flex align-items-center">
                            <label for="txtminimum" class="form-label text-dark fw-bold me-2">Pengingat Stok Minimum</label>
                            <input type="number" min="0" required autocomplete="off"
                                class="form-control number0 @error('minimum') is-invalid @enderror" id="txtminimum"
                                max="999999999" name="minimum" value="0" readonly style="max-width: 150px;">
                            <button type="button" class="btn btn-primary ms-2" id="toggleMinimum2">
                                <i id="iconMinimum2" class="fa fa-edit" aria-hidden="true"></i>
                            </button>
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
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white">Ubah</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Filter Barang -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('user.setting.update', 'filter_barang') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5 fw-bold text-primary" id="filterModalLabel">Filter Tampilan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Checkbox Kolom --}}
                        @php
                            $columns = [
                                'show_image_barang' => ['label' => 'Gambar', 'default' => false],
                                'show_keteranganB' => ['label' => 'Deskripsi barang', 'default' => true],
                                'show_awalB' => ['label' => 'Awal', 'default' => true],
                                'show_masukB' => ['label' => 'Masuk', 'default' => true],
                                'show_total_beliB' => ['label' => 'Total Beli', 'default' => true],
                                'show_keluarB' => ['label' => 'Keluar', 'default' => true],
                                'show_sisaB' => ['label' => 'Sisa', 'default' => true],
                                'show_minimumB' => ['label' => 'Minimum', 'default' => false],
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
                            <label for="paginationSelect" class="form-label fw-bold text-dark">Jumlah Per Halaman:</label>
                            <select class="form-select" name="pagination_barang" id="paginationSelect">
                                <option value="20" {{ ($settings['pagination_barang'] ?? 20) == 20 ? 'selected' : '' }}>20
                                </option>
                                <option value="50" {{ ($settings['pagination_barang'] ?? 20) == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ ($settings['pagination_barang'] ?? 20) == 100 ? 'selected' : '' }}>100
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
            function previewImage(input) {
                const preview = document.getElementById('previewImage');
                const btnHapus = document.getElementById('btnHapusGambar');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'inline-block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.getElementById("btnHapusGambar").addEventListener("click", function () {
                const id = document.getElementById("txtid").value;
                if (confirm("Yakin ingin menghapus gambar ini?")) {
                    window.location.href = `/barang/data-barang/delete-image/${id}`;
                }
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

                    inputField.addEventListener("focusout", function lockInput() {
                        inputField.readOnly = true;
                        button.style.display = "inline";
                        inputField.removeEventListener("focusout", lockInput);
                    });
                }
            }
            document.getElementById("toggleMinimum1").addEventListener("click", function () {
                toggleInput("minimum", "toggleMinimum1");
            });
            document.getElementById("toggleMinimum2").addEventListener("click", function () {
                toggleInput("txtminimum", "toggleMinimum2");
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.querySelector('#barangModalM form');
                const submitButton = form.querySelector('button[type="submit"]');

                form.addEventListener('submit', function (e) {
                    // Disable tombol submit supaya tidak bisa diklik lagi
                    submitButton.disabled = true;
                    // Optional: ubah teks tombol jadi "Mengirim..." biar user tahu sedang proses
                    submitButton.textContent = 'Mengirim...';
                });
            });
        </script>
    @endpush

@endsection