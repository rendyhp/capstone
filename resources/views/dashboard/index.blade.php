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
    <div class="row mt-3">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="bg-light rounded p-4 d-flex align-items-center">
                <i class="fa fa-inbox fa-3x text-primary me-4"></i>
                <div>
                    <p class="mb-2">Stok Tersedia</p>
                    <h6 class="mb-0">
                        @php
                            $totalBarangMasuk = 0;
                            $totalBarangKeluar = 0;

                            foreach ($dashboards as $dashboard) {
                                $totalBarangMasuk += $dashboard->barang_masuk;
                                $totalBarangKeluar += $dashboard->barang_keluar;
                            }

                            $stokTersedia = $totalBarangMasuk - $totalBarangKeluar;
                            echo $stokTersedia;
                        @endphp
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="bg-light rounded p-4 d-flex align-items-center">
                <i class="fas fa-box-open fa-3x text-primary me-4"></i>
                <div>
                    <p class="mb-2">Data Barang</p>
                    <h6 class="mb-0">{{ $totalBarang }}</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="bg-light rounded p-4 d-flex align-items-center">
                <i class="fa fa-arrow-circle-down fa-3x text-primary me-4"></i>
                <div>
                    <p class="mb-2">Barang Masuk</p>
                    <h6 class="mb-0">
                        @php
                            $totalBarangMasuk = 0;
                            foreach ($dashboards as $dashboard) {
                                $totalBarangMasuk += $dashboard->barang_masuk;
                            }
                            echo $totalBarangMasuk;
                        @endphp
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="bg-light rounded p-4 d-flex align-items-center">
                <i class="fa fa-arrow-circle-up fa-3x text-primary me-4"></i>
                <div>
                    <p class="mb-2">Barang Keluar</p>
                    <h6 class="mb-0">
                        @php
                            $totalBarangKeluar = 0;
                            foreach ($dashboards as $dashboard) {
                                $totalBarangKeluar += $dashboard->barang_keluar;
                            }
                            echo $totalBarangKeluar;
                        @endphp
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mt-3">
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header fs-5 fw-bold">Tabel Transaksi 
                <div class="dataTables_length float-end btn-sm">
                    <label>
                        <select id="transaksi-per-page">
                            <option value="-1">All</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </label>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-start align-middle text-sm table-bordered table-hover mb-3 table-transaksi">
                            <thead class="bg-light">
                                <tr class="text-dark">
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Merk Barang</th>
                                    <th scope="col">Barang Masuk</th>
                                    <th scope="col">Barang Keluar</th>
                                </tr>
                            </thead>
                            <tbody id="tabeltransaksi">
                                @foreach ($dashboards as $dashboard)
                                <tr>
                                    <td>{{ $dashboard->barang_nama }}</td>
                                    <td>{{ $dashboard->barang_merk }}</td>
                                    <td>{{ $dashboard->barang_masuk }}</td>
                                    <td>{{ $dashboard->barang_keluar }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header fs-5 fw-bold">Tabel Ketersediaan Stok Barang
                <div class="dataTables_length float-end btn-sm">
                    <label>
                        <select id="tersedia-per-page">
                            <option value="-1">All</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            
                        </select>
                    </label>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0 table-ketersediaan">
                            <thead class="bg-light">
                                <tr class="text-dark">
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Tipe Barang</th>
                                    <th>Jumlah Tersedia</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>
                            <tbody id="tabeltersedia">
                                @foreach ($Stoks as $stok)
                                <tr>
                                    <td>{{ $stok->barang->barang_code }}</td>
                                    <td>{{ $stok->barang->barang_nama }}</td>
                                    <td>{{ $stok->barang->barang_merk }}</td>
                                    <td>{{ $stok->barang->barang_jenis }}</td>
                                    <td>{{ $stok->barang->barang_tipe }}</td>
                                    <td>{{ $stok->jumlah_tersedia }}</td>
                                    <td>{{ $stok->barang->barang_satuan }}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
