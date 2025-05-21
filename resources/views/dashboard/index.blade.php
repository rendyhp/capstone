@extends('layouts.main')
@section('Dashboard', 'active')
@section('container')
@section('title', 'Dashboard | Bdim’s Stock')

    @push('spinner')
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
    @endpush

    @push('addStyle')
        <style>
            .table-responsive {
                overflow-x: auto;
            }

            .table-transaksi {
                font-size: 12px;
                /* Ganti dengan ukuran teks yang Anda inginkan */
            }

            /* Tabel Ketersediaan Stok Barang */
            .table-ketersediaan {
                font-size: 12px;
                /* Ganti dengan ukuran teks yang Anda inginkan */
            }

            .table {
                min-width: 100%;
                width: auto;
                table-layout: auto;
            }

            .rounded-card {
                width: 100%;
                /* Ganti dengan persentase yang diinginkan */
                height: auto;
                border-radius: 50px;
            }

            .card {
                max-width: 100%;
                /* Ganti dengan persentase atau nilai maksimum yang diinginkan */
            }
        </style>
    @endpush

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Dashboard</h2>
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
    <div class="container">
        <div class="row fs-5 fw-bold">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                Welcome {{Auth::user()->name}} <i class="fa fa-user-astronaut me-2"></i>,
            </div>
        </div>
    </div>
    <div class="container">

        <div class="mt-4">
            <h5><i class="fa fa-exclamation-circle text-danger"></i> Barang Melewati Stok Minimum</h5>
            @if($barangs_below_minimum->isEmpty())
                <p class="text-success">Semua stok barang aman.</p>
            @else
                <table class="table table-bordered text-dark table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Stok Minimum</th>
                            <th>Sisa</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs_below_minimum as $barang)
                            <tr>
                                <td>{{ $barang->name }}</td>
                                <td class="text-end">
                                    {{ rtrim(rtrim(number_format($barang->minimum, 3, ',', '.'), '0'), ',') }}
                                </td>
                                <td class="text-end text-danger fw-bold">
                                    {{ rtrim(rtrim(number_format($barang->sisa, 3, ',', '.'), '0'), ',') }}
                                </td>
                                <td>{{ $barang->satuanBarang->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="mt-4">
            <h5><i class="fa fa-exclamation-triangle text-warning"></i> Bahan Melewati Stok Minimum</h5>
            @if($bahans_below_minimum->isEmpty())
                <p class="text-success">Semua stok bahan aman.</p>
            @else
                <table class="table table-bordered text-dark table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama Bahan</th>
                            <th>Bagian</th>
                            <th>Stok Minimum</th>
                            <th>Sisa</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bahans_below_minimum as $bahan)
                            <tr>
                                <td>{{ $bahan->name }}</td>
                                <td>{{ $bahan->section }}</td>
                                <td class="text-end">
                                    {{ rtrim(rtrim(number_format($bahan->minimum, 3, ',', '.'), '0'), ',') }}
                                </td>
                                <td class="text-end text-danger fw-bold">
                                    {{ rtrim(rtrim(number_format($bahan->jumlah_akhir, 3, ',', '.'), '0'), ',') }}
                                </td>
                                <td>{{ $bahan->satuan->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
    <div class="container">

    </div>
@endsection