@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')
@section('title', "Rekap Bulanan | BdiM’s Stock")

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
                                <li class="breadcrumb-item"><a class="" href="/bahan/manajemen-bahan">Manajemen Bahan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Rekap Bulanan {{ $bahan->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.components.alert-flash-messages')
        <div class="d-flex align-items-end gap-5 mb-3">
            <div class="mb-3">
                <label for="tanggalbahan" class="col-sm-3 col-form-label me-2">Tanggal</label>
                <div class="col-sm-8">
                    <input type="month" class="form-control" id="tanggalbahan" name="date" value="{{ $dateParam }}">
                </div>
            </div>
            <div class="ms-auto">
                <button class="btn btn-secondary filterCustom" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fa fa-filter"></i>
                </button>
            </div>
        </div>

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
                        <h5 class="card-title fs-5 fw-bold mt-2">Rekap Bulanan: {{ $bahan->name }}
                            ({{ $bahan->satuan->name }}) - {{ $bulanNama }}
                            {{ $year }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <a href="{{ $previousUrl }}">
                                        <i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali
                                    </a>
                                </div>
                                @if ($settings['show_grafik_bahanIndexById'] ?? true)
                                    <canvas id="lossChart" height="50" class="mb-3"></canvas>
                                @endif
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('user.setting.update') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold fs-5 text-primary" id="filterModalLabel">Filter Tampilan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Checkbox Kolom --}}
                        @php
                            $columns = [
                                'show_grafik_bahanIndexById' => ['label' => 'Tampilkan Grafik', 'default' => true],
                            ];
                        @endphp

                        @foreach ($columns as $key => $column)
                            <div class="form-check">
                                <input type="hidden" name="{{ $key }}" value="0">
                                <input class="form-check-input" type="checkbox" name="{{ $key }}" value="1" id="{{ $key }}" {{ ($settings[$key] ?? $column['default']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $key }}">
                                    {{ $column['label'] }}
                                </label>
                            </div>
                        @endforeach
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    @push('addScript')
        <script>
            function formatNumberID(value) {
                const parts = value.toFixed(3).split('.');
                const decimal = parts[1].replace(/0+$/, '');
                const formatted = Number(parts[0]).toLocaleString('id-ID');
                return decimal ? `${formatted},${decimal}` : formatted;
            }
        </script>
        <script src="{{ url('js/chart.js') }} "></script>
        <script>
            const history = {!! json_encode($history) !!};

            const labels = history.map(item => item.tanggal);
            const dataAwal = history.map(item => item.awal ?? 0);
            const dataMasuk = history.map(item => item.masuk ?? 0);
            const dataTerpakai = history.map(item => item.terpakai ?? 0);
            const dataSisa = history.map(item => item.sisa ?? 0);
            const dataAkhir = history.map(item => item.akhir ?? 0);
            const dataTerbuang = history.map(item => item.terbuang ?? 0);

            const ctx = document.getElementById('lossChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Data Awal',
                            data: dataAwal,
                            borderColor: '#007bff',
                            backgroundColor: '#007bff33',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: 'Masuk',
                            data: dataMasuk,
                            borderColor: '#28a745',
                            backgroundColor: '#28a74533',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: 'Terpakai',
                            data: dataTerpakai,
                            borderColor: '#ffc107',
                            backgroundColor: '#ffc10733',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: 'Sisa',
                            data: dataSisa,
                            borderColor: '#17a2b8',
                            backgroundColor: '#17a2b833',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: 'Data Akhir',
                            data: dataAkhir,
                            borderColor: '#6f42c1',
                            backgroundColor: '#6f42c133',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: 'Terbuang',
                            data: dataTerbuang,
                            borderColor: '#dc3545',
                            backgroundColor: '#dc354533',
                            fill: false,
                            tension: 0.2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let value = context.parsed.y;
                                    let label = context.dataset.label;
                                    let direction = (label === 'Terbuang' && value !== 0)
                                        ? (value > 0 ? '↓ ' : '↑ ')
                                        : '';
                                    return `${label}: ${direction}${formatNumberID(Math.abs(value))}`;
                                }
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function (value) {
                                    return formatNumberID(value);
                                }
                            }
                        }
                    }
                }
            });
        </script>


        <script>
            document.getElementById('tanggalbahan').addEventListener('change', function () {
                const selectedDate = this.value;
                if (selectedDate) {
                    const bahanIdEncoded = "{{ \Hashids::encode($bahanId) }}";
                    const baseUrl = "{{ url('/bahan/manajemen-bahan') }}/" + bahanIdEncoded;
                    window.location.href = `${baseUrl}?date=${selectedDate}`;
                }
            });
        </script>
    @endpush

@endsection