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
            <h2 class="pageheader-title ">Manajemen Menu</h2>
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
                        <form action="{{ route('temporary-delete.menu.index') }}" method="get" class="d-flex mb-3">
                            <input type="text" name="search" class="form-control form-control-sm me-2"
                                placeholder="Cari menu..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary btn-sm" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-dark">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No.</th>
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
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">Tidak ada menu terhapus.</td>
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