@extends('layouts.main')
@section('Laporan', 'active')
@section('container')
@section('title', 'Manajemen Bahan | B.di.M’s Stock')

    @php
        $currentUrl = request()->path();
        $selectedMonth = request('month', now()->format('m'));
        $selectedYear = request('year', now()->format('Y'));
        $isYear = $type === 'year';
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


        <div class="d-flex align-items-end gap-3 mb-3">
            <div>
                <label for="filterDate" class="form-label mb-1">Tanggal</label>
                <input type="date" class="form-control" id="filterDate" name="filterDate" value="{{ $dateInput ?? '' }}">
            </div>

            <div>
                <label for="filterType" class="form-label mb-1">Tipe Periode</label>
                <select id="filterType" class="form-select" name="filterType">
                    <option value="">-- Pilih --</option>
                    <option value="week" {{ $type === 'week' ? 'selected' : '' }}>Minggu</option>
                    <option value="month" {{ $type === 'month' ? 'selected' : '' }}>Bulan</option>
                    <option value="year" {{ $type === 'year' ? 'selected' : '' }}>Tahun</option>
                </select>
            </div>
        </div>
        @if (!empty($dateInput))
            <div class="d-flex gap-2 mb-3 align-items-end">
                <div class="ms-auto">
                    <a href="{{ route('laporan.export', ['type' => $type, 'date' => $dateInput]) }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i> Export Excel
                    </a>
                </div>
            </div>
        @endif

        <div class="container-trapezoid">
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
                        <div class="card-title fs-5 fw-bold mt-2"> Laporan Bulanan Bar ({{ $periodeLabel }})
                        </div>
                    </div>

                    <div class="card-body maxHeightTable">
                        <div class="table-responsive">
                            @if (!empty($dateInput))
                                @foreach ($allHistories as $index => $item)
                                    <h5 class="mt-4">{{ $index + 1 }}. {{ $item['bahan']->name }}
                                        ({{ $item['bahan']->satuan->name }})</h5>
                                    <table class="table table-bordered text-dark table-sm">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Jenis</th>
                                                @foreach ($item['history'] as $key => $value)
                                                    <th class="text-center">{{ $isYear ? $key : $value['tanggal'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (['awal' => 'Data Awal', 'masuk' => 'Stok Masuk', 'terpakai' => 'Terpakai', 'sisa' => 'Sisa'] as $field => $label)
                                                <tr>
                                                    <td><strong>{{ $label }}</strong></td>
                                                    @foreach ($item['history'] as $key => $value)
                                                        @php
                                                            $val = $isYear
                                                                ? collect($value)->pluck($field)->filter()->sum()
                                                                : $value[$field] ?? 0;
                                                        @endphp
                                                        <td class="text-center">
                                                            {{ rtrim(rtrim(number_format($val, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach

                                            {{-- Spacer --}}
                                            <tr>
                                                <td style="border: none !important; height: 3vh;"></td>
                                                @foreach ($item['history'] as $key => $value)
                                                    <td style="border: none !important;"></td>
                                                @endforeach
                                            </tr>

                                            {{-- Data Akhir --}}
                                            <tr>
                                                <td><strong>Data Akhir</strong></td>
                                                @foreach ($item['history'] as $key => $value)
                                                    @php
                                                        $val = $isYear
                                                            ? collect($value)->pluck('akhir')->filter()->last()
                                                            : $value['akhir'] ?? 0;
                                                    @endphp
                                                    <td class="text-center">
                                                        {{ rtrim(rtrim(number_format($val, 3, ',', '.'), '0'), ',') }}
                                                    </td>
                                                @endforeach
                                            </tr>

                                            {{-- Terbuang --}}
                                            <tr>
                                                <td><strong>Terbuang</strong></td>
                                                @foreach ($item['history'] as $key => $value)
                                                    @php
                                                        $val = $isYear
                                                            ? collect($value)->pluck('terbuang')->sum()
                                                            : $value['terbuang'] ?? 0;
                                                        $formatted = rtrim(rtrim(number_format(abs($val), 3, ',', '.'), '0'), ',');
                                                    @endphp
                                                    <td class="text-center">
                                                        @if ($val > 0)
                                                            <span class="text-danger fw-bold">&#8595; {{ $formatted }}</span>
                                                        @elseif ($val < 0)
                                                            <span class="text-success fw-bold">&#8593; {{ $formatted }}</span>
                                                        @else
                                                            <span>0</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="100%" class="text-center text-muted py-3">Tidak ada data yang
                                        ditemukan.</td>
                                </tr>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Laporan Bulanan Kitchen ({{ $periodeLabel }})
                        </div>
                    </div>

                    <div class="card-body maxHeightTable">
                        <div class="table-responsive">
                            @if (!empty($dateInput))
                                @foreach ($allHistories2 as $index => $item)
                                    <h5 class="mt-4">{{ $index + 1 }}. {{ $item['bahan']->name }}
                                        ({{ $item['bahan']->satuan->name }})</h5>
                                    <table class="table table-bordered text-dark table-sm">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Jenis</th>
                                                @foreach ($item['history'] as $key => $value)
                                                    <th class="text-center">{{ $isYear ? $key : $value['tanggal'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (['awal' => 'Data Awal', 'masuk' => 'Stok Masuk', 'terpakai' => 'Terpakai', 'sisa' => 'Sisa'] as $field => $label)
                                                <tr>
                                                    <td><strong>{{ $label }}</strong></td>
                                                    @foreach ($item['history'] as $key => $value)
                                                        @php
                                                            $val = $isYear
                                                                ? collect($value)->pluck($field)->filter()->sum()
                                                                : $value[$field] ?? 0;
                                                        @endphp
                                                        <td class="text-center">
                                                            {{ rtrim(rtrim(number_format($val, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach

                                            {{-- Spacer --}}
                                            <tr>
                                                <td style="border: none !important; height: 3vh;"></td>
                                                @foreach ($item['history'] as $key => $value)
                                                    <td style="border: none !important;"></td>
                                                @endforeach
                                            </tr>

                                            {{-- Data Akhir --}}
                                            <tr>
                                                <td><strong>Data Akhir</strong></td>
                                                @foreach ($item['history'] as $key => $value)
                                                    @php
                                                        $val = $isYear
                                                            ? collect($value)->pluck('akhir')->filter()->last()
                                                            : $value['akhir'] ?? 0;
                                                    @endphp
                                                    <td class="text-center">
                                                        {{ rtrim(rtrim(number_format($val, 3, ',', '.'), '0'), ',') }}
                                                    </td>
                                                @endforeach
                                            </tr>

                                            {{-- Terbuang --}}
                                            <tr>
                                                <td><strong>Terbuang</strong></td>
                                                @foreach ($item['history'] as $key => $value)
                                                    @php
                                                        $val = $isYear
                                                            ? collect($value)->pluck('terbuang')->sum()
                                                            : $value['terbuang'] ?? 0;
                                                        $formatted = rtrim(rtrim(number_format(abs($val), 3, ',', '.'), '0'), ',');
                                                    @endphp
                                                    <td class="text-center">
                                                        @if ($val > 0)
                                                            <span class="text-danger fw-bold">&#8595; {{ $formatted }}</span>
                                                        @elseif ($val < 0)
                                                            <span class="text-success fw-bold">&#8593; {{ $formatted }}</span>
                                                        @else
                                                            <span>0</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="100%" class="text-center text-muted py-3">Tidak ada data yang
                                        ditemukan.</td>
                                </tr>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('addScript')
        <script>
            document.querySelectorAll('#filterDate, #filterType').forEach(el => {
                el.addEventListener('change', () => {
                    const date = document.getElementById('filterDate').value;
                    const type = document.getElementById('filterType').value;
                    if (date && type) {
                        const baseUrl = "{{ route('laporan.index') }}";
                        window.location.href = `${baseUrl}?type=${type}&date=${date}`;
                    }
                });
            });
        </script>
    @endpush


@endsection