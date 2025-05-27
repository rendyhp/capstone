@extends('layouts.main')
@section('TemporaryDelete', 'active')
@section('container')
@section('title', 'Deleted Bahan | Bdim’s Stock')

    @push('addStyle')
        <style>
            .widthKolom8 {
                min-width: 8vh;
            }

            .widthKolom18 {
                min-width: 18vh
            }
        </style>
    @endpush

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Bahan Terhapus</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manajemen Bahan Terhapus</li>
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
            <a href="{{ route('temporary-delete.bahan.index') }}"
                class="tab-trapezoid {{ request()->is('protected/temporary-delete/bahan') ? 'active' : '' }}">
                Bahan Terhapus
            </a>
            <a href="{{ route('temporary-delete.barang.index') }}"
                class="tab-trapezoid {{ request()->is('protected/temporary-delete/barang') ? 'active' : '' }}">
                Barang Terhapus
            </a>
            <a href="{{ route('temporary-delete.menu.index') }}"
                class="tab-trapezoid {{ request()->is('protected/temporary-delete/menu') ? 'active' : '' }}">
                Menu Terhapus
            </a>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2">Daftar Bahan Terhapus</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('temporary-delete.bahan.index') }}" method="get" class="d-flex mb-3">
                                <input type="text" name="search" class="form-control form-control-sm me-2" autocomplete="off"
                                    placeholder="Cari bahan..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary btn-sm" type="submit"><i
                                        class="fa fa-search"></i></button>
                            </form>

                            <table class="table table-bordered table-sm text-dark">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Bahan</th>
                                        <th>Bagian</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bahans as $bahan)
                                        <tr>
                                            <td>{{ ($bahans->currentPage() - 1) * $bahans->perPage() + $loop->iteration }}</td>
                                            <td>{{ $bahan->name }}</td>
                                            <td>{{ $bahan->section }}</td>
                                            <td>{{ $bahan->satuan->name ?? '-' }}</td>
                                            <td>
                                                <form action="{{ route('temporary-delete.bahan.restore', $bahan->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin mengembalikan bahan ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-undo"></i> Restore
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">Tidak ada bahan terhapus.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $bahans->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection