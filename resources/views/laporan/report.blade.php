@extends('layouts.main')
@section('Report','active')
@section('container')
<h3><center>Laporan Data Stok Opname</center></h3>
<div style="text-align: right;" class="p-4">
    <h5>{{ date('d F Y') }}</h5>
</div>
<div class="text-center rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h5 class="mb-0">Transaksi</h5>
        
    </div>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead class="bg-light">
                <tr class="text-dark">
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Barang Masuk</th>
                    <th scope="col">Barang Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dashboards as $dashboard)
                <tr>
                    <td>{{$dashboard->trans_tanggal}}</td>
                    <td>{{$dashboard->barang_nama}}</td>
                    <td>{{$dashboard->barang_masuk}}</td>
                    <td>{{$dashboard->barang_keluar}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2 mt-5">
        <div class="text-dark">Stok Tersedia : {{array_sum($stokTersedia)}}</div>
    </div>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead class="bg-light">
                <tr class="text-dark">
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Merk Barang</th>
                    <th>Jenis Barang</th>
                    <th>Tipe Barang</th>
                    <th>Satuan</th>
                    <th>Jumlah Tersedia</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Barangs as $barang)
                <tr>
                    <td>{{$barang->barang_code}}</td>
                    <td>{{ $barang->barang_nama }}</td>
                    <td>{{ $barang->barang_merk }}</td>
                    <td>{{ $barang->barang_jenis }}</td>
                    <td>{{ $barang->barang_tipe }}</td>
                    <td>{{ $barang->barang_satuan }}</td>
                    <td>{{$stokTersedia[$barang->barang_nama]}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div style="text-align: right;" class="mt-4 p-5">
    <footer class="text-dark">MSB STI OPRS. SUMBAR</footer>
</div>
@endsection
