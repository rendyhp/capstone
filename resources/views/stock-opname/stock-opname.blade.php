@extends('layouts.main')

@section('DataBahan', 'active')

@section('container')
    <style>
        .cards {
            background-color: #f7fcfb;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .cards h3,
        .cards p {
            color: #333;
        }

        .cards p {
            color: #555;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Form Stock Opname</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="" href="/stock-opname">Stock Opname</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form Stock Opname</li>
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

        <div class="d-flex align-items-center mb-3 row">
            <label for="tanggalbahan" class="col-sm-2 col-form-label me-2">Tanggal</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="tanggalbahan" name="date" value="{{ $date }}" readonly>
            </div>
        </div>

        <div class="container cards">
            {{-- Back Button --}}
            <div class="mb-3">
                <a href="{{ url('/stock-opname') }}">
                    <i class="fa fa-angle-double-left me-2" aria-hidden="true"></i>Kembali
                </a>
            </div>


            {{-- Form Input Stok --}}
            <form id="transaksi-form" action="{{ route('stock-opname.simpan.store', ['page' => $currentPage]) }}"
                method="POST">
                @csrf
                <input type="hidden" name="tanggaltransmasuk" value="{{ $date }}">

                {{-- Tabel Bahan --}}
                <table class="table table-bordered text-dark table-sm text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Bahan</th>
                            <th>Jumlah Sebelumnya</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockOpnames as $index => $bahan)
                            <tr>
                                <td>{{ $loop->iteration + (($currentPage - 1) * 20) }}</td>
                                <td>
                                    <input type="hidden" name="bahan_id[]" value="{{ $bahan->id }}">
                                    {{ $bahan->name }}
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center"
                                        value="{{ $bahan->jumlah_sebelumnya !== null ? rtrim(rtrim(number_format($bahan->jumlah_sebelumnya, 3, '.', ''), '0'), '.') : '0' }}"
                                        readonly>
                                </td>

                                <td>
                                    <input type="number" name="jumlah[]" step="0.001" min="0" value="0"
                                        class="form-control text-center number0" required>
                                </td>
                                <td>{{ $bahan->satuan->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Opsi Simpan untuk Besok --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="saveForTomorrow" name="save_for_tomorrow" value="1">
                    <label class="form-check-label fw-bold" for="saveForTomorrow">
                        Simpan juga untuk stok awal besok?
                    </label>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="customDateCheckbox" value="1">
                        <label class="form-check-label" for="customDateCheckbox">Custom Tanggal</label>
                        <input type="date" class="form-control mt-2" id="customDateInput" name="custom_date"
                            style="display: none;">
                    </div>
                </div>

                {{-- Tombol Navigasi --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn {{ $hasNextPage ? 'btn-primary' : 'btn-success' }}">
                        {{ $hasNextPage ? 'Next' : 'Submit' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Script Toggle Custom Date --}}
        <script>
            const saveForTomorrowCheckbox = document.getElementById('saveForTomorrow');
            const customDateCheckbox = document.getElementById('customDateCheckbox');
            const customDateInput = document.getElementById('customDateInput');

            function toggleCustomDateOptions() {
                const isSaveChecked = saveForTomorrowCheckbox.checked;
                customDateCheckbox.disabled = !isSaveChecked;
                if (!isSaveChecked) {
                    customDateCheckbox.checked = false;
                    customDateInput.style.display = 'none';
                }
            }

            saveForTomorrowCheckbox.addEventListener('change', toggleCustomDateOptions);
            customDateCheckbox.addEventListener('change', () => {
                customDateInput.style.display = customDateCheckbox.checked ? 'block' : 'none';
            });

            // Jalankan saat awal page load
            toggleCustomDateOptions();
        </script>
@endsection