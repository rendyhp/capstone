@extends('user.main')
@section('Transaksi','active')
@section('container')
<style>
  .size-text {
    font-size: 12px;
  }
  .clickable-element {
    transition: background-color 0.3s, transform 0.3s;
    cursor: pointer;
  }

  .clickable-element:hover {
    transform: scale(0.9);
  }
</style>
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title">Data Transaksi</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Beranda</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{url('trans/keluar')}}" class="border border-light rounded d-flex flex-column clickable-element justify-content-center align-items-center bg-light" style="height: 150px; width: 130px;">
    <div class="border border-white rounded d-flex justify-content-center align-items-center mt-2" style="height: 130px; width: 110px;">
        <img src="/img/barangout.png" class="align-middle" style="height: 50px; width: 50px;">
        </img>   
    </div>
    <p class="size-text text-dark fw-bold text-center mt-2">Ambil Barang</p>
</a>

<a href="{{url('transaksi')}}" class="border border-white rounded d-flex flex-column clickable-element justify-content-center align-items-center bg-light ms-2" style="height: 150px; width: 130px;">
    <div class="border border-white rounded d-flex justify-content-center align-items-center mt-2" style="height: 130px; width: 110px;">
        <img src="/img/riwayat.png" class="align-middle" style="height:50px; width: 50px;"></img>
    </div>
    <p class="size-text text-dark fw-bold text-center mt-2">Riwayat Transaksi</p>
</a>
@endsection