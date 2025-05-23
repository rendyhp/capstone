@extends('layouts.main')
@section('StokBarang', 'active')
@section('container')
@section('title', "Barang Masuk/Keluar | BdiM’s Stock")

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
                                <li class="breadcrumb-item active" aria-current="page">Stok Barang - Masuk/Keluar</li>
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
            <a href="/barang/manajemen-barang"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/manajemen-barang') ? 'active' : '' }}">
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
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Bahan Masuk/Keluar</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <div class="col-sm-3 float-end mt-3">
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/barang/masuk-keluar" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/barang/masuk-keluar" method="get" class="form-inline d-flex">
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
                                            @foreach ($transaksis as $index => $trx)
                                                <tr>
                                                    <td>{{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($trx['date'])->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td>
                                                        <a href="/barang/masuk-keluar/{{ Hashids::encode($trx['barang_id']) }}"
                                                            class="text-decoration-none text-dark">
                                                            {{ $trx['name'] ?? '-' }}
                                                        </a>
                                                    </td>

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
                                            @if($transaksis->isEmpty())
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

@endsection