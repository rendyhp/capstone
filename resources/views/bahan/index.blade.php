@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')
@section('title', 'Manajemen Bahan | Bdim’s Stock')

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Stok Bahan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Stok Bahan - Manajemen Bahan</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.components.alert-flash-messages')
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="mb-3 row mb-0">
                <label for="tanggalbahan" class="col-sm-3 col-form-label me-2">Tanggal</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="tanggalbahan" name="date" value="{{ $date }}">
                </div>
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

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Bar </div>
                        <div>
                            <span id="tanggal-terformat"
                                class="badge bg-primary text-white ms-3">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <div class="col-sm-4 float-end">
                                        <div class="d-flex gap-2 mb-2">
                                            <button class="btn btn-secondary filterCustom" data-bs-toggle="modal"
                                                data-bs-target="#filterModal">
                                                <i class="fa fa-filter"></i>
                                            </button>
                                            <form action="/bahan/manajemen-bahan" method="GET" class="d-inline">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm"
                                                    title="Refresh">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </form>
                                            <form action="/bahan/manajemen-bahan" method="get" class="form-inline d-flex">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search1" placeholder="Cari bahan bar..."
                                                    value="{{ request('search1') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="column-nomor-bhn">No.</th>
                                                <th class="column-image-bhn"
                                                    style="{{ ($settings['show_image_bahan'] ?? false) ? '' : 'display: none;' }}">
                                                    Gambar</th>
                                                <th class="column-name-bhn">Nama Bahan</th>
                                                @if ($settings['show_keterangan'] ?? true)
                                                    <th class="column-description-bhn">Deskripsi</th>
                                                @endif
                                                @if ($settings['show_awal'] ?? true)
                                                    <th class="column-awal-bhn text-center">Awal</th>
                                                @endif
                                                @if ($settings['show_masuk'] ?? true)
                                                    <th class="column-masuk-bhn text-center">Masuk</th>
                                                @endif
                                                @if ($settings['show_terpakai'] ?? true)
                                                    <th class="column-terpakai-bhn text-center">Terpakai</th>
                                                @endif
                                                @if ($settings['show_sisa'] ?? true)
                                                    <th class="column-sisa-bhn text-center">Sisa</th>
                                                @endif
                                                @if ($settings['show_akhir'] ?? true)
                                                    <th class="column-akhir-bhn text-center">Akhir Sebenarnya</th>
                                                @endif
                                                @if ($settings['show_terbuang'] ?? true)
                                                    <th class="column-terbuang-bhn text-center">Terbuang</th>
                                                @endif
                                                @if ($settings['show_minimum'] ?? false)
                                                    <th class="column-minimum-bhn text-center">Minimum</th>
                                                @endif
                                                <th class="column-satuan-bhn">Satuan</th>
                                                @if ($settings['show_catatan'] ?? true)
                                                    <th class="column-catatan-bhn">Catatan</th>
                                                @endif
                                                <th class="column-action-bhn">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bahan_bars as $bahan)
                                                <tr>
                                                    <td class="column-nomor-bhn">
                                                        {{ ($bahan_bars->currentPage() - 1) * $bahan_bars->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="text-center column-image-bhn"
                                                        style="{{ ($settings['show_image_bahan'] ?? false) ? '' : 'display: none;' }}">
                                                        <img src="{{ asset($bahan->image ?? 'img/dummy/ss_bahan.png') }}"
                                                            style="width: 100px; max-height: 100px;" alt="Img">
                                                    </td>
                                                    <td class="column-name-bhn">
                                                        <a class="text-dark text-decoration-none"
                                                            href="{{ route('bahan.indexbyId', ['encryptedId' => Hashids::encode($bahan->id)]) }}">
                                                            {{ $bahan->name }}
                                                        </a>
                                                    </td>

                                                    @if ($settings['show_keterangan'] ?? true)
                                                        <td class="column-description-bhn">{!! nl2br(e($bahan->description)) !!}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_awal'] ?? true)
                                                        <td class="text-end editable {{ optional($bahan)->awal_manual ? 'bg-khaki' : '' }} column-awal-bhn"
                                                            ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'awal', '{{ $bahan->jumlah_awal }}', '{{ $bahan->name }}', '{{ $bahan->satuan->name }}')">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_awal, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_masuk'] ?? true)
                                                        <td class="text-end column-masuk-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_masuk, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_terpakai'] ?? true)
                                                        <td class="text-end column-terpakai-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_terpakai, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_sisa'] ?? true)
                                                        <td class="text-end column-sisa-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_akhir'] ?? true)
                                                        <td class="text-end editable {{ $bahan->akhir_manual ? 'bg-khaki' : '' }} column-akhir-bhn"
                                                            ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'akhir', '{{ $bahan->bahan_akhir }}', '{{ $bahan->name }}', '{{ $bahan->satuan->name }}')">
                                                            {{ rtrim(rtrim(number_format($bahan->bahan_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_terbuang'] ?? true)
                                                        @php
                                                            $value = $bahan->bahan_terbuang;
                                                            $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                                        @endphp <td class="text-end column-terbuang-bhn">
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
                                                    @endif
                                                    @if ($settings['show_minimum'] ?? false)
                                                        <td class="text-end column-minimum-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->minimum, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    <td>{{ $bahan->satuan->name ?? '-' }}</td>

                                                    @if ($settings['show_catatan'] ?? true)
                                                        <td class="editable column-catatan-bhn" ondblclick="editCatatan(this)"
                                                            data-id="{{ $bahan->id }}" data-date="{{ $date }}"
                                                            data-catatan="{{ htmlentities($bahan->catatanBA->catatan ?? '', ENT_QUOTES) }}"
                                                            data-bahan_name="{{ $bahan->name }}" style="max-width: 150px;">
                                                            {!! nl2br(e($bahan->catatanBA->catatan ?? '-')) !!}
                                                        </td>
                                                    @endif
                                                    <td class="column-action-bhn">
                                                        <!-- Tombol Tambah -->
                                                        <button type="button" class="btn btn-outline-success btnTambahStok"
                                                            data-id="{{ $bahan->id ?? 'NULL' }}"
                                                            data-name="{{ $bahan->name ?? 'NULL'}}"
                                                            data-satuan="{{ $bahan->satuan->name ?? '-' }}"
                                                            data-bs-toggle="modal" data-bs-target="#barangModalM">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="window.location.href='{{ route('bahan.indexBahanMKbyID', ['encryptedId' => Hashids::encode($bahan->id)]) }}'">
                                                            <i class="fa fa-info me-2"></i>History
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if ($bahan_bars->isEmpty())
                                                <tr>
                                                    <td colspan="100%" class="text-center text-muted py-3">Tidak ada data yang
                                                        ditemukan.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                            </table>
                            {{ $bahan_bars->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Kitchen </div>
                        <div>
                            <span id="tanggal-terformat"
                                class="badge bg-primary text-white ms-3">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <div class="col-sm-4 float-end">
                                        <div class="d-flex gap-2 mb-2">
                                            <button class="btn btn-secondary filterCustom" data-bs-toggle="modal"
                                                data-bs-target="#filterModal">
                                                <i class="fa fa-filter"></i>
                                            </button>
                                            <form action="/bahan/manajemen-bahan" method="GET" class="d-inline">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm"
                                                    title="Refresh">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </form>
                                            <form action="/bahan/manajemen-bahan" method="get" class="form-inline d-flex">
                                                <input type="hidden" name="date"
                                                    value="{{ request('date', now()->toDateString()) }}">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search2" placeholder="Cari bahan dapur..."
                                                    value="{{ request('search2') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="column-nomor-bhn">No.</th>
                                                <th class="column-image-bhn"
                                                    style="{{ ($settings['show_image_bahan'] ?? false) ? '' : 'display: none;' }}">
                                                    Gambar</th>
                                                <th class="column-name-bhn">Nama Bahan</th>
                                                @if ($settings['show_keterangan'] ?? true)
                                                    <th class="column-description-bhn">Deskripsi</th>
                                                @endif
                                                @if ($settings['show_awal'] ?? true)
                                                    <th class="column-awal-bhn text-center">Awal</th>
                                                @endif
                                                @if ($settings['show_masuk'] ?? true)
                                                    <th class="column-masuk-bhn text-center">Masuk</th>
                                                @endif
                                                @if ($settings['show_terpakai'] ?? true)
                                                    <th class="column-terpakai-bhn text-center">Terpakai</th>
                                                @endif
                                                @if ($settings['show_sisa'] ?? true)
                                                    <th class="column-sisa-bhn text-center">Sisa</th>
                                                @endif
                                                @if ($settings['show_akhir'] ?? true)
                                                    <th class="column-akhir-bhn text-center">Akhir Sebenarnya</th>
                                                @endif
                                                @if ($settings['show_terbuang'] ?? true)
                                                    <th class="column-terbuang-bhn text-center">Terbuang</th>
                                                @endif
                                                @if ($settings['show_minimum'] ?? false)
                                                    <th class="column-minimum-bhn text-center">Minimum</th>
                                                @endif
                                                <th>Satuan</th>
                                                @if ($settings['show_catatan'] ?? true)
                                                    <th class="column-catatan-bhn">Catatan</th>
                                                @endif
                                                <th class="column-action-bhn">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bahan_kitchens as $bahan)
                                                <tr>
                                                    <td class="column-nomor-bhn">
                                                        {{ ($bahan_kitchens->currentPage() - 1) * $bahan_kitchens->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="column-image-bhn"
                                                        style="{{ ($settings['show_image_bahan'] ?? false) ? '' : 'display: none;' }}">
                                                        <img src="{{ asset($bahan->image ?? 'img/dummy/ss_bahan.png') }}"
                                                            style="width: 100px; max-height: 100px;" alt="Img">
                                                    </td>
                                                    <td class="column-name-bhn">
                                                        <a class="text-dark text-decoration-none"
                                                            href="{{ route('bahan.indexbyId', ['encryptedId' => Hashids::encode($bahan->id)]) }}">
                                                            {{ $bahan->name }}
                                                        </a>
                                                    </td>
                                                    @if ($settings['show_keterangan'] ?? true)
                                                        <td class="column-description-bhn">{!! nl2br(e($bahan->description)) !!}
                                                        </td>
                                                    @endif


                                                    @if ($settings['show_awal'] ?? true)
                                                        <td class="text-end editable {{ $bahan->awal_manual ? 'bg-khaki' : '' }} column-awal-bhn"
                                                            ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'awal', '{{ $bahan->jumlah_awal }}', '{{ $bahan->name }}', '{{ $bahan->satuan->name }}')">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_awal, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_masuk'] ?? true)
                                                        <td class="text-end column-masuk-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_masuk, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_terpakai'] ?? true)
                                                        <td class="text-end column-terpakai-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_terpakai, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_sisa'] ?? true)
                                                        <td class="text-end column-sisa-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->jumlah_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_akhir'] ?? true)
                                                        <td class="text-end editable {{ $bahan->akhir_manual ? 'bg-khaki' : '' }} column-akhir-bhn"
                                                            ondblclick="editJumlah('{{ $bahan->id }}', '{{ $date }}', 'akhir', '{{ $bahan->bahan_akhir }}', '{{ $bahan->name }}', '{{ $bahan->satuan->name }}')">
                                                            {{ rtrim(rtrim(number_format($bahan->bahan_akhir, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif

                                                    @if ($settings['show_terbuang'] ?? true)
                                                        @php
                                                            $value = $bahan->bahan_terbuang;
                                                            $formatted = rtrim(rtrim(number_format(abs($value), 3, ',', '.'), '0'), ',');
                                                        @endphp <td class="text-end column-terbuang-bhn">
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
                                                    @endif

                                                    @if ($settings['show_minimum'] ?? false)
                                                        <td class="text-end column-minimum-bhn">
                                                            {{ rtrim(rtrim(number_format($bahan->minimum, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                    @endif
                                                    <td class="column-satuan-bhn">{{ $bahan->satuan->name ?? '-' }}</td>
                                                    @if ($settings['show_catatan'] ?? true)
                                                        <td class="editable column-catatan-bhn" ondblclick="editCatatan(this)"
                                                            data-id="{{ $bahan->id }}" data-date="{{ $date }}"
                                                            data-catatan="{{ htmlentities($bahan->catatanBA->catatan ?? '', ENT_QUOTES) }}"
                                                            data-bahan_name="{{ $bahan->name }}" style="max-width: 150px;">
                                                            {!! nl2br(e($bahan->catatanBA->catatan ?? '-')) !!}
                                                        </td>
                                                    @endif
                                                    <td class="column-action-bhn">
                                                        <button type="button" class="btn btn-outline-success btnTambahStok"
                                                            data-id="{{ $bahan->id ?? 'NULL' }}"
                                                            data-name="{{ $bahan->name ?? 'NULL'}}"
                                                            data-satuan="{{ $bahan->satuan->name ?? '-' }}"
                                                            data-bs-toggle="modal" data-bs-target="#barangModalM">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="window.location.href='{{ route('bahan.indexBahanMKbyID', ['encryptedId' => Hashids::encode($bahan->id)]) }}'">
                                                            <i class="fa fa-info me-2"></i>History
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if ($bahan_kitchens->isEmpty())
                                                <tr>
                                                    <td colspan="100%" class="text-center text-muted py-3">Tidak ada data yang
                                                        ditemukan.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </div>
                                </div>
                            </table>
                            {{ $bahan_kitchens->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Input bahan awal dan akhir dengandouble click -->
    <div class="modal fade" id="modalEditJumlah" tabindex="-1" aria-labelledby="modalEditJumlahLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="modalEditJumlahLabel">Edit Jumlah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditJumlah">
                        @csrf
                        <input type="hidden" name="bahan_id" id="bahan_id">
                        <input type="hidden" name="date" id="date">
                        <input type="hidden" name="type" id="type">

                        <div class="mb-2">
                            <small id="infoJumlahDate" class="badge text-white border p-2 me-2"
                                style="background-color: #0d6efd;"></small>
                            <small id="infoJumlahType" class="badge text-white border p-2"
                                style="background-color: #198754;"></small>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_input" class="form-label text-dark fw-bold">Jumlah<small id="satuanBahanText"
                                    class="text-muted ms-1"></small>:</label>
                            <input type="number" step="0.001" id="jumlah_input" name="jumlah" max="99999999999.999"
                                class="form-control number0" required>

                        </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" id="resetJumlahBtn">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Edit Catatan -->
    <div class="modal fade" id="modalEditCatatan" tabindex="-1" aria-labelledby="modalEditCatatanLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 fw-bold text-primary" id="modalEditCatatanLabel">Edit Catatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditCatatan">
                        @csrf
                        <input type="hidden" name="catatan_bahan_id" id="catatan_bahan_id">
                        <input type="hidden" name="catatan_date" id="catatan_date">

                        <div class="mb-2">
                            <small id="infoCatatanDate" class="badge text-white border p-2 me-2"
                                style="background-color: #0d6efd;"></small>
                        </div>

                        <div class="mb-3">
                            <textarea name="catatan_input" id="catatan_input" class="form-control" rows="5"
                                placeholder="Tulis catatan..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bahan Masuk -->
    <div class="modal fade" id="barangModalM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Bahan Masuk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/bahan/manajemen-bahan/storeM'>
                        @csrf
                        <div class="mb-3">
                            <input type="text" hidden name="id" id="stokBarangIdM">
                            <label class="form-label text-dark fw-bold">Tanggal</label>
                            <input type="date" style="width: initial;" class="form-control" name="date" id="stokDateM"
                                value="{{ $date }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Nama Barang</label>
                            <input type="text" disabled class="form-control  @error('name') is-invalid @enderror"
                                id="stokBarangNameM">
                            @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Jumlah</label>
                            <input type="number" min="0" class="form-control number0" name="jumlah" step="0.001" value="0"
                                autocomplete="off" max="99999999999.999" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Satuan</label>
                            <input type="text" disabled class="form-control  @error('satuan') is-invalid @enderror"
                                id="stokBarangSatuanM">
                            @error('satuan') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label text-dark fw-bold">Catatan</label>
                            <textarea class="form-control" autocomplete="off" id="stokKeteranganM" required
                                name="keterangan" rows="4"
                                placeholder="Misal: Beli {{ $bahan->name ?? '' }} baru atau Beli cash..."></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
            </div>
            </form>
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
                                'show_image_bahan' => ['label' => 'Gambar', 'default' => false],
                                'show_keterangan' => ['label' => 'Deskripsi bahan', 'default' => true],
                                'show_awal' => ['label' => 'Awal', 'default' => true],
                                'show_masuk' => ['label' => 'Masuk', 'default' => true],
                                'show_terpakai' => ['label' => 'Terpakai', 'default' => true],
                                'show_sisa' => ['label' => 'Sisa', 'default' => true],
                                'show_akhir' => ['label' => 'Akhir Sebenarnya', 'default' => true],
                                'show_terbuang' => ['label' => 'Terbuang', 'default' => true],
                                'show_minimum' => ['label' => 'Minimum', 'default' => false],
                                'show_catatan' => ['label' => 'Catatan', 'default' => true],
                            ];
                        @endphp

                        <label class="form-label fw-bold text-dark">Tampilan Kolom:</label>
                        @foreach ($columns as $key => $column)
                            <div class="form-check">
                                <input type="hidden" name="{{ $key }}" value="0">
                                <input class="form-check-input" type="checkbox" name="{{ $key }}" value="1" id="{{ $key }}" {{ ($settings[$key] ?? $column['default']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $key }}">
                                    {{ $column['label'] }}
                                </label>
                            </div>
                        @endforeach
                        <hr>

                        {{-- Select Pagination --}}
                        <div class="mb-3">
                            <label for="paginationSelectBar" class="form-label fw-bold text-dark">Jumlah Per Halaman
                                (BAR):</label>
                            <select class="form-select" name="pagination_bahanBar" id="paginationSelectBar">
                                <option value="5" {{ ($settings['pagination_bahanBar'] ?? 20) == 5 ? 'selected' : '' }}>5
                                </option>
                                <option value="20" {{ ($settings['pagination_bahanBar'] ?? 20) == 20 ? 'selected' : '' }}>20
                                </option>
                                <option value="50" {{ ($settings['pagination_bahanBar'] ?? 20) == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ ($settings['pagination_bahanBar'] ?? 20) == 100 ? 'selected' : '' }}>
                                    100</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="paginationSelectKitchen" class="form-label fw-bold text-dark">Jumlah Per Halaman
                                (KITCHEN):</label>
                            <select class="form-select" name="pagination_bahanKitchen" id="paginationSelectKitchen">
                                <option value="5" {{ ($settings['pagination_bahanKitchen'] ?? 20) == 5 ? 'selected' : '' }}>5
                                </option>
                                <option value="20" {{ ($settings['pagination_bahanKitchen'] ?? 20) == 20 ? 'selected' : '' }}>
                                    20</option>
                                <option value="50" {{ ($settings['pagination_bahanKitchen'] ?? 20) == 50 ? 'selected' : '' }}>
                                    50</option>
                                <option value="100" {{ ($settings['pagination_bahanKitchen'] ?? 20) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('addScript')
        <script>
            function editCatatan(el) {
                const id = el.getAttribute('data-id');
                const date = el.getAttribute('data-date');
                const catatan = el.getAttribute('data-catatan');
                const bahan_name = el.getAttribute('data-bahan_name');

                document.getElementById('catatan_bahan_id').value = id;
                document.getElementById('catatan_date').value = date;
                document.getElementById('catatan_input').value = catatan;
                document.getElementById('modalEditCatatanLabel').innerText = `Edit Catatan (${bahan_name})`;
                document.getElementById('infoCatatanDate').innerText = formatTanggalIndo(date);

                $("#modalEditCatatan").modal("show");
            }

            document.getElementById('formEditCatatan').addEventListener('submit', function (e) {
                e.preventDefault();

                let form = e.target;
                let bahan_id = form.catatan_bahan_id.value;
                let date = form.catatan_date.value;
                let catatan = form.catatan_input.value;
                let _token = form.querySelector('input[name="_token"]').value;

                fetch('/bahan/catatan/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': _token
                    },
                    body: JSON.stringify({ bahan_id, date, catatan })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Catatan berhasil disimpan!');
                            location.reload();
                        } else {
                            alert('Gagal menyimpan catatan');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan.');
                    });
            });
        </script>


        <script>
            function editJumlah(bahan_id, date, type, currentJumlah, bahan_name, satuan) {
                var formattedJumlah = currentJumlah % 1 === 0 ? parseInt(currentJumlah) : currentJumlah;

                document.getElementById('bahan_id').value = bahan_id;
                document.getElementById('date').value = date;
                document.getElementById('type').value = type;
                document.getElementById('jumlah_input').value = formattedJumlah;
                document.getElementById('modalEditJumlahLabel').innerText = `Edit Jumlah (${bahan_name})`;
                document.getElementById('infoJumlahDate').innerText = formatTanggalIndo(date);
                document.getElementById('infoJumlahType').innerText = type === 'awal' ? 'Bahan Awal' : 'Akhir Sebenarnya';
                document.getElementById('satuanBahanText').innerText = `(${satuan})`;

                $("#modalEditJumlah").modal("show");
            }


            document.getElementById('formEditJumlah').addEventListener('submit', function (e) {
                e.preventDefault();

                let form = e.target;
                let bahan_id = form.bahan_id.value;
                let date = form.date.value;
                let type = form.type.value; // 'awal' or 'akhir'
                let jumlah = form.jumlah.value;
                let _token = form.querySelector('input[name="_token"]').value;

                let url = type === 'awal' ? '/bahanAwal/save' : '/bahanAkhir/save';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': _token
                    },
                    body: JSON.stringify({ bahan_id, date, jumlah })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Data berhasil disimpan!');
                            location.reload();
                        } else if (data.error2) {
                            alert('Hanya bisa edit Bahan Awal pada Tanggal 01')
                        } else {
                            alert('Gagal menyimpan data');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan.');
                    });
            });
        </script>
        <script>
            document.getElementById('resetJumlahBtn').addEventListener('click', function () {
                const bahan_id = document.getElementById('bahan_id').value;
                const date = document.getElementById('date').value;
                const type = document.getElementById('type').value;
                const _token = document.querySelector('input[name="_token"]').value;

                if (!confirm('Yakin ingin menghapus jumlah ini?')) return;

                let url = type === 'awal' ? '/bahanAwal/delete' : '/bahanAkhir/delete';

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': _token
                    },
                    body: JSON.stringify({ bahan_id, date })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Data berhasil di-reset!');
                            location.reload();
                        } else {
                            alert('Data tidak ditemukan.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan saat menghapus data.');
                    });
            });
        </script>
        <script>
            const tanggalInput = document.getElementById('tanggalbahan');
            const tanggalTerformat = document.getElementById('tanggal-terformat');

            function formatTanggalIndo(tanggalStr) {
                const bulanIndo = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];

                const dateObj = new Date(tanggalStr);
                const tanggal = dateObj.getDate();
                const bulan = bulanIndo[dateObj.getMonth()];
                const tahun = dateObj.getFullYear();

                return `${tanggal} ${bulan} ${tahun}`;
            }

            tanggalInput.addEventListener('change', function () {
                const selectedDate = this.value;
                if (selectedDate) {
                    tanggalTerformat.textContent = formatTanggalIndo(selectedDate);
                    const baseUrl = "{{ url('/bahan/manajemen-bahan') }}";
                    window.location.href = `${baseUrl}?date=${selectedDate}`;
                }
            });
        </script>

    @endpush

@endsection