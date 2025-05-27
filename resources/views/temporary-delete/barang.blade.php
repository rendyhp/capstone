@extends('layouts.main')
@section('TemporaryDelete', 'active')
@section('container')
@section('title', 'Deleted Barang | Bdim’s Stock')

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

    <div class="container">
        <div class="page-header">
            <h2 class="pageheader-title ">Barang Terhapus</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manajemen Barang Terhapus</li>
                    </ol>
                </nav>
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
            <a href="{{ route('temporary-delete.bahan.index') }}" class="tab-trapezoid">Bahan Terhapus</a>
            <a href="{{ route('temporary-delete.barang.index') }}" class="tab-trapezoid active">Barang Terhapus</a>
            <a href="{{ route('temporary-delete.menu.index') }}" class="tab-trapezoid">Menu Terhapus</a>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2">Daftar Barang Terhapus</div>
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
                                    <a href="{{ route('temporary-delete.barang.index') }}"
                                        class="btn btn-outline-secondary btn-sm" title="Refresh">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <form action="{{ route('temporary-delete.barang.index') }}" method="get"
                                        class="form-inline d-flex">
                                        <input class="form-control form-control-sm" autocomplete="off" type="text"
                                            name="search" placeholder="Cari barang..." value="{{ request('search') }}">
                                    </form>
                                </div>
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal Hapus</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangs as $barang)
                                        <tr>
                                            <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($barang->deleted_at)->translatedFormat('d F Y, H:i') }}
                                                WIB</td>
                                            <td>{{ $barang->name }}</td>
                                            <td>{{ $barang->satuanBarang->name ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex flex-column flex-sm-row gap-2">
                                                    <form action="{{ route('temporary-delete.barang.restore', $barang->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin mengembalikan barang ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fa fa-undo"></i> Restore
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('temporary-delete.barang.force-delete') }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus barang ini secara permanen dari tampilan?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="id" value="{{ $barang->id }}">
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center text-muted py-3">Tidak ada barang terhapus.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $barangs->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection