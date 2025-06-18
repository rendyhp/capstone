@extends('layouts.main')
@section('Laporan', 'active')
@section('container')
@section('title', 'Manajemen Bahan | Bdim’s Stock')

    @php
        $currentUrl = request()->path();
    @endphp

    @push('addStyle')
        <style>
            table.table-bordered tbody tr td,
            table.table-bordered thead tr th {
                width: 12vh;
                max-width: 12vh;
                min-width: 12vh;
                text-align: center;
            }

            table.table-bordered tbody tr td:first-child,
            table.table-bordered thead tr th:first-child {
                width: auto;
                max-width: none;
                min-width: auto;
                text-align: left;
            }

            table.table-bordered tbody tr td:first-child,
            table.table-bordered thead tr th:first-child {
                width: 10vh;
                max-width: 10vh;
                min-width: 10vh;
                text-align: left;
            }

            .card-body.maxHeightTable {
                max-height: 68vh;
                overflow-y: auto;
            }

            table.table-bordered tbody tr td:nth-child(2),
            table.table-bordered thead tr th:nth-child(2) {
                text-align: left !important;
                padding-left: 8px !important;
            }
        </style>
    @endpush

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Laporan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Laporan - Barang</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
       @include('layouts.components.alert-flash-messages')
        <div>
            <a href="/laporan/bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'laporan/bahan') ? 'active' : '' }}">
                Bahan
            </a>
             <a href="/laporan/loss-bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'laporan/loss-bahan') ? 'active' : '' }}">
                Bahan Loss
            </a>
            <a href="/laporan/barang"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'laporan/barang') ? 'active' : '' }}">
                Barang
            </a>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Laporan Stok Barang</div>
                    </div>

                    <div class="card-body maxHeightTable">
                        <div class="mb-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('laporan.exportBarangPdf') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-file-pdf"></i> Export PDF
                            </a>
                            <a href="{{ route('laporan.exportBarangWord') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-file-word"></i> Export Word
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-dark table-sm">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Awal</th>
                                        <th>Stok Masuk</th>
                                        <th>Total Beli</th>
                                        <th>Keluar</th>
                                        <th>Sisa</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $index => $barang)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $barang->name }}</td>
                                            <td>{{ $barang->awal }}</td>
                                            <td>{{ $barang->masuk }}</td>
                                            <td>{{ $barang->total_beli }}</td>
                                            <td>{{ $barang->keluar }}</td>
                                            <td>{{ $barang->sisa }}</td>
                                            <td>{{ $barang->satuanBarang->name ?? '-' }}</td>
                                    </tr>@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection