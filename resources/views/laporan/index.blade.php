@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')
@section('title', 'Manajemen Bahan | Bdim’s Stock')

    @php
        use Carbon\Carbon;
        $currentUrl = request()->path();

        $monthFormatted = sprintf('%02d', $month); // agar 1 menjadi 01
        $dateString = $year . '-' . $monthFormatted;

        $monthName = Carbon::createFromFormat('Y-m', $dateString)->translatedFormat('F Y');
        $daysInMonth = Carbon::createFromFormat('Y-m', $dateString)->daysInMonth;
        $selectedMonth = request('month', now()->format('m'));
        $selectedYear = request('year', now()->format('Y'));
    @endphp

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

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Laporan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Laporan - Bahan</li>
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

        <form action="{{ route('laporan.index') }}" method="GET" class="d-flex align-items-end gap-3 mb-4">
            <div>
                <label for="month" class="form-label mb-1">Pilih Bulan</label>
                <select name="month" id="month" class="form-control">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="year" class="form-label mb-1">Pilih Tahun</label>
                <select name="year" id="year" class="form-control">
                    @foreach (range(now()->year - 3, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-filter"></i> Tampilkan
                </button>
            </div>

            <div>
                <a href="{{ route('laporan.export', ['month' => $selectedMonth, 'year' => $selectedYear]) }}"
                    class="btn btn-success mt-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </form>

        <div>
            <a href="/laporan/bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'laporan/bahan') ? 'active' : '' }}">
                Bahan
            </a>
            <a href="/laporan/barang"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'laporan/barang') ? 'active' : '' }}">
                Barang
            </a>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Laporan Bulanan Bar ({{ $bulanNama }} {{ $year }})</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            @foreach ($allHistories as $index => $item)
                                <h5 class="mt-4">{{ $index + 1 }}. {{ $item['bahan']->name }}
                                    ({{ $item['bahan']->satuan->name }})</h5>
                                <table class="table table-bordered text-dark table-sm">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Jenis</th>
                                            @foreach ($item['history'] as $day)
                                                <th class="text-center">{{ $day['tanggal'] }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Data Awal</strong></td>
                                            @foreach ($item['history'] as $day)
                                                <td class="text-center">
                                                    {{ rtrim(rtrim(number_format($day['awal'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><strong>Input</strong></td>
                                            @foreach ($item['history'] as $day)
                                                <td class="text-center">
                                                    {{ rtrim(rtrim(number_format($day['masuk'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><strong>Terpakai</strong></td>
                                            @foreach ($item['history'] as $day)
                                                <td class="text-center">
                                                    {{ rtrim(rtrim(number_format($day['terpakai'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><strong>Sisa</strong></td>
                                            @foreach ($item['history'] as $day)
                                                <td class="text-center">
                                                    {{ rtrim(rtrim(number_format($day['sisa'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td style="border: none !important; height: 3vh;"></td>
                                            @foreach ($item['history'] as $day)
                                                <td style="border: none !important;"></td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><strong>Data Akhir</strong></td>
                                            @foreach ($item['history'] as $day)
                                                <td class="text-center">
                                                    {{ rtrim(rtrim(number_format($day['akhir'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><strong>Terbuang</strong></td>
                                            @foreach ($item['history'] as $day)
                                                <td class="text-center">
                                                    {{ rtrim(rtrim(number_format($day['terbuang'] ?? 0, 3, ',', '.'), '0'), ',') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection