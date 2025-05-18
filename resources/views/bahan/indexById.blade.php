@extends('layouts.main')
@section('StokBarang', 'active')
@section('container')
@section('title', "Barang | BdiM’s Stock")

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
            <a href="/barang/satuan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'barang/satuan') ? 'active' : '' }}">
                Satuan
            </a>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Detail Bahan </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <a href="#" onclick="window.history.back(); return false;">
                                        <i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali
                                    </a>
                                    <div class="col-sm-3 float-end mt-3">

                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/bahan/master/{{ Hashids::encode($bahan->id) }}"
                                                class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>

                                        <div>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                @foreach ($history as $day)
                                                    <th>{{ $day['tanggal'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Data Awal</td>
                                                @foreach ($history as $day)
                                                    <td>{{ $day['awal'] ?? '-' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Input</td>
                                                @foreach ($history as $day)
                                                    <td>{{ $day['masuk'] ?: '-' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Data Akhir</td>
                                                @foreach ($history as $day)
                                                    <td>{{ $day['akhir'] ?? '-' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Terpakai</td>
                                                @foreach ($history as $day)
                                                    <td>{{ $day['pakai'] ?? '-' }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('addScript')
        <script>
            const checkbox = document.getElementById('toggleImageColumn');
            const imageColumns = document.querySelectorAll('.column-gambar');

            checkbox.addEventListener('change', function () {
                imageColumns.forEach(col => {
                    col.style.display = this.checked ? '' : 'none';
                });
            });
        </script>
    @endpush

@endsection