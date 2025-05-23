@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')
@section('title', "Master Bahan | BdiM’s Stock")

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Master Bahan</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Stok Bahan - Master Bahan</li>
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
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Data Bar </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal1">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data Bar
                                    </button>
                                    <div class="col-sm-3 float-end mt-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" value="" id="toggleImageColumn">
                                            <label class="form-check-label" for="toggleImageColumn">
                                                Tampilkan Gambar
                                            </label>
                                        </div>
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/bahan/data-bahan" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/bahan/data-bahan" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search1" placeholder="Search" value="{{ request('search1') }}">
                                            </form>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th class="column-gambar" style="width: 110px; display: none;">Gambar</th>
                                                <th>Nama Bahan</th>
                                                <th>Deskripsi Bahan</th>
                                                <th>Pengingat Stok Minimum</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($bahan_bars->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($bahan_bars as $bahan)
                                                    <tr>
                                                        <td>{{ ($bahan_bars->currentPage() - 1) * $bahan_bars->perPage() + $loop->iteration }}
                                                        <td class="column-gambar" style="display:none;">
                                                            <img src="{{ asset($bahan->image ?? 'img/dummy/ss_bahan.png') }}"
                                                                style="width: 100px; max-height: 100px;" alt="Img">
                                                        </td>
                                                        <td>{{ $bahan->name }}</td>
                                                        <td style="max-width: 150px">{{ $bahan->description }}</td>
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->minimum, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                        <td>{{ $bahan->satuan->name ?? '-' }}</td>

                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbahan"
                                                                data-id="{{ $bahan->id ?? 'NULL' }}"
                                                                data-name="{{ $bahan->name ?? 'NULL' }}"
                                                                data-description="{{ $bahan->description ?? 'NULL' }}"
                                                                data-minimum="{{ $bahan->minimum ?? 'NULL' }}"
                                                                data-satuan_id="{{ $bahan->satuan_id ?? 'NULL' }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>

                                                            <form action="/bahan/data-bahan/delete/{{ $bahan->id }}"
                                                                class="d-inline" method="post">
                                                                @method('PUT')
                                                                @csrf
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin akan Mendelete Data?')"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Data Kitchen </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal2">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data Kitchen
                                    </button>
                                    <div class="col-sm-3 float-end mt-3">

                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/bahan/data-bahan" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/bahan/data-bahan" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search2" placeholder="Search" value="{{ request('search2') }}">
                                            </form>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th class="column-gambar" style="width: 110px; display: none;">Gambar</th>
                                                <th>Nama Bahan</th>
                                                <th>Deskripsi Bahan</th>
                                                <th>Pengingat Stok Minimum</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($bahan_kitchens->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($bahan_kitchens as $bahan)
                                                    <tr>
                                                        <td>{{ ($bahan_kitchens->currentPage() - 1) * $bahan_kitchens->perPage() + $loop->iteration }}
                                                        <td class="column-gambar" style="display:none;">
                                                            <img src="{{ asset($bahan->image ?? 'img/dummy/ss_bahan.png') }}"
                                                                style="width: 100px; max-height: 100px;" alt="Img">
                                                        </td>
                                                        <td>{{ $bahan->name }}</td>
                                                        <td style="max-width: 150px">{{ $bahan->description }}</td>
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahan->minimum, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                        <td>{{ $bahan->satuan->name ?? '-' }}</td>

                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbahan2"
                                                                data-id="{{ $bahan->id ?? 'NULL' }}"
                                                                data-name="{{ $bahan->name ?? 'NULL' }}"
                                                                data-description="{{ $bahan->description ?? 'NULL' }}"
                                                                data-minimum="{{ $bahan->minimum ?? 'NULL' }}"
                                                                data-satuan_id="{{ $bahan->satuan_id ?? 'NULL' }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>



                                                            <form action="/bahan/data-bahan/delete/{{ $bahan->id }}"
                                                                class="d-inline" method="post">
                                                                @method('PUT')
                                                                @csrf
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin akan Mendelete Data?')"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>


                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $bahan_bars->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Bahan 1-->
    <div class="modal fade" id="barangModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Bar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/bahan/data-bahan/store' enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" hidden name="section" value="BAR">
                            <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold">Nama Bahan Baku</label>
                            <input type="text" required class="form-control" id="name" name="name"
                                placeholder="Contoh: Kopi Arabica" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control" required autocomplete="off" id="description" name="description"
                                rows="4" placeholder="Deskripsi bahan baku"></textarea>

                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="minimum" class="form-label text-dark fw-bold me-2">Pengingat Stok Minimum</label>
                            <input type="number" step="0.001" min="0" max="99999999999.999" required autocomplete="off"
                                class="form-control number0" id="minimum" name="minimum" value="0" readonly
                                style="max-width: 150px;">
                            <button type="button" class="btn btn-primary ms-2" id="toggleMinimum1">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control select2" required autocomplete="off" id="satuan_id_bar"
                                name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Bahan 1-->
    <div class="modal fade" id="barangModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Kitchen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="Post" action='/bahan/data-bahan/store' enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" hidden name="section" value="KITCHEN">
                            <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                            <input type="file" class="form-control" id="image2" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold">Nama Bahan Baku</label>
                            <input type="text" required class="form-control" id="name2" name="name"
                                placeholder="Contoh: Kopi Arabica" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control" required autocomplete="off" id="description2" name="description"
                                rows="4" placeholder="Deskripsi bahan baku"></textarea>

                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="minimum" class="form-label text-dark fw-bold me-2">Pengingat Stok Minimum</label>
                            <input type="number" step="0.001" min="0" max="99999999999.999" required autocomplete="off"
                                class="form-control number0" id="minimum2" name="minimum" value="0" readonly
                                style="max-width: 150px;">
                            <button type="button" class="btn btn-primary ms-2" id="toggleMinimum2">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control select2" required autocomplete="off" id="satuan_id_kitchen"
                                name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Barang-->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Edit Data Bar
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/bahan/data-bahan/edit" id="editBarangForm" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="text" name="section" value="BAR">
                            <input hidden type="text" name="id" id="txtid">
                            <label for="name" class="form-label text-dark fw-bold">Nama Bahan Baku</label>
                            <input type="text" autocomplete="off" required
                                class="form-control @error('name') is-invalid @enderror" id="txtname" name="name">
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="txtdescription"
                                name="description" rows="4" autocomplete="off" required
                                placeholder="Deskripsi bahan baku"></textarea>
                            @error('description')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="txtminimum" class="form-label text-dark fw-bold me-2">Pengingat Stok Minimum</label>
                            <input type="number" step="0.001" min="0" max="99999999999.999" autocomplete="off" required
                                class="form-control number0 @error('minimum') is-invalid @enderror" id="txtminimum"
                                name="minimum" readonly style="max-width: 150px;">
                            <button type="button" class="btn btn-primary ms-2" id="toggleMinimum3">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </button>
                            @error('minimum')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control select2" id="txtsatuan_id" required autocomplete="off"
                                name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}" {{ old('tsatuan_id', $bahan->satuan_id ?? '') == $satuan->id ? 'selected' : '' }}>
                                        {{ $satuan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Bahan 2-->
    <div class="modal fade" id="editBarangModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Edit Data Kitchen
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/bahan/data-bahan/edit" id="editBarangForm" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="text" name="section" value="KITCHEN">
                            <input hidden type="text" name="id" id="txtid2">
                            <label for="name" class="form-label text-dark fw-bold">Nama Bahan Baku</label>
                            <input type="text" autocomplete="off" required
                                class="form-control @error('name') is-invalid @enderror" id="txtname2" name="name">
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="txtdescription2"
                                name="description" rows="4" autocomplete="off" required
                                placeholder="Deskripsi bahan baku"></textarea>
                            @error('description')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="txtminimum" class="form-label text-dark fw-bold me-2">Pengingat Stok Minimum</label>
                            <input type="number" step="0.001" min="0" max="99999999999.999" autocomplete="off" required
                                class="form-control number0 @error('minimum') is-invalid @enderror" id="txtminimum2"
                                name="minimum" readonly style="max-width: 150px;">
                            <button type="button" class="btn btn-primary ms-2" id="toggleMinimum4">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </button>
                            @error('minimum')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="satuan_id" class="form-label text-dark fw-bold">Satuan</label>
                            <select class="form-control select2" id="txtsatuan_id2" required autocomplete="off"
                                name="satuan_id">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}" {{ old('tsatuan_id', $bahan->satuan_id ?? '') == $satuan->id ? 'selected' : '' }}>
                                        {{ $satuan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('addScript')
        <script>
            function toggleInput(inputId, buttonId) {
                let inputField = document.getElementById(inputId);
                let button = document.getElementById(buttonId);

                if (inputField.readOnly) {
                    inputField.readOnly = false;

                    button.style.display = "none";
                    inputField.focus();
                    inputField.select();

                    inputField.addEventListener("focusout", function lockInput() {
                        inputField.readOnly = true;
                        button.style.display = "inline";
                        inputField.removeEventListener("focusout", lockInput);
                    });
                }
            }
            document.getElementById("toggleMinimum1").addEventListener("click", function () {
                toggleInput("minimum", "toggleMinimum1");
            });
            document.getElementById("toggleMinimum3").addEventListener("click", function () {
                toggleInput("txtminimum", "toggleMinimum3");
            });
            document.getElementById("toggleMinimum2").addEventListener("click", function () {
                toggleInput("minimum2", "toggleMinimum2");
            });
            document.getElementById("toggleMinimum4").addEventListener("click", function () {
                toggleInput("txtminimum2", "toggleMinimum4");
            });
        </script>
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