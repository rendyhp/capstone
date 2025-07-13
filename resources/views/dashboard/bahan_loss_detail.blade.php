@extends('layouts.main')
@section('Dashboard', 'active')
@section('container')
@section('title', 'Dashboard | B.di.M’s Stock')

    @push('addStyle')
        <style>
            .table-responsive {
                overflow-x: auto;
            }

            .table-transaksi {
                font-size: 12px;
            }

            .table-ketersediaan {
                font-size: 12px;
            }

            .table {
                min-width: 100%;
                width: auto;
                table-layout: auto;
            }

            .card {
                max-width: 100%;
            }
        </style>
    @endpush

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Rekap Loss Bahan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Rekap Loss Bahan - Grafik Loss Harian – {{ $bahan->name }} ({{ $periodeLabel }})
                                </li>

                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.components.alert-flash-messages')
    <div class="container">

        @if (Auth::check() && in_array(Auth::user()->role, ['OWNER', 'MANAJER']))
            <!-- Owner & Manajer only -->
            <section id="bahanLoss">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div>
                        <label for="filterDate" class="form-label mb-1">Tanggal</label>
                        <input type="date" class="form-control" id="filterDate" name="filterDate"
                            value="{{ $dateInput ?? now()->toDateString() }}">
                    </div>

                    <div>
                        <label for="filterType" class="form-label mb-1">Tipe Periode</label>
                        <select id="filterType" class="form-select" name="filterType">
                            <option value="week" {{ $type === 'week' ? 'selected' : '' }}>Minggu</option>
                            <option value="month" {{ $type === 'month' ? 'selected' : '' }}>Bulan</option>
                            <option value="year" {{ $type === 'year' ? 'selected' : '' }}>Tahun</option>
                        </select>

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title fs-5 fw-bold mt-2">Grafik Loss Harian – {{ $bahan->name }}
                                    ({{ $periodeLabel }}):
                                </div>
                            </div>
                            <div class="card-body maxHeightTable">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-dark table-sm">
                                        <div class="mb-3" id="kembaliBtn">
                                            <a href="{{ $previousUrl }}">
                                                <i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali
                                            </a>
                                        </div>

                                        <canvas id="lossChart" height="50" class="mb-3"></canvas>
                                        <div class="mt-3">
                                            <h6 class="fw-bold">Total Terbuang:
                                            </h6>
                                            <div class="mb-3">
                                                @php
                                                    $formatted = rtrim(rtrim(number_format(abs($totalTerbuang), 3, ',', '.'), '0'), ',');
                                                @endphp @if ($totalTerbuang > 0) <span class="text-danger fw-bold">&#8595;
                                                        {{ $formatted }}</span> @elseif ($totalTerbuang < 0)
                                                        <span class="text-success fw-bold">&#8593; {{ $formatted }}</span>
                                                    @else
                                                    <span>0</span>
                                                @endif
                                                <span class="ms-1">{{ $bahan->satuan->name }}</span>

                                            </div>
                                        </div>

                                        <thead class="table-primary">
                                            <tr>
                                                <th style="width: 10%">No.</th>
                                                @if ($type === 'year')
                                                    <th>Bulan</th>
                                                @else
                                                    <th>Tanggal</th>
                                                @endif
                                                <th class="text-center">Terbuang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($type === 'year')
                                                @php $rowNumber = 1; @endphp
                                                @foreach ($history as $month => $rows)
                                                    @php
                                                        $totalPerBulan = collect($rows)->sum('terbuang');
                                                    @endphp
                                                    <tr id="row-{{ $month }}">
                                                        <td>{{ $rowNumber++ }}</td>
                                                        <td>{{ $month }}</td>
                                                        <td class="text-center">
                                                            @php
                                                                $formatted = rtrim(rtrim(number_format(abs($totalPerBulan), 3, ',', '.'), '0'), ',');
                                                            @endphp @if ($totalPerBulan > 0)
                                                                                <span class="text-danger fw-bold">&#8595; {{ $formatted }}</span>
                                                                            @elseif ($totalPerBulan < 0)
                                                                <span class="text-success fw-bold">&#8593; {{ $formatted }}</span>
                                                            @else
                                                                <span>0</span>
                                                            @endif
                                                            <span class="ms-1">{{ $bahan->satuan->name }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @php $rowNumber = 1; @endphp
                                                @forelse ($history as $index => $item)
                                                    <tr id="row-{{ \Carbon\Carbon::parse($item['tanggal'])->format('Y-m-d') }}"
                                                        onclick="scrollToChart('{{ \Carbon\Carbon::parse($item['tanggal'])->format('Y-m-d') }}')">
                                                        <td>{{ $rowNumber++ }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('j F Y') }}
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $value = $item['terbuang'];
                                                                $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                                            @endphp @if($value > 0)<span class="text-danger fw-bold">&#8595;
                                                                            {{ $formatted }}</span> @elseif ($value < 0)
                                                                    <span class="text-success fw-bold">&#8593; {{ $formatted }}</span>
                                                                @else
                                                                <span>0</span>
                                                            @endif
                                                            <span class="ms-1">{{ $bahan->satuan->name }}</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        @endif
    </div>
    <div class="container">

    </div>
    @push('addScript')
        <script>
            document.querySelectorAll('#filterDate, #filterType').forEach(el => {
                el.addEventListener('change', () => {
                    const date = document.getElementById('filterDate').value;
                    const type = document.getElementById('filterType').value;
                    if (date && type) {
                        const baseUrl = "{{ route('dashboard.bahanLossDetail', ['encryptedId' => Hashids::encode($bahanId)]) }}";
                        window.location.href = `${baseUrl}?type=${type}&date=${date}`;
                    }
                });
            });
        </script>
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
            const type = "{{ $type }}";
            let labels = [];
            let data = [];

            if (type === "year") {
                const history = {!! json_encode($history) !!};
                labels = Object.keys(history); // ['Januari', 'Februari', ...]
                data = Object.values(history).map(rows =>
                    rows.reduce((sum, row) => sum + (row.terbuang || 0), 0)
                );
            } else {
                const rawLabels = {!! json_encode(array_column($history, 'tanggal')) !!};
                data = {!! json_encode(array_column($history, 'terbuang')) !!};
                labels = rawLabels.map(dateStr => {
                    const date = new Date(dateStr);
                    return new Intl.DateTimeFormat('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }).format(date);
                });
            }


            const ctx = document.getElementById('lossChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Terbuang',
                        data: data,
                        fill: false,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.2
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    onClick: function (evt, activeElements) {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            let dateStr;
                            let rowMonth = [];
                            if (type === "year") {
                                rowMonth = Object.keys({!! json_encode($history) !!}); // ['Januari', 'Februari', ...]
                            }

                            if (type === "year") {
                                const rawLabels = rowMonth;
                                dateStr = rawLabels[index];
                            } else {
                                const rawLabels = {!! json_encode(array_column($history, 'tanggal')) !!};
                                dateStr = rawLabels[index];
                            }

                            const row = document.getElementById('row-' + dateStr);
                            if (row) {
                                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                row.classList.add('table-warning');
                                setTimeout(() => row.classList.remove('table-warning'), 1500);
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let value = context.parsed.y;
                                    let label = context.dataset.label;
                                    let direction = (label === 'Jumlah Terbuang' && value !== 0)
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
            function scrollToChart(dateStr) {
                const chart = document.getElementById('lossChart');
                if (chart) {
                    chart.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        </script>


    @endpush
@endsection