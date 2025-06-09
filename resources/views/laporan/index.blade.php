@extends('layouts.main')
@section('Laporan', 'active')
@section('container')
@section('title', 'Manajemen Bahan | Bdim’s Stock')

    @php
        $currentUrl = request()->path();
        $selectedMonth = request('month', now()->format('m'));
        $selectedYear = request('year', now()->format('Y'));
    @endphp

    @push('addStyle')
        <style>
            table.table-bordered tbody tr td,
            table.table-bordered thead tr th {
                width: 12vh;
                max-width: 12vh;
                min-width: 12vh;
                text-align: center;
            }

            table.table-bordered tbody tr td:first-child,
            table.table-bordered thead tr th:first-child {
                width: auto;
                max-width: none;
                min-width: auto;
                text-align: left;
            }

            table.table-bordered tbody tr td:first-child,
            table.table-bordered thead tr th:first-child {
                width: 12vh;
                max-width: 12vh;
                min-width: 12vh;
                text-align: left;
            }

            .card-body.maxHeightTable {
                max-height: 100vh;
                overflow-y: auto;
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
       @include('layouts.components.alert-flash-messages')


        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <label for="tanggalbahan" class="col-form-label me-2">Tanggal</label>
                <input type="month" class="form-control" id="tanggalbahan" name="date" value="{{ $dateParam }}">
            </div>

            @if (!empty($dateParam))
                <a href="{{ route('laporan.export', ['date' => $dateParam]) }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            @endif
        </div>
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
                        <div class="card-title fs-5 fw-bold mt-2"> Laporan Bulanan Bar ({{ $bulanNama }}
                            {{ $tahunNama }})
                        </div>
                    </div>

                    <div class="card-body maxHeightTable">
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
                                            <td><strong>Stok Masuk</strong></td>
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
                                                @php
                                                    $value = $day['terbuang'];
                                                    $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                                @endphp
                                                <td class="text-center">
                                                    @if ($value > 0)
                                                        <span class="text-danger fw-bold">
                                                            &#8595; {{ $formatted }}
                                                        </span>
                                                    @elseif ($value < 0)
                                                        <span class="text-success fw-bold">
                                                            &#8593; {{ $formatted }}
                                                        </span>
                                                    @else
                                                        <span>0</span>
                                                    @endif
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

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Laporan Bulanan Kitchen ({{ $bulanNama }}
                            {{ $tahunNama }})
                        </div>
                    </div>

                    <div class="card-body maxHeightTable">
                        <div class="table-responsive">
                            @foreach ($allHistories2 as $index => $item)
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
                                                @php
                                                    $value = $day['terbuang'];
                                                    $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                                @endphp
                                                <td class="text-center">
                                                    @if ($value > 0)
                                                        <span class="text-danger fw-bold">
                                                            &#8595; {{ $formatted }}
                                                        </span>
                                                    @elseif ($value < 0)
                                                        <span class="text-success fw-bold">
                                                            &#8593; {{ $formatted }}
                                                        </span>
                                                    @else
                                                        <span>0</span>
                                                    @endif
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

    @push('addScript')
        <script>
            document.getElementById('tanggalbahan').addEventListener('change', function () {
                const selectedDate = this.value;
                if (selectedDate) {
                    const baseUrl = "{{ route('laporan.index') }}";
                    window.location.href = `${baseUrl}?date=${selectedDate}`;
                }
            });
        </script>
    @endpush

@endsection