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
                                    <div class="col-sm-2 float-end mt-3">
                                    <div class="d-flex gap-2">
                                            <a href="/stock-opname" class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/stock-opname" method="get" class="form-inline d-flex">
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
                                                        <td>
                                                            @if (strpos($bahan_akhir->total_jumlah, '.') === false)
                                                                {{ intval($bahan_akhir->total_jumlah) }}
                                                            @else
                                                                {{ rtrim(rtrim($bahan_akhir->total_jumlah, '0'), '.') }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $bahan_akhir->bahan->satuan_name }}</td>

                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbahan_akhir"
                                                                data-id="{{ $bahan_akhir->id ?? 'NULL' }}"
                                                                data-date="{{ $bahan_akhir->date ?? 'NULL' }}"
                                                                data-jumlah="{{ $bahan_akhir->jumlah ?? 'NULL' }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
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
    <!-- Modal Tambah Barang-->

    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Tambah Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/stock-opname'>
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" required class="form-control" id="date" name="date">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold">Nama Bahan</label>
                            <input type="text" required class="form-control" id="name" name="name"
                                placeholder="Input Nama Barang" value="Contoh nama" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Jumlah</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Input Deskripsi Barang" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label text-dark fw-bold">Satuan</label>
                            <input type="number" required class="form-control" id="jumlah" name="jumlah"
                                placeholder="Input Stok Barang" value="gram" disabled>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Barang-->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Form Edit Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/data-barang/edit" id="editBarangForm" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="text" name="id" id="txtid">
                            <label for="name" class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" required class="form-control @error('name') is-invalid @enderror"
                                id="txtname" name="name">
                            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                id="txtdescription" name="description">
                            @error('description') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label text-dark fw-bold">Jumlah</label>
                            <input type="number" required class="form-control @error('jumlah') is-invalid @enderror"
                                id="txtjumlah" name="jumlah">
                            @error('jumlah') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="satuan" class="form-label text-dark fw-bold">Satuan</label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="txtsatuan"
                                name="satuan">
                            @error('satuan') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="txtimage"
                                name="image">
                            <img id="previewImage" src="" alt="Preview Gambar" class="img-thumbnail mt-2"
                                style="display: none; width: 100px;">
                            @error('image') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white">Ubah</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection