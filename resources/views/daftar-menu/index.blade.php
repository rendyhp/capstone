@extends('layouts.main')
@section('DaftarMenu', 'active')
@section('container')

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

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel menu </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBarang" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah menu
                                    </button>
                                    <div class="col-sm-2 float-end mt-3">
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
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $menu->name }}</td>

                                                        <td>
                                                            <ul>
                                                                @foreach($menu->komposisi as $komposisi)
                                                                    <li>{{ $komposisi->bahan->name }} -
                                                                        {{ rtrim(rtrim(number_format($komposisi->jumlah, 3, ',', '.'), '0'), ',') }}
                                                                        {{ $komposisi->bahan->satuan->name }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>

                                                        <td>


                                                            <button type="button" class="btn btn-primary btn-sm btn_editmenu"
                                                                data-id="{{ $menu->id }}" data-name="{{ $menu->name }}"
                                                                data-description="{{ $menu->description }}"
                                                                data-komposisi='@json($menu->komposisi)'>
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>



                                                            <form action="/daftar-menu/delete/{{ $menu->id }}" class="d-inline"
                                                                method="post">
                                                                @method('put')
                                                                @csrf
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin akan Mendelete Menu?')"><i
                                                                        class="fa fa-trash"></i></button>
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
            <div class="container modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="Post" action='/daftar-menu'>
                            @csrf
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

        <!-- Modal Edit Menu -->
        <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMenuForm" method="POST">

                            @method('PUT')

                            @csrf
                            <input type="hidden" id="editMenuId" name="id">

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

                            <div id="editBahanContainer" class="mb-3">
                                <label for="editMenuDescription" class="form-label text-dark fw-bold">Bahan</label>
                                <!-- Komposisi menu akan diisi dengan JavaScript -->
                            </div>
                            <button type="button" class="btn btn-success" id="addEditBahan">+ Tambah Bahan</button>



                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection