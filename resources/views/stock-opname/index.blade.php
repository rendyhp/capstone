@extends('layouts.main')
@section('StockOpname', 'active')
@section('container')

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Data Bahan Akhir</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data Bahan Akhir</li>
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

        <form action="{{ route('stock-opname.index') }}" method="GET" class="d-flex align-items-center mb-3">
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
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Bahan Akhir Sebenarnya </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBarang" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success"
                                        onclick="window.location.href='{{ url('/stock-opname/simpan') }}'">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Stock Opname
                                    </button>
                                    <button type="button" class="btn btn-outline-success"
                                        onclick="window.location.href='{{ url('/bahan-awal') }}'">
                                        Lihat Bahan Awal
                                    </button>
                                    <div class="col-sm-3 float-end mt-3">
                                        <div class="d-flex gap-2">
                                            <a href="/stock-opname" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/stock-opname" method="get" class="form-inline d-flex">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text" name="search"
                                                    placeholder="Search" value="{{ request('search') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal</th>
                                                <th>Nama bahan</th>
                                                <th>Stok Akhir</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($bahan_akhirs->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($bahan_akhirs as $bahan_akhir)
                                                    <tr>
                                                        <td>{{ ($bahan_akhirs->currentPage() - 1) * $bahan_akhirs->perPage() + $loop->iteration }}
                                                        </td>

                                                        <td>{{ $bahan_akhir->tanggal }}</td>
                                                        <td>{{ $bahan_akhir->bahan_name }}</td>
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan_akhir->total_jumlah, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                        <td>{{ $bahan_akhir->bahan->satuan_name }}</td>

                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbahan_akhir"
                                                                data-id="{{ $bahan_akhir->bahan->bahan_id }}"
                                                                title="Edit stok bahan ini untuk tanggal {{ $date }}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>

                                                            <form action="/stock-opname/delete/{{ $bahan_akhir->id }}"
                                                                class="d-inline" method="post">
                                                                @method('PUT')
                                                                @csrf
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin akan Mendelete Data?')"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $bahan_akhirs->onEachSide(0.5)->links('pagination::bootstrap-5') }}
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


    <!-- Modal Edit Bahan Akhir -->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Bahan Akhir</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editBahanAkhir" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editBahanAkhirId" name="id">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editDate" class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" required class="form-control" id="editDate" name="date">
                        </div>

                        <div id="editBahanAkhirContainer">
                            <!-- Bahan Akhir akan diisi dengan JS -->
                        </div>

                        <button type="button" class="btn btn-success" id="addEditBahanAkhir">+ Tambah Bahan</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white" name="SaveButton">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection