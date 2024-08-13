@extends('layouts.main')
@section('UP','active')
@section('container')
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title">Data UP</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data UP</li>
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
                    <div class="card-title mt-2 fs-5 fw-bold"> Tabel Unit Pengatur </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered text-dark table-sm" style="" border="1">
                    <div class="mb-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#upModal">
                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                        </button>
                        <div class="col-sm-2 float-end mt-3">
                            <form action="/user" method="get" class="form-inline">
                                <input class="form-control form-control-sm" type="text" name="search" placeholder="Search.." value="{{ request('search') }}">
                            </form>
                        <div>       
                    </div>
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama UP</th>
                            <th>Alamat</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($UPs->isEmpty())
                            <p>Tidak ada data yang ditemukan.</p>
                    @else  
                        @foreach ($UPs as $up)           
                        <tr>

                            <td>{{ $up->id }}</td>
                            <td>{{ $up->up_nama }}</td>
                            <td>{{ $up->up_alamat }}</td>
                            <td>{{ $up->latitude}}</td>
                            <td>{{ $up->longitude}}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm btn_editUP" data-id="{{ $up->id }}" data-nama="{{ $up->up_nama }}" data-alamat="{{ $up->up_alamat }}" data-latitude="{{ $up->latitude }}" data-longitude="{{ $up->longitude }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </button>
                                
                                <form action="/up/{{ $up->id }}" class="d-inline" method="post">
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
                {{ $UPs->onEachSide(0.5)->links('pagination::bootstrap-4') }}
            </div>
    </div>
</div>
        <!-- Modal Tambah UP-->

        <div class="modal fade" id="upModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Tambah Unit Pengatur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="Post" action='/up'>
            @csrf
                <div class="mb-3">
                    <label for="up_id" class="form-label text-dark fw-bold">ID</label>
                    <input type="text" class="form-control" id="up_id" name="up_id" placeholder="Input ID">
                </div>
                <div class="mb-3">
                    <label for="namaUP" class="form-label text-dark fw-bold">Nama Unit Pengatur</label>
                    <input type="text" class="form-control" id="namaUP" name="namaUP" placeholder="Input Nama UP">
                </div>
                <div class="mb-3">
                    <label for="alamatUP" class="form-label text-dark fw-bold">Alamat Unit Pengatur</label>
                    <input type="text" class="form-control" id="alamatUP" name="alamatUP" placeholder="Input Alamat UP">
                </div>
                <div class="mb-3">
                    <label for="latitudeUP" class="form-label text-dark fw-bold">Latitude</label>
                    <input type="number" class="form-control" id="latitudeUP" name="latitudeUP" placeholder="Input Latitude UP" step="any">
                </div>
                <div class="mb-3">
                    <label for="longitudeUP" class="form-label text-dark fw-bold">Longitude</label>
                    <input type="number" class="form-control" id="longitudeUP" name="longitudeUP" placeholder="Input Longitude UP" step="any">
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
                </div>
            </form>
        </div>
        </div>

        <!-- Modal Edit UP-->
        <div class="modal fade" id="editUPModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Form Edit Unit Pengatur</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/up/edit" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="up_id" class="form-label text-dark fw-bold">ID</label>
                            <input type="text" class="form-control @error('up_id') is-invalid @enderror" id="txtid" name="up_id" >
                            @error('up_id')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="namaUP" class="form-label text-dark fw-bold">Nama Unit Pengatur</label>
                            <input type="text" class="form-control @error('namaUP') is-invalid @enderror" id="txtnamaUP" name="namaUP">
                            @error('namaUP')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamatUP" class="form-label text-dark fw-bold">Alamat Unit Pengatur</label>
                            <input type="text" class="form-control @error('alamatUP') is-invalid @enderror" id="txtalamatUP" name="alamatUP">
                            @error('alamatUP')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="latitudeUP" class="form-label text-dark fw-bold">Latitude</label>
                            <input type="number" class="form-control @error('latitudeUP') is-invalid @enderror" id="txtlatitude" name="latitudeUP" step="any">
                            @error('latitudeUP')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="longitudeUP" class="form-label text-dark fw-bold">Longitude</label>
                            <input type="number" class="form-control @error('longitudeUP') is-invalid @enderror" id="txtlongitude" name="longitudeUP" step="any">
                            @error('longitudeUP')
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
         
@endsection