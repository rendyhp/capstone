@extends('layouts.main')
@section('Barang', 'active')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title ">Data Barang</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Data Barang</li>
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
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#barangModal">
                                    <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                                </button>
                                <div class="col-sm-2 float-end mt-3">
                                    <form action="/barang" method="get" class="form-inline" onsubmit="">
                                        <input class="form-control form-control-sm" type="text" name="search" placeholder="Search" value="{{request('search')}}">
                                    </form>
                                <div>
                            </div>
                            <thead class="table-primary">
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Tipe Barang</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($Details->isEmpty())
                                    <p>Tidak ada data yang ditemukan.</p>
                                @else
                                    @foreach ($Details as $barang)
                                        <tr>
                                            <td>{{ $barang->barang->barang_code }}</td>
                                            <td>{{ $barang->barang->barang_nama }}</td>
                                            <td>{{ $barang->barang->barang_merk }}</td>
                                            <td>{{ $barang->barang->barang_jenis }}</td>
                                            <td>{{ $barang->barang->barang_tipe }}</td>
                                            <td>{{ $barang->barang->barang_satuan }}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm btn_editbarang" data-id="{{ $barang->id }}"
                                                    data-kode="{{ $barang->barang_code }}" data-nama="{{ $barang->barang_nama }}"
                                                    data-merk="{{ $barang->barang_merk }}" data-jenis=" {{ $barang->barang_jenis }} "
                                                    data-tipe=" {{ $barang->barang_tipe }}" data-satuan="{{ $barang->barang_satuan }}">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </button>

                                                <form action="/barang/{{ $barang->id }}" class="d-inline" method="post">
                                                    @method('DELETE')
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
                        {{ $Details->onEachSide(0.5)->links('pagination::bootstrap-5') }}
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
                <form method="Post" action='/barang'>
                    @csrf
                    <div class="mb-3">
                        <label for="namabarang" class="form-label text-dark fw-bold">Nama Barang</label>
                        <input type="text" class="form-control" id="namabarang" name="namabarang"
                            placeholder="Input Nama Barang">
                    </div>
                    <div class="mb-3">
                        <label for="merkbarang" class="form-label text-dark fw-bold">Merk Barang</label>
                        <input type="text" class="form-control" id="merkbarang" name="merkbarang"
                            placeholder="Input Merk Barang">
                    </div>
                    <div class="mb-3">
                        <label for="jenisbarang" class="form-label text-dark fw-bold">Jenis Barang</label>
                        <input type="text" class="form-control" id="jenisbarang" name="jenisbarang"
                            placeholder="Input Jenis Barang">
                    </div>
                    <div class="mb-3">
                        <label for="tipebarang" class="form-label text-dark fw-bold">Tipe Barang</label>
                        <input type="text" class="form-control" id="tipebarang" name="tipebarang"
                            placeholder="Input Tipe Barang">
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label text-dark fw-bold">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Input Satuan Barang">
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
                    <form action="/barang/edit" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="text" name="id" id="txtid">
                            <label for="kodebarang" class="form-label text-dark fw-bold">Kode Barang</label>
                            <input type="text" class="form-control @error('kodebarang') is-invalid @enderror" id="txtkodebarang"
                                name="kodebarang">
                            @error('kodebarang')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="namabarang" class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" class="form-control @error('namabarang') is-invalid @enderror" id="txtnamabarang"
                                name="namabarang" placeholder="Input Nama Barang">
                            @error('namabarang')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="merkbarang" class="form-label text-dark fw-bold">Merk Barang</label>
                            <input type="text" class="form-control @error('merkbarang') is-invalid @enderror" id="txtmerkbarang"
                                name="merkbarang" placeholder="Input Merk Barang">
                            @error('merkbarang')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenisbarang" class="form-label text-dark fw-bold">Jenis Barang</label>
                            <input type="text" class="form-control @error('jenisbarang') is-invalid @enderror" id="txtjenisbarang"
                                name="jenisbarang" placeholder="Input Jenis Barang">
                            @error('jenisbarang')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipebarang" class="form-label text-dark fw-bold">Tipe Barang</label>
                            <input type="text" class="form-control @error('tipebarang') is-invalid @enderror" id="txttipebarang"
                                name="tipebarang" placeholder="Input Tipe Barang">
                            @error('tipebarang')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label text-dark fw-bold">Satuan</label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="txtsatuan"
                                name="satuan" placeholder="Input Satuan Barang">
                            @error('satuan')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection