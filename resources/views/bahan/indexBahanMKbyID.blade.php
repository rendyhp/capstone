@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')
@section('title', "History Input $bahans->name | BdiM’s Stock")

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">History Input {{ $bahans->name }}</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="" href="/bahan/manajemen-bahan">Stok Bahan - Manajemen
                                        Bahan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $bahans->name }}</li>
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
            <a href="/bahan/manajemen-bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/masuk-keluar') ? 'active' : '' }}">
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
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2">History Input {{ $bahans->name }}</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <a href="{{ $previousUrl }}">
                                            <i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali
                                        </a>
                                    </div>
                                    <div class="mb-3 text-center fw-bold">
                                        <img src="{{ asset($bahans->image ?? 'img/dummy/ss_bahan.png') }}"
                                            style="width: 150px; max-height: 150px;" alt="Img">
                                        <p>{{ $bahans->name }}</p>
                                    </div>
                                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-outline-success btnTambahStok"
                                        data-id="{{ $bahans->id ?? 'NULL' }}" data-name="{{ $bahans->name ?? 'NULL'}}"
                                        data-satuan="{{ $bahans->satuan->name ?? '-' }}" data-bs-toggle="modal"
                                        data-bs-target="#barangModalM">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Stok {{ $bahans->name }}
                                    </button>
                                    <div class="col-sm-2 float-end mt-3">
                                        <div class="d-flex gap-2">
                                            <a href="/bahan/masuk-keluar/{{ Hashids::encode($bahans->id) }}"
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
                                                @if (auth()->user()->role === 'OWNER' || auth()->user()->role === 'MANAJER')
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                                    @if (auth()->user()->role === 'OWNER' || auth()->user()->role === 'MANAJER')
                                                        <td>
                                                            <form action="{{ route('bahan.deleteBahanMKbyID') }}" method="post"
                                                                class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $trx['id'] }}">
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin akan Mendelete Data?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            @if ($transaksis->isEmpty())
                                                <tr>
                                                    <td colspan="100%" class="text-center text-muted py-3">Tidak ada data yang
                                                        ditemukan.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </div>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah {{ $bahans->name }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/bahan/manajemen-bahan/storeM'>
                        @csrf

                        <div class="mb-3">
                            <input type="text" hidden name="id" id="stokBarangIdM">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="stokDateM" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Bahan</label>
                            <input type="text" disabled class="form-control  @error('name') is-invalid @enderror"
                                id="stokBarangNameM">
                            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah</label>
                            <input type="number" min="1" class="form-control number0" value="0" autocomplete="off"
                                name="jumlah" required>
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
                                name="keterangan" rows="4" placeholder="Misal: Cash"></textarea>
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