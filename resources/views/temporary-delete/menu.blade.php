@extends('layouts.main')
@section('TemporaryDelete', 'active')
@section('container')
@section('title', 'Deleted Menu | Bdim’s Stock')

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
            <h2 class="pageheader-title ">Menu Terhapus</h2>
            <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manajemen Menu Terhapus</li>
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
            <a href="{{ route('temporary-delete.barang.index') }}" class="tab-trapezoid">Barang Terhapus</a>
            <a href="{{ route('temporary-delete.menu.index') }}" class="tab-trapezoid active">Menu Terhapus</a>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2">Daftar Menu Terhapus</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-dark">
                                <div class="d-flex gap-2 mb-2 col-sm-4 float-end">
                                    <a href="{{ route('temporary-delete.menu.index') }}"
                                        class="btn btn-outline-secondary btn-sm" title="Refresh">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <form action="{{ route('temporary-delete.menu.index') }}" method="get"
                                        class="form-inline d-flex">
                                        <input class="form-control form-control-sm" autocomplete="off" type="text"
                                            name="search" placeholder="Cari menu..." value="{{ request('search') }}">
                                    </form>
                                </div>
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal Hapus</th>
                                        <th>Gambar</th>
                                        <th>Nama Menu</th>
                                        <th>Komposisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($menus as $menu)
                                        <tr>
                                            <td>{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($menu->deleted_at)->translatedFormat('d F Y, H:i') }}
                                                WIB</td>
                                            <td>
                                                <img src="{{ asset($menu->image ?? 'img/dummy/ss_menu.png') }}"
                                                    style="width: 100px; max-height: 100px;" alt="Img">
                                            </td>
                                            <td>{{ $menu->name }}</td>
                                            <td>
                                                @if ($menu->komposisi && $menu->komposisi->count())
                                                    <ul class="mb-0 ps-3">
                                                        @foreach ($menu->komposisi as $item)
                                                            <li>
                                                                {{ $item->bahan->name ?? '-' }}
                                                                ({{ rtrim(rtrim(number_format($item->jumlah, 3, ',', '.'), '0'), ',') . ' ' . ($item->bahan->satuan->name ?? '-') }})
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('temporary-delete.menu.restore', $menu->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin mengembalikan menu ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fa fa-undo"></i> Restore
                                                    </button>
                                                </form>

                                                <form action="{{ route('temporary-delete.menu.force-delete') }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus menu ini secara permanen dari tampilan?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{ $menu->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm mt-1">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center text-muted py-3">Tidak ada menu terhapus.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $menus->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection