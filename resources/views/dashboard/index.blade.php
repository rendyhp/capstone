@extends('layouts.main')
@section('Dashboard','active')
@section('container')

<style>
.table-responsive {
    overflow-x: auto;
}
.table-transaksi {
    font-size: 12px; /* Ganti dengan ukuran teks yang Anda inginkan */
}

/* Tabel Ketersediaan Stok Barang */
.table-ketersediaan {
    font-size: 12px; /* Ganti dengan ukuran teks yang Anda inginkan */
}
.table {
    min-width: 100%;
    width: auto;
    table-layout: auto;
}
.rounded-card {
    width: 100%; /* Ganti dengan persentase yang diinginkan */
    height: auto;
    border-radius: 50px;
}
.card {
    max-width: 100%; /* Ganti dengan persentase atau nilai maksimum yang diinginkan */
}
</style>
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Dashboard</h2>
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
<div class="container">
    <div class="row fs-5 fw-bold">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
            Welcome {{Auth::user()->name}} <i class="fa fa-user-astronaut me-2"></i>,
        </div>
    </div>
</div>
<div class="container">
    
</div>
<div class="container">
    
</div>
@endsection
