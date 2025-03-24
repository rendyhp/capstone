@extends('layouts.main')

@section('container')

<h5 style="text-align: center;">Cetak Barang Keluar</h5>

    <div>Tanggal Transaksi : {{ $trans->created_at->format('l, Y-m-d') }}</div>
    <div>Pihak I Pemberi : {{ $trans->pemberi }}</div>
    <div>Pihak II Penerima : {{ $trans->penerima }}</div>

<div class="container">
    <table id="tableBarang" class="table table-bordered text-dark table-sm" style="text-align: center;" border="1">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->barang_code }}</td>
                    <td>{{ $item->barang_nama }}</td>
                    <td>{{ $item->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="text-align: center;" class="">
        <div style="display: inline-block; width: 45%" class="me-5 p-4">
            <div class="pt-5 fs-6">Tanda Tangan Pihak II</div>
            <div class="pb-5 fs-6">Penerima</div>
            <hr style="border-top: 1px solid #000;" class="mt-4">
            <p>{{$trans->penerima}}</p>
        </div>
        
        <div style="display: inline-block; width: 45%;" class="">
            <div class="pt-5 fs-6">Tanda Tangan Pihak I</div>
            <div class="pb-5 fs-6"> pemberi </div>
            <hr style="border-top: 1px solid #000;" class="mt-4">
            <p>{{$trans->pemberi}}</p>
        </div>
    </div>
</div>

<div style="text-align: center; margin-top: 20px;">
    <a href="/transaksi" class="btn btn-primary hide-on-print">Kembali ke Transaksi</a>
    <button onclick="konfirmasiCetak()" class="btn btn-success hide-on-print">Cetak</button>
</div>

<script>
    function konfirmasiCetak() {
        if (confirm("Apakah Anda yakin ingin mencetak?")) {
            window.print();
        }
    }
</script>
@endsection
