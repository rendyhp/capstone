@extends('layouts.main')
@section('StockOpname', 'active')
@section('container')

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Data Bahan</h2>
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

        <form action="{{ route('stok-bahan-awal') }}" method="GET" class="d-flex align-items-center mb-3">
            <div class="mb-3 row">
                <label for="tanggalbahan" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="tanggalbahan" name="date"
                        value="{{ $date ?? \Carbon\Carbon::today()->toDateString() }}">

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
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                                    </button>
                                    <div class="col-sm-3 float-end mt-3">
                                        <div class="d-flex gap-2">
                                            <a href="/bahan-awal" class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/bahan-awal" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" type="text" name="search"
                                                    placeholder="Search" value="{{ request('search') }}">
                                            </form>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal</th>
                                                <th>Nama Bahan</th>
                                                <th>Stok</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($bahanAwalAwals->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($bahanAwalAwals as $bahanAwal)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $bahanAwal->bahan_name }}</td>
                                                        <td>{{ $bahanAwal->stok }}</td>
                                                        <td>{{ $bahanAwal->satuan_name }}</td>


                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbahan"
                                                                data-id="{{ $bahanAwal->id ?? 'NULL' }}"
                                                                data-name="{{ $bahanAwal->name ?? 'NULL' }}"
                                                                data-description="{{ $bahanAwal->description ?? 'NULL' }}"
                                                                data-minimum="{{ $bahanAwal->minimum ?? 'NULL' }}"
                                                                data-satuan_id="{{ $bahanAwal->satuan_id ?? 'NULL' }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>



                                                            <form action="{{ route('stok-bahan-awal.delete') }}" method="POST"
                                                                class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="bahan_id"
                                                                    value="{{ $bahanAwal->bahan_id }}">
                                                                <input type="hidden" name="date" value="{{ $date }}">
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin akan menghapus semua stok bahan ini untuk tanggal {{ $date }}?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>




                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $bahanAwalAwals->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Barang-->


@endsection