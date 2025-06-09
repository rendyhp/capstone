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
        @include('layouts.components.alert-flash-messages')
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
                            <table class="table table-bordered table-sm text-dark">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Data terhapus hanya tersimpan selama 30 hari">
                                        <i class="fa fa-info-circle me-2" aria-hidden="true"></i>Data terhapus hanya
                                        tersimpan selama 30 hari
                                    </button>
                                </div>
                                <div class="d-flex gap-2 mb-2 col-sm-4 float-end">
                                    <a href="{{ route('temporary-delete.bahan.index') }}"
                                        class="btn btn-outline-secondary btn-sm" title="Refresh">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <form action="{{ route('temporary-delete.bahan.index') }}" method="get"
                                        class="form-inline d-flex">
                                        <input class="form-control form-control-sm" autocomplete="off" type="text"
                                            name="search" placeholder="Cari bahan..." value="{{ request('search') }}">
                                    </form>
                                </div>
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal Hapus</th>
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
                                            <td>{{ \Carbon\Carbon::parse($bahan->deleted_at)->translatedFormat('d F Y, H:i') }}
                                                WIB</td>
                                            <td>{{ $bahan->name }}</td>
                                            <td>{{ $bahan->section }}</td>
                                            <td>{{ $bahan->satuan->name ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex flex-column flex-sm-row gap-2">
                                                    <form action="{{ route('temporary-delete.bahan.restore', $bahan->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin mengembalikan bahan ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fa fa-undo"></i> Restore
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('temporary-delete.bahan.force-delete') }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus bahan ini secara permanen dari tampilan?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="id" value="{{ $bahan->id }}">
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center text-muted py-3">Tidak ada bahan terhapus.
                                            </td>
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