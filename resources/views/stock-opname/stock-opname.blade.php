@extends('layouts.main')
@section('DataBahan', 'active')
@section('container')

    <style>
        .cards {
            height: auto;
            background-color: #f7fcfb;
            /* Warna biru muda */
            border-radius: 10px;
            /* Sudut card membulat */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            /* Efek bayangan card */
            padding: 20px;
            /* Ruang dalam card */
        }

        .cards h3 {
            color: #333;
            /* Warna teks */
        }

        .cards p {
            color: #555;
            /* Warna teks */
        }
    </style>
    <div class="container cards">
        <a href={{url('/stock-opname')}}><i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali</a>
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
        <form id="transaksi-form" action="{{ route('stock-opname.simpan.store') }}" method="POST">
            @csrf
            <h2 style="text-align: center;" class="mt-3 text-uppercase fs-2">Stock Opname</h2>

            <div class="mb-3 row">
                <label for="tanggaltransmasuk" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="tanggaltransmasuk" name="tanggaltransmasuk" required>
                </div>
            </div>

            <table class="table table-bordered text-dark table-sm text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No.</th>
                        <th>Nama Bahan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Konfirmasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockOpnames as $index => $bahan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <input type="hidden" name="bahan_id[]" value="{{ $bahan->id }}">
                                {{ $bahan->name }}
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="number" id="number0" name="jumlah[]"
                                        class="form-control text-center jumlah-input number0"
                                        value="{{ optional($bahan->bahanAkhir)->jumlah ?? 0 }}" required readonly>
                                    <button type="button" class="btn btn-primary ms-2 toggle-jumlah">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                            <td>{{ $bahan->satuan->name }}</td>
                            <td width="200px">
                                <button type="button" class="btn btn-primary btn-konfirmasi">
                                    Konfirmasi
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="saveForTomorrow" name="save_for_tomorrow">
                    <label class="form-check-label fw-bold" for="saveForTomorrow">
                        Simpan untuk data awal besok?
                    </label>
                </div>
            </table>

            <div class="d-flex justify-content-end">
                <button type="submit" id="submitBtn" class="btn btn-danger" disabled>Simpan</button>
            </div>

        </form>
@endsection