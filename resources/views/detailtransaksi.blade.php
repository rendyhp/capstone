@extends('layouts.main')
@section('DetailTransaksi','active')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title">Detail Transaksi</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a class="" href="/transaksi">Transaksi </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
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
                    <div class="card-title fs-5 fw-bold mt-2"> Tabel Detail Transaksi </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-dark table-sm" style="" border="1">
                        </div>
                            <thead class="table-primary">
                                <tr>
                                    <th>Detail Transaksi Id</th>
                                    <th>Kode Trans</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Tipe Barang</th>
                                    <th>Satuan</th>
                                    <th>Barang Quantity</th>
                                    <th>Barang Serial Number</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($transaksis->isEmpty())
                                        <p>Tidak ada data yang ditemukan.</p>
                            @else 
                                    @foreach ($detailtransaksis as $detail_transaksi)
                                    <td>{{ $detail_transaksi->id }}</td>
                                    <td class="text-start">{{ $detail_transaksi->transaksi->kode_trans }}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang->barang_code}}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang->barang_nama}}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang->barang_merk}}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang->barang_jenis}}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang->barang_tipe}}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang->barang_satuan}}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang_quantity }}</td>
                                    <td class="text-start">{{ $detail_transaksi->barang_sn }}</td>
                                    <td class="text-start">{{ $detail_transaksi->status}}
                                    <td class="text-start">{{ $detail_transaksi->keterangan}}
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection