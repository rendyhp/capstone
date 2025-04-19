@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Stok Bahan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Bahan</li>
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

        <form action="/stok-bahan" method="GET" class="d-flex align-items-center mb-3">
            <div class="mb-3 row">
                <label for="tanggalbahan" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="tanggalbahan" name="date" value="{{ $date }}">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Bahan </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">

                                    <div class="col-sm-3 float-end">
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/stok-bahan" class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/stok-bahan" method="get" class="form-inline d-flex">
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
                                                <th>Nama Bahan</th>
                                                <th>Bahan Awal</th>
                                                <th>Input Bahan</th>
                                                <th>Bahan terpakai</th>
                                                <th>Jumlah Akhir</th>
                                                <th>Bahan Akhir</th>
                                                <th>Bahan Terbuang</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($bahans->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($bahans as $bahan)
                                                    <tr>
                                                        <td>{{ ($bahans->currentPage() - 1) * $bahans->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td>{{ $bahan->name }}</td>
                                                        <td class="text-end">
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
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->bahan_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->bahan_terbuang, 3, ',', '.'), '0'), ',') }}
                                                        </td>

                                                        <td>{{ $bahan->satuan->name ?? '-' }}</td>

                                                        <td>
                                                            <button type="button" class="btn btn-outline-success"
                                                                onclick="window.location.href='{{ route('stok-bahan.historyBahan', ['encryptedId' => Hashids::encode($bahan->id)]) }}'">
                                                                <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Stok
                                                            </button>
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $bahans->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection