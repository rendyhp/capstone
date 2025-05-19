@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')
@section('title', "Rekap Bulanan | BdiM’s Stock")

    @push('addStyle')
        <style>
            /* Atur lebar kolom tanggal di tabel */
            table.table-bordered tbody tr td,
            table.table-bordered thead tr th {
                /* Lebar minimum dan maksimum di set supaya stabil */
                width: 12vh;
                max-width: 12vh;
                min-width: 12vh;
                /* Optional agar teks rata tengah */
                text-align: center;
                /* Agar teks td tanggal rata tengah */
            }

            /* Tapi biarkan kolom 'Jenis' lebar otomatis */
            table.table-bordered tbody tr td:first-child,
            table.table-bordered thead tr th:first-child {
                width: auto;
                max-width: none;
                min-width: auto;
                text-align: left;
            }

            /* Kolom pertama (Jenis) */
            table.table-bordered tbody tr td:first-child,
            table.table-bordered thead tr th:first-child {
                width: 10vh;
                max-width: 10vh;
                min-width: 10vh;
                text-align: left;
            }
        </style>
    @endpush
    @php
        $currentUrl = request()->path();

        use Carbon\Carbon;
        $bulanNama = Carbon::createFromDate($year, $month, 1)->locale('id')->isoFormat('MMMM'); 
    @endphp



    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Rekap Bulanan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="" href="/bahan/manajemen-bahan">Manajemen Bahan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Rekap Bulanan {{ $bahan->name }}</li>
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

        <form action="/bahan/manajemen-bahan/{{ Hashids::encode($bahanId) }}" method="GET" class="d-flex align-items-center mb-3">
            <div class="mb-3 row">
                <label for="tanggalbahan" class="col-sm-2 col-form-label me-2">Tanggal</label>
                <div class="col-sm-6">
                    <input type="month" class="form-control" id="tanggalbahan" name="date" value="{{ $dateParam }}">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>

        <div>
            <a href="/bahan/manajemen-bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/manajemen-bahan') ? 'active' : '' }}">
                Manajemen Bahan
            </a>
            <a href="/bahan/data-bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/data-bahan') ? 'active' : '' }}">
                Master Bahan
            </a>

            <a href="/bahan/satuan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'bahan/satuan') ? 'active' : '' }}">
                Satuan
            </a>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title fs-5 fw-bold mt-2">Rekap Bulanan: {{ $bahan->name }} ({{ $bulanNama }} {{ $year }})</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <a href="{{ $previousUrl }}">
                                        <i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali
                                    </a>
                                </div>
                                <thead class="table-primary">
                                    <tr>
                                        <th>Jenis</th>
                                        @foreach ($history as $day)
                                            <th class="text-center">{{ $day['tanggal'] }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Data Awal</strong></td>
                                        @foreach ($history as $day)
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format($day['awal'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td><strong>Input</strong></td>
                                        @foreach ($history as $day)
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format($day['masuk'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td><strong>Terpakai</strong></td>
                                        @foreach ($history as $day)
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format($day['terpakai'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td><strong>Sisa</strong></td>
                                        @foreach ($history as $day)
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format($day['sisa'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td style="border: none !important; height: 3vh;"></td>
                                        @foreach ($history as $day)
                                            <td style="border: none !important;"></td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td><strong>Data Akhir</strong></td>
                                        @foreach ($history as $day)
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format($day['akhir'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td><strong>Terbuang</strong></td>
                                        @foreach ($history as $day)
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format($day['terbuang'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('addScript')
        <script>
            const checkbox = document.getElementById('toggleImageColumn');
            const imageColumns = document.querySelectorAll('.column-gambar');

            checkbox.addEventListener('change', function () {
                imageColumns.forEach(col => {
                    col.style.display = this.checked ? '' : 'none';
                });
            });
        </script>
    @endpush

@endsection