@extends('layouts.main')
@section('Laporan', 'active')
@section('container')
@section('title', 'Manajemen Bahan | Bdim’s Stock')

    @php
        $currentUrl = request()->path();
        $selectedMonth = request('month', now()->format('m'));
        $selectedYear = request('year', now()->format('Y'));
    @endphp

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
        </div>
        <div>
            <a href="/laporan/bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'laporan/bahan') ? 'active' : '' }}">
                Bahan
            </a>
            <a href="/laporan/loss-bahan"
                class="tab-trapezoid {{ Str::startsWith($currentUrl, 'laporan/loss-bahan') ? 'active' : '' }}">
                Bahan Loss
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
                        <div class="card-title fs-5 fw-bold mt-2"> Rekap Loss Bar ({{ $bulanNama }}
                            {{ $tahunNama }})
                        </div>
                    </div>

                    <div class="card-body maxHeightTable">
                        <div class="table-responsive">
                            <table class="table table-bordered text-dark table-sm">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="max-width: 10vh">No.</th>
                                        <th>Nama Bahan</th>
                                        <th class="text-center">Masuk (Total)</th>
                                        <th class="text-center">Terpakai (Total)</th>
                                        <th class="text-center">Terbuang (Total)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($totalTerbuangBar as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format(abs($item['total_masuk']), 3, ',', '.'), '0'), ',') }}
                                            </td>
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format(abs($item['total_terpakai']), 3, ',', '.'), '0'), ',') }}
                                            </td>
                                            @php
                                                $value = $item['total_terbuang'];
                                                $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                            @endphp <td class="text-center">
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Rekap Loss Kitchen ({{ $bulanNama }}
                            {{ $tahunNama }})
                        </div>
                    </div>

                    <div class="card-body maxHeightTable">
                        <div class="table-responsive">


                            <table class="table table-bordered text-dark table-sm">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="width: 10vh">No.</th>
                                        <th>Nama Bahan</th>
                                        <th class="text-center">Masuk (Total)</th>
                                        <th class="text-center">Terpakai (Total)</th>
                                        <th class="text-center">Terbuang (Total)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($totalTerbuangKitchen as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format(abs($item['total_masuk']), 3, ',', '.'), '0'), ',') }}
                                            </td>
                                            <td class="text-center">
                                                {{ rtrim(rtrim(number_format(abs($item['total_terpakai']), 3, ',', '.'), '0'), ',') }}
                                            </td>
                                            @php
                                                $value = $item['total_terbuang'];
                                                $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                            @endphp <td class="text-center">
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
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
            document.getElementById('tanggalbahan').addEventListener('change', function () {
                const selectedDate = this.value;
                if (selectedDate) {
                    const baseUrl = "{{ route('laporan.indexLaporanBahanLoss') }}";
                    window.location.href = `${baseUrl}?date=${selectedDate}`;
                }
            });
        </script>
    @endpush

@endsection