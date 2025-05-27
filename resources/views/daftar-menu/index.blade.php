@extends('layouts.main')
@section('DaftarMenu', 'active')
@section('container')
@section('title', "Daftar Menu | BdiM’s Stock")

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">Menu</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Daftar Menu</li>
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

        @if (session()->has('warning'))
            <div class="alert alert-warning alert-dismissible" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-exclamation-triangle me-2" aria-hidden="true"></i>
                        &nbsp{{ session()->get('warning') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel menu </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBarang" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah menu
                                    </button>
                                    <div class="col-sm-3 float-end mt-3">
                                        <div class="d-flex gap-2">
                                            <a href="/daftar-menu" class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/daftar-menu" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Search" value="{{ request('search') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th style="width: 110px">Gambar</th>
                                                <th>Nama Menu</th>
                                                <th>Bahan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($menus->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($menus as $menu)
                                                    <tr>
                                                        <td>{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <img src="{{ asset($menu->image ?? 'img/dummy/ss_menu.png') }}"
                                                                style="width: 100px; max-height: 100px;" alt="Img">
                                                        </td>
                                                        <td>{{ $menu->name }}</td>

                                                        <td>
                                                            <ul>
                                                                @foreach($menu->komposisi as $komposisi)<li
                                                                    class="{{ $komposisi->bahan->deleted_at ? 'text-danger' : '' }}">
                                                                    {{ $komposisi->bahan->name }} -
                                                                    {{ rtrim(rtrim(number_format($komposisi->jumlah, 3, ',', '.'), '0'), ',') }}
                                                                    {{ $komposisi->bahan->satuan->name }}
                                                                </li>@endforeach
                                                            </ul>
                                                        </td>

                                                        <td>


                                                            <button type="button" class="btn btn-primary btn-sm btn_editmenu"
                                                                data-id="{{ $menu->id }}" data-name="{{ $menu->name }}"
                                                                data-description="{{ $menu->description }}"
                                                                data-image="{{ $menu->image }}"
                                                                data-komposisi='@json($menu->komposisi)'>
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>
                                                            <form action="{{ route('daftar-menu.delete') }}" method="POST"
                                                                class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $menu->id }}">
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin ingin Mendelete Menu?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $menus->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Hidden HTML untuk bahan dropdown -->
        <div id="bahanOptions" class="d-none">
            <select class="form-select form-control select2">
                <option value="">-- Pilih Satuan --</option>
                @foreach($bahans as $bahan)
                    <option value="{{ $bahan->id }}" data-satuan="{{ $bahan->satuan->name }}">
                        {{ $bahan->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <!-- Modal Tambah Barang-->

        <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90%; width: 600px;">

                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action='/daftar-menu' enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <small class="form-text text-danger">*Format: jpeg,jpg,png,webp | max:3 MB</small>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label text-dark fw-bold">Nama Menu</label>
                                <input type="text" required class="form-control" id="name" name="name"
                                    placeholder="Input Nama Menu" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                                <textarea class="form-control" required autocomplete="off" id="description"
                                    name="description" rows="4" placeholder="Deskripsi menu"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Bahan</label>
                                <div id="bahanContainer">
                                    <!-- Akan diisi dinamis lewat JS -->
                                </div>
                                <button type="button" class="btn btn-success" id="addBahan">+ Tambah Bahan</button>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMenuForm" method="POST" enctype="multipart/form-data">

                            @method('PUT')
                            @csrf
                            <input type="hidden" id="editMenuId" name="id">

                            <div class="mb-3">
                                <label for="image" class="form-label text-dark fw-bold">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <small class="form-text text-danger">*Format: jpeg,jpg,png,webp | max:3 MB</small>
                            </div>

                            <div class="mb-3" id="previewGambar" style="display:none;">
                                <label for="previewGambar" class="form-label text-dark fw-bold">Gambar sebelumnya</label>
                                <img id="previewImage" src="" alt="Preview Gambar" class="img-thumbnail mt-2"
                                    style="display: none; width: 100px;">
                                <button type="button" class="btn btn-danger btn-sm mt-2 ms-2" id="btnHapusGambar">
                                    <i class="fa fa-trash"></i> Hapus Gambar
                                </button>
                            </div>

                            <div class="mb-3">
                                <label for="editMenuName" class="form-label text-dark fw-bold">Nama Menu</label>
                                <input type="text" class="form-control" id="editMenuName" name="name" required
                                    autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label for="editMenuDescription" class="form-label text-dark fw-bold">Deskripsi</label>
                                <textarea class="form-control" id="editMenuDescription" name="description" required
                                    autocomplete="off"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Bahan</label>
                                <div id="editBahanContainer">
                                    <!-- Komposisi menu akan diisi dengan JavaScript -->
                                </div>
                                <button type="button" class="btn btn-success" id="addEditBahan">+ Tambah Bahan</button>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('addScript')
        <script>
            function previewImage(input) {
                const preview = document.getElementById('previewImage');
                const btnHapus = document.getElementById('btnHapusGambar');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'inline-block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.getElementById("btnHapusGambar").addEventListener("click", function () {
                const id = document.getElementById("editMenuId").value;
                if (confirm("Yakin ingin menghapus gambar ini?")) {
                    window.location.href = `/daftar-menu/delete-image/${id}`;
                }
            });
        </script>
    @endpush

@endsection