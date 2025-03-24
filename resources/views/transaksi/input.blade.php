@extends('layouts.main')
@section('container')

<style>
    .cards {
        height: auto;
        background-color: #f7fcfb; /* Warna biru muda */
        border-radius: 10px; /* Sudut card membulat */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Efek bayangan card */
        padding: 20px;
 /* Ruang dalam card */
    }

    .cards h3 {
        color: #333; /* Warna teks */
    }

    .cards p {
        color: #555; /* Warna teks */
    }
</style>
<div class="container cards">
<a href={{url('/transaksi')}}><i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali</a>
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

@if(session()->has('error'))
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
<form id="transaksi-form" action="{{ route('transaksi.simpanmasuk') }}" method="POST">
@csrf
<h2 style="text-align: center;" class="mt-3 text-uppercase fs-2">Barang Masuk</h2>
<div class="container row">
  <div class="col-sm-6 mb-3 mb-sm-0 p-2 m-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><p class="fs-3 text-decoration-underline">Transaksi</p></h5>
        <p class="card-text">
            <div class="mb-3 row">
                <label for="tanggaltransmasuk" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control datepicker-date" id="tanggaltransmasuk" name="tanggaltransmasuk" value="Input Tanggal">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="slcupmasuk" class="col-sm-2 col-form-label ">UP</label>
                    <div class="col-sm-10">
                        <select class="form-select text-dark" id="slcupmasuk" name="slcupmasuk">
                            <option disabled selected>Pilih Opsi</option>   
                            @foreach($UPs as $up)
                                <option value="{{$up->id}}">{{$up->id}} - {{ $up->up_nama }}</option>
                            @endforeach                   
                        </select>
                    </div>
            </div>
            <div class="mb-3 row">
                <label for="slculpmasuk" class="col-sm-2 col-form-label ">ULP</label>
                    <div class="col-sm-10">
                        <select class="form-select text-dark" id="slculpmasuk" name="slculpmasuk">
                            <option disabled selected>Pilih Opsi</option>
                            @foreach($ULPs as $ulp)
                                <option value="{{$ulp->id}}">{{$ulp->id}} - {{ $ulp->ulp_nama }}</option>
                            @endforeach                           
                        </select>
                    </div>
            </div>
        </p>
        </div>
    </div>
  </div>
</div>
<div class="card p-2 m-4">
  <div class="card-body">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="search" class="col-form-label fw-bold fs-5">Cari Barang</label>
        </div>
        <div class="col-auto">
                <input list="searchResults" type="text" id="searchInput" placeholder="Kata kunci pencarian">
                <datalist id="searchResults">
                    
                </datalist>
                <button type="submit" id="searchButton" class="btn btn-success btn-sm">Cari</button>
        </div>
    </div>
</div>
<div class="border border-primary-emphasis p-2 mb-2">
    <div class="mb-auto text-sm">    
        <table id="search-result" class="table table-bordered text-dark table-sm" style="text-align: center;" border="1">
            <thead class="table-primary">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Merk Barang</th>
                    <th>Jenis Barang</th>
                    <th>Tipe Barang</th>
                    <th>Satuan Barang</th>
                    <th>Barang Quantity</th>
                    <th>Barang SN</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tampilBarang">
            
            </tbody>
                
            </tbody>
        </table>
    </div>
</div>
<a class="d-grid justify-content-md-end">
    <button type="submit" onclick="simpanDataMasuk()" class="btn btn-success">
        Simpan
    </button>
</a>
</form>
@endsection
