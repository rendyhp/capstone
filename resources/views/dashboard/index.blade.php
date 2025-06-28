@extends('layouts.main')
@section('Dashboard', 'active')
@section('container')
@section('title', 'Dashboard | B.di.M’s Stock')

    @push('spinner')
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->
    @endpush

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
                    <h2 class="pageheader-title">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.components.alert-flash-messages')
    <div class="container">
        <div class="row fs-5 fw-bold">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                Selamat datang {{Auth::user()->name}} <i class="fa fa-user-astronaut me-2"></i>,
            </div>
        </div>
    </div>
    <div class="container">

        <section id="barangBahanMenipis">
            <div class="mt-4">
                <h5><i class="fa fa-exclamation-circle text-danger"></i> Barang Melewati Stok Minimum</h5>
                @if($barangs_below_minimum->isEmpty())
                    <p class="text-success">Semua stok barang aman.</p>
                @else
                    <table class="table table-bordered text-dark table-sm">
                        <thead class="table-primary">
                            <tr>
                                <th class="column-nomor">No.</th>
                                <th class="column-name">Nama Barang</th>
                                <th class="column-minimum">Stok Minimum</th>
                                <th class="column-sisa">Sisa</th>
                                <th class="column-satuan">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs_below_minimum as $barang)
                                <tr>
                                    <td class="column-nomor">{{ $loop->iteration }}</td>
                                    <td class="column-name">{{ $barang->name }}</td>
                                    <td class="text-end column-minimum">
                                        {{ rtrim(rtrim(number_format($barang->minimum, 3, ',', '.'), '0'), ',') }}
                                    </td>
                                    <td class="text-end text-danger fw-bold column-sisa">
                                        {{ rtrim(rtrim(number_format($barang->sisa, 3, ',', '.'), '0'), ',') }}
                                    </td>
                                    <td class="column-satuan">{{ $barang->satuanBarang->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="mt-4">
                <h5><i class="fa fa-exclamation-triangle text-warning"></i> Bahan Melewati Stok Minimum</h5>
                @if($bahans_below_minimum->isEmpty())
                    <p class="text-success">Semua stok bahan aman.</p>
                @else
                    <table class="table table-bordered text-dark table-sm">
                        <thead class="table-primary">
                            <tr>
                                <th class="column-nomor2">No.</th>
                                <th class="column-name2">Nama Bahan</th>
                                <th class="column-section">Bagian</th>
                                <th class="column-minimum2">Stok Minimum</th>
                                <th class="column-sisa2">Sisa</th>
                                <th class="column-satuan2">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bahans_below_minimum as $bahan)
                                <tr>
                                    <td class="column-nomor2">{{ $loop->iteration }}</td>
                                    <td class="column-name2">{{ $bahan->name }}</td>
                                    <td class="column-section">{{ $bahan->section }}</td>
                                    <td class="text-end column-minimum2">
                                        {{ rtrim(rtrim(number_format($bahan->minimum, 3, ',', '.'), '0'), ',') }}
                                    </td>
                                    <td class="text-end text-danger fw-bold column-sisa2">
                                        {{ rtrim(rtrim(number_format($bahan->jumlah_akhir, 3, ',', '.'), '0'), ',') }}
                                    </td>
                                    <td class="column-satuan2">{{ $bahan->satuan->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <div class="mb-3 ms-3">
            <div id="serverTime" class="mt-2 text-muted" style="font-size: 0.9rem;">
                Waktu server: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }},
                {{ \Carbon\Carbon::now()->format('H:i:s') }} WIB
            </div>
        </div>

        @if (Auth::check() && in_array(Auth::user()->role, ['OWNER', 'MANAJER']))
            <!-- Owner & Manajer only -->
            <section id="bahanLoss">
                <hr>
                <div class="card-header mb-3">
                    <div class="card-title fs-5 fw-bold mt-2">Rekap Loss Bahan</div>
                </div>

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
                    <!-- Kolom Kiri: Rekap Loss BAR -->
                    <div class="col-xl-6">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title fs-5 fw-bold mt-2">Bar</div>
                            </div>
                            <div class="card-body maxHeightTable">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-dark table-sm">
                                        <thead class="table-primary">
                                            <tr>
                                                <th style="max-width: 10vh">No.</th>
                                                <th>Nama Bahan</th>
                                                <th class="text-center">Terbuang (Total)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($totalTerbuangBar as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <a class="text-dark"
                                                            href="{{ route('dashboard.bahanLossDetail', ['encryptedId' => Hashids::encode($item['id']), 'date' => $dateInput, 'type' => $type]) }}">
                                                            {{ $item['name'] }}
                                                        </a>
                                                    </td>
                                                    @php
                                                        $value = $item['total_terbuang'];
                                                        $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                                    @endphp
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="text-end" style="min-width: 60px;">
                                                                @if ($value > 0)
                                                                    <span class="text-danger fw-bold">&#8595; {{ $formatted }}</span>
                                                                @elseif ($value < 0)
                                                                    <span class="text-success fw-bold">&#8593; {{ $formatted }}</span>
                                                                @else
                                                                    <span>0</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-start ms-3" style="min-width: 50px;">
                                                                {{ $item['satuan'] }}
                                                            </div>
                                                        </div>
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

                    <!-- Kolom Kanan: Rekap Loss KITCHEN -->
                    <div class="col-xl-6">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title fs-5 fw-bold mt-2">Kitchen</div>
                            </div>
                            <div class="card-body maxHeightTable">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-dark table-sm">
                                        <thead class="table-primary">
                                            <tr>
                                                <th style="max-width: 10vh">No.</th>
                                                <th>Nama Bahan</th>
                                                <th class="text-center">Terbuang (Total)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($totalTerbuangKitchen as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <a class="text-dark"
                                                            href="{{ route('dashboard.bahanLossDetail', ['encryptedId' => Hashids::encode($item['id']), 'date' => $dateInput, 'type' => $type]) }}">
                                                            {{ $item['name'] }}
                                                        </a>
                                                    </td>
                                                    @php
                                                        $value = $item['total_terbuang'];
                                                        $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                                    @endphp
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="text-end" style="min-width: 60px;">
                                                                @if ($value > 0)
                                                                    <span class="text-danger fw-bold">&#8595; {{ $formatted }}</span>
                                                                @elseif ($value < 0)
                                                                    <span class="text-success fw-bold">&#8593; {{ $formatted }}</span>
                                                                @else
                                                                    <span>0</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-start ms-3" style="min-width: 50px;">
                                                                {{ $item['satuan'] }}
                                                            </div>
                                                        </div>
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
            </section>
        @endif
    </div>
    <div class="container">

    </div>
    @push('addScript')
        <script>
            let serverTime = new Date("{{ \Carbon\Carbon::now()->toDateTimeString() }}").getTime();

            function padZero(num) {
                return num.toString().padStart(2, '0');
            }

            function updateTime() {
                serverTime += 1000;
                const date = new Date(serverTime);

                const day = date.getDate();
                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const month = monthNames[date.getMonth()];
                const year = date.getFullYear();

                const hours = padZero(date.getHours());
                const minutes = padZero(date.getMinutes());
                const seconds = padZero(date.getSeconds());

                const formatted = `${day} ${month} ${year}, ${hours}:${minutes}:${seconds} WIB`;

                document.getElementById('serverTime').innerText = "Waktu server: " + formatted;
            }

            setInterval(updateTime, 1000);
        </script>

        <script>
            document.querySelectorAll('#filterDate, #filterType').forEach(el => {
                el.addEventListener('change', () => {
                    const date = document.getElementById('filterDate').value;
                    const type = document.getElementById('filterType').value;
                    if (date && type) {
                        const baseUrl = "{{ route('dashboard.index') }}";
                        window.location.href = `${baseUrl}?type=${type}&date=${date}`;
                    }
                });
            });
        </script>
        <script>
            // Simpan posisi scroll sebelum reload
            window.addEventListener('beforeunload', function () {
                localStorage.setItem('scrollPos', window.scrollY);
            });

            // Kembalikan posisi scroll setelah halaman selesai dimuat
            window.addEventListener('load', function () {
                const scrollPos = localStorage.getItem('scrollPos');
                if (scrollPos) {
                    window.scrollTo(0, parseInt(scrollPos));
                    localStorage.removeItem('scrollPos'); // Opsional: hapus agar tidak terus-terusan
                }
            });
        </script>
    @endpush
@endsection