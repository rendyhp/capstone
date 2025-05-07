@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Stok Bahan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bahan Awal</li>
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
        <form action="/bahan-awal" method="GET" class="d-flex align-items-center mb-3">
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
        <div>
            <a href="/bahan/master"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/master') ? 'active' : '' }}">
                Master
            </a>

            <a href="/bahan/masuk-keluar"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/masuk-keluar') ? 'active' : '' }}">
                Bahan Masuk/Keluar
            </a>
            <a href="/bahan/bahan-awal"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/bahan-awal') ? 'active' : '' }}">
                Bahan Awal
            </a>
            <a href="/bahan/data-bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/data-bahan') ? 'active' : '' }}">
                Data Bahan
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
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Bahan Awal</div>
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
                                            <a href="/bahan/bahan-awal" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/bahan/bahan-awal" method="get" class="form-inline d-flex">
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
                                                        <td>{{ ($bahanAwalAwals->currentPage() - 1) * $bahanAwalAwals->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($bahanAwal->date)->translatedFormat('d F Y') }}
                                                        </td>
                                                        <td>{{ $bahanAwal->bahan_name }}</td>
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahanAwal->stok, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                        <td>{{ $bahanAwal->satuan_name }}</td>


                                                        <td>
                                                            <!-- Button trigger modal edit stok bahan awal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbahan"
                                                                data-id="{{ $bahanAwal->bahan_id }}"
                                                                title="Edit stok bahan ini untuk tanggal {{ $date }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>

                                                            <form action="{{ route('bahan.deleteBahanAwal') }}" method="POST"
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

    <!-- Hidden HTML untuk opsi bahan -->
    <div id="bahanOptions" class="d-none">
        <select class="form-select">
            @foreach($bahans as $bahan)
                <option value="{{ $bahan->id }}" data-satuan="{{ $bahan->satuan->name }}">
                    {{ $bahan->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Modal Tambah Bahan Awal -->
    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Bahan Awal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/bahan/bahan-awal/store">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="date" class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" required class="form-control" id="date" name="date">
                        </div>

                        <div id="bahanAwalContainer">
                            <!-- Akan diisi oleh JS -->
                        </div>
                        <button type="button" class="btn btn-success" id="addBahanAwal">+ Tambah Bahan</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white" name="SaveButton">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Bahan Awal -->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Bahan Awal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editBahanAwalForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editBahanAwalId" name="id">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editDate" class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" required class="form-control" id="editDate" name="date">
                        </div>

                        <div id="editBahanAwalContainer">
                            <!-- Bahan awal akan diisi dengan JS -->
                        </div>
                        <button type="button" class="btn btn-success" id="addEditBahanAwal">+ Tambah Bahan</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white" name="SaveButton">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>







@endsection