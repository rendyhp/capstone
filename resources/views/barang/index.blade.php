@extends('layouts.main')
@section('DataBarang', 'active')
@section('container')

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Stok Barang</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Stok Barang</li>
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
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Barang </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBarang" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                                    </button>
                                    <div class="col-sm-2 float-end mt-3">
                                        <form action="/data-barang" method="get" class="form-inline" onsubmit="">
                                            <input class="form-control form-control-sm" type="text" name="search"
                                                placeholder="Search" value="{{request('search')}}">
                                        </form>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama barang</th>
                                                <th>Stok</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($barangs->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($barangs as $barang)
                                                    <tr>
                                                        <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td>{{ $barang->name }}</td>
                                                        <td>
                                                            @if (strpos($barang->jumlah, '.') === false)
                                                                {{ intval($barang->jumlah) }}
                                                            @else
                                                                {{ rtrim(rtrim($barang->jumlah, '0'), '.') }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $barang->satuanBarang->name ?? '-' }}</td>

                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbarang"
                                                                data-id="{{ $barang->id ?? 'NULL' }}"
                                                                data-name="{{ $barang->name ?? 'NULL' }}"
                                                                data-description="{{ $barang->description ?? 'NULL' }}"
                                                                data-jumlah="{{ $barang->jumlah ?? 'NULL' }}"
                                                                data-satuan="{{ $barang->satuan ?? 'NULL' }}"
                                                                data-image="{{ $barang->image ?? 'NULL' }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>

                                                            <form action="/data-barang/delete/{{ $barang->id }}" class="d-inline"
                                                                method="post">
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
                            {{ $barangs->onEachSide(0.5)->links('pagination::bootstrap-5') }}
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/data-barang'>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" required autocomplete="off" class="form-control" id="name" name="name"
                                placeholder="Ketik nama barang">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control" required id="description" name="description" rows="4"
                                autocomplete="off" placeholder="Ketik deskripsi barang"></textarea>

                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label text-dark fw-bold">Stok</label>
                            <input type="number" required autocomplete="off" class="form-control number0" id="jumlah"
                                name="jumlah" value="0" placeholder="Ketik jumlah stok">
                        </div>
                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control" required autocomplete="off" id="satuan_id" name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuanBarangs as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label text-dark fw-bold">Gambar Barang</label>
                            <input type="file" class="form-control" id="image" name="image">
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
                            <input type="text" required autocomplete="off"
                                class="form-control @error('name') is-invalid @enderror" id="txtname" name="name">
                            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" autocomplete="off"
                                id="txtdescription" required name="description" rows="4"
                                placeholder="Ketik deskripsi barang"></textarea>
                            @error('description') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label text-dark fw-bold">Stok</label>
                            <input type="number" value="0" required autocomplete="off"
                                class="form-control number0 @error('jumlah') is-invalid @enderror" id="txtjumlah"
                                name="jumlah">
                            @error('jumlah') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control select2" id="txtsatuan_id" required autocomplete="off"
                                name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuanBarangs as $satuan)
                                    <option value="{{ $satuan->id }}" {{ old('tsatuan_id', $bahan->satuan_id ?? '') == $satuan->id ? 'selected' : '' }}>
                                        {{ $satuan->name }}
                                    </option>
                                @endforeach
                            </select>
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