@extends('user.main')
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
                            <div class="col-sm-2 mb-3 float-end">
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
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
        {{ $ULPs->onEachSide(0.5)->links('pagination::bootstrap-5') }}
    </div>
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