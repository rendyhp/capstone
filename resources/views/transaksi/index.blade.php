@extends('layouts.main')
@section('Transaksi','active')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title">Data Transaksi</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
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
                    <div class="card-title fs-5 fw-bold mt-2"> Tabel Transaksi </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableBarang" class="table table-bordered text-dark table-sm" style="" border="1">
                            <div class="mb-3">
                                <a href="trans/input">
                                    <button action="" type="submit" class="btn btn-outline-success mt-3">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                        Barang Masuk
                                    </button>
                                </a>

                                <a href="trans/keluar">
                                    <button action="" type="submit" class="btn btn-outline-success mt-3">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                        Barang Keluar
                                    </button>
                                </a>
                                <div class="dropdown mt-3 float-end me-2">
                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                        All
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="{{ url('transaksi') }}">All</a></li>
                                        <li><a class="dropdown-item" href="{{ url('trans/barangmasuk') }}">Barang Masuk</a></li>
                                        <li><a class="dropdown-item" href="{{ url('trans/barangkeluar') }}">Barang Keluar</a></li>
                                    </ul>
                                </div>
                            </div>
                                <thead class="table-primary">
                                    <tr>
                                        <th>Kode Trans</th>
                                        <th>Tanggal Transaksi</th> 
                                        <th>Jenis Transaksi</th>
                                        <th>UP</th>
                                        <th>ULP</th> 
                                        <th>Aksi</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transaksis->isEmpty())
                                        <p>Tidak ada data yang ditemukan.</p>
                                    @else  
                                        @foreach ($transaksis as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->kode_trans }}</td>
                                            <td>{{ $transaksi->tanggal_trans }}</td>
                                            <td>{{ $transaksi->trans_jenis}}</td>
                                            <td>{{ $transaksi->up->up_nama }}</td>
                                            <td>{{ optional($transaksi->ulp)->ulp_nama }}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <form action="/transaksi/{{$transaksi->id}}" class="d-inline" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" type="submit"
                                                        onclick="return confirm('Yakin akan Mendelete Data?')"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                                <a href="{{ route('transaksi.detail', $transaksi->id) }}" class="btn btn-primary">Detail Barang</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $transaksis->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
@endsection