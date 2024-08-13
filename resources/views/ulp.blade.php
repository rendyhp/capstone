@extends('layouts.main')
@section('ULP','active')
@section('container')
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title">Data ULP</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data ULP</li>
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
                    <div class="card-title mt-2 fs-5 fw-bold"> Tabel Unit Layanan Pelanggan </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered text-dark table-sm" style="" border="1">
                        <div class="mb-3">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ulpModal">
                            <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                            </button>
                            <div class="col-sm-2 mt-3 float-end">
                                <form action="/ulp" method="get" class="form-inline">
                                    <input class="form-control form-control-sm" type="text" name="search" placeholder="Search..." value="{{request('search')}}"></input>
                                </form>
                            </div>
                        </div>
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nama ULP</th>
                                <th>Alamat</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Nama UP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($ULPs->isEmpty())
                                <p>Tidak ada data yang ditemukan.</p>
                        @else  
                            @foreach ($ULPs as $ulp)           
                            <tr>
                                <td>{{ $ulp->id}}</td>
                                <td>{{ $ulp->ulp_nama }}</td>
                                <td>{{ $ulp->ulp_alamat }}</td>
                                <td>{{ $ulp->ulp_latitude}}</td>
                                <td>{{ $ulp->ulp_longitude}}</td>
                                <td>{{ $ulp->up->up_nama}}</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm btn_editULP" data-id="{{ $ulp->id }}" data-nama="{{ $ulp->ulp_nama }}" data-alamat="{{ $ulp->ulp_alamat }}" data-latitude="{{ $ulp->ulp_latitude }}" data-longitude="{{ $ulp->ulp_longitude }}" data-up="{{ $ulp->up_id }}">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                    </button>
                                    
                                    <form action="/ulp/{{ $ulp->id }}" class="d-inline" method="post">
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
        {{ $ULPs->onEachSide(0.5)->links('pagination::bootstrap-5') }}
    </div>
    </div>
</div>
        <!-- Modal Tambah ULP-->

        <div class="modal fade" id="ulpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Tambah Unit Layanan Pelanggan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="Post" action='/ulp'>
            @csrf
                <div class="mb-3">
                    <label for="ulp_id" class="form-label text-dark fw-bold">ID</label>
                    <input type="text" class="form-control" id="ulp_id" name="ulp_id" placeholder="Input ID">
                </div>
                <div class="mb-3">
                    <label for="namaULP" class="form-label text-dark fw-bold">Nama Unit Layanan Pelanggan</label>
                    <input type="text" class="form-control" id="namaULP" name="namaULP" placeholder="Input Nama ULP">
                </div>
                <div class="mb-3">
                    <label for="alamatULP" class="form-label text-dark fw-bold">Alamat Unit Layanan Pelanggan</label>
                    <input type="text" class="form-control" id="alamatULP" name="alamatULP" placeholder="Input Alamat ULP">
                </div>
                <div class="mb-3">
                    <label for="latitudeULP" class="form-label text-dark fw-bold">Latitude</label>
                    <input type="number" class="form-control" id="latitudeULP" name="latitudeULP" placeholder="Input Latitude ULP" step="any">
                </div>
                <div class="mb-3">
                    <label for="longitudeULP" class="form-label text-dark fw-bold">Longitude</label>
                    <input type="number" class="form-control" id="longitudeULP" name="longitudeULP" placeholder="Input Longitude ULP" step="any">
                </div>
                <div class="up-section mb-3">
                    <label for="slcup" class="form-label text-dark fw-bold">Unit Pengatur</label>
                    <div class="mb-3">
                        <select class="form-select text-dark" id="slcup" name="slcup">
                        <option disabled selected>Pilih Opsi</option>
                        @foreach($UPs as $up)
                            <option value="{{$up->id}}">{{$up->id}} - {{ $up->up_nama }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
                </div>
            </form>
        </div>
        </div>

        <!-- Modal Edit ULP-->
        <div class="modal fade" id="editULPModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Form Edit Unit Layanan Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/ulp/edit" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="ulp_id" class="form-label text-dark fw-bold">ID</label>
                            <input type="text" class="form-control @error('ulp_id') is-invalid @enderror" id="txtulp" name="ulp_id" >
                            @error('ulp_id')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="namaULP" class="form-label text-dark fw-bold">Nama Unit Layanan Pelanggan</label>
                            <input type="text" class="form-control @error('namaULP') is-invalid @enderror" id="txtnamaULP" name="namaULP">
                            @error('namaULP')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamatULP" class="form-label text-dark fw-bold">Alamat Unit Layanan Pelanggan</label>
                            <input type="text" class="form-control @error('alamatULP') is-invalid @enderror" id="txtalamatULP" name="alamatULP">
                            @error('alamatULP')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="latitudeULP" class="form-label text-dark fw-bold">Latitude</label>
                            <input type="number" class="form-control @error('latitudeULP') is-invalid @enderror" id="txtlatitude" name="latitudeULP" step="any">
                            @error('latitudeULP')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="longitudeULP" class="form-label text-dark fw-bold">Longitude</label>
                            <input type="number" class="form-control @error('longitudeULP') is-invalid @enderror" id="txtlongitude" name="longitudeULP" step="any">
                            @error('longitudeULP')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="up-section mb-3">
                            <label for="slcup" class="form-label text-dark fw-bold">Unit Pengatur</label>
                            <div class="mb-3">
                                <select class="form-select text-dark" id="slcup" name="slcup">
                                @foreach($UPs as $up)
                                    <option value="{{$up->id}}">{{$up->id}} - {{ $up->up_nama }}</option>
                                @endforeach
                                
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Ubah</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#dropdownMenuButton").click(function() {
            var selectedValue = $(this).attr('href');
            // Kirim permintaan ke server (misalnya, melalui AJAX) dengan nilai yang dipilih
            $.ajax({
                url: selectedValue,
                method: 'GET',
                success: function(data) {
                    // Tampilkan data yang diterima dalam elemen tabel
                    $("#tableBarang").html(data);
                },
                error: function() {
                    // Tangani kesalahan jika diperlukan
                    $("#tableBarang").html("Terjadi kesalahan saat mengambil data.");
                }
            });
        });
    });
</script>
@endsection