@extends('layouts.main')
@section('StokBarang', 'active')
@section('container')
@section('title', "Barang Masuk/Keluar | B.di.M’s Stock")

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
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Cari barang masuk/keluar..." value="{{ request('search') }}">
                                            </form>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="column-nomor-MKall">No.</th>
                                                <th class="column-date-MKall">Tanggal</th>
                                                <th class="column-name-MKall">Nama Barang</th>
                                                <th class="text-center column-type-MKall">Tipe</th>
                                                <th class="column-jumlah-MKall">Jumlah</th>
                                                <th class="column-satuan-MKall">Satuan</th>
                                                <th class="column-keterangan-MKall">Keterangan</th>
                                                <th class="column-user-MKall">User</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksis as $index => $trx)
                                                <tr>
                                                    <td class="column-nomor-MKall">{{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="column-date-MKall">{{ \Carbon\Carbon::parse($trx['date'])->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td class="column-name-MKall">
                                                        <a href="/barang/masuk-keluar/{{ Hashids::encode($trx['barang_id']) }}"
                                                            class="text-decoration-none text-dark">
                                                            {{ $trx['name'] ?? '-' }}
                                                        </a>
                                                    </td>

                                                    <td class="text-center column-type-MKall">
                                                        <span
                                                            class="badge {{ $trx['tipe'] === 'MASUK' ? 'bg-success' : ($trx['tipe'] === 'KELUAR' ? 'bg-danger' : ($trx['tipe'] === 'AWAL' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                                                            {{ $trx['tipe'] }}
                                                        </span>
                                                    </td>

                                                    <td class="text-end column-jumlah-MKall">{{ number_format($trx['jumlah'], 0, ',', '.') }}</td>
                                                    <td class="column-satuan-MKall">{{ $trx['satuan'] }}</td>
                                                    <td class="column-keterangan-MKall">
                                                        {!! nl2br(e($trx['keterangan'])) !!}
                                                    </td>
                                                    <td class="column-user-MKall">{{ $trx['user'] }}</td>
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