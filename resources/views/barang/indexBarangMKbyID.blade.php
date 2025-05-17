@extends('layouts.main')
@section('StokBarang', 'active')
@section('container')
@section('title', "Masuk/Keluar $barangs->name | BdiM’s Stock")

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
                                <li class="breadcrumb-item"><a class="" href="/barang/masuk-keluar">Stok Barang - Masuk
                                        Keluar</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $barangs->name }}</li>
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
            <a href="/barang/satuan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/satuan') ? 'active' : '' }}">
                Satuan
            </a>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2">History Input {{ $barangs->name }}</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">

                                    <div class="mb-3"> <a href="#" onclick="window.history.back(); return false;">
                                            <i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali
                                        </a>
                                    </div>

                                    <div class="mb-3 text-center fw-bold">
                                        <img src="{{ asset($barangs->image) }}" style="width: 150px; max-height: 150px;"
                                            alt="Img">
                                        <p>{{ $barangs->name }}</p>
                                    </div>



                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-outline-success btnTambahStok"
                                        data-id="{{ $barangs->id ?? 'NULL' }}" data-name="{{ $barangs->name ?? 'NULL'}}"
                                        data-satuan="{{ $barangs->satuanBarang->name ?? '-' }}" data-bs-toggle="modal"
                                        data-bs-target="#barangModalM">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Stok {{ $barangs->name }}
                                    </button>


                                    <!-- Tombol Kurangi -->
                                    <button type="button" class="btn btn-outline-success btnKurangStok"
                                        data-id="{{ $barangs->id ?? 'NULL' }}" data-name="{{ $barangs->name ?? 'NULL'}}"
                                        data-satuan="{{ $barangs->satuanBarang->name ?? '-' }}" data-bs-toggle="modal"
                                        data-bs-target="#barangModalK">
                                        <i class="fa fa-minus me-2" aria-hidden="true"></i>Stok {{ $barangs->name }}
                                        Berkurang
                                    </button>

                                    <div class="col-sm-2 float-end mt-3">
                                        <div class="d-flex gap-2">
                                            <a href="/barang/masuk-keluar/{{ Hashids::encode($barangs->id) }}"
                                                class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Tipe</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                                <th>User</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($transaksis->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($transaksis as $index => $trx)
                                                    <tr>
                                                        <td>{{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($trx['date'])->translatedFormat('d F Y') }}
                                                        </td>
                                                        <td>{{ $trx['name'] ?? '-' }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge {{ $trx['tipe'] === 'MASUK' ? 'bg-success' : ($trx['tipe'] === 'KELUAR' ? 'bg-danger' : ($trx['tipe'] === 'AWAL' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                                                                {{ $trx['tipe'] }}
                                                            </span>
                                                        </td>

                                                        <td class="text-end">{{ number_format($trx['jumlah'], 0, ',', '.') }}</td>
                                                        <td>{{ $trx['satuan'] }}</td>
                                                        <td>{{ $trx['keterangan'] }}</td>
                                                        <td>{{ $trx['user'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $transaksis->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
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

@endsection