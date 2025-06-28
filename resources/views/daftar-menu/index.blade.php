@extends('layouts.main')
@section('DaftarMenu', 'active')
@section('container')
@section('title', "Daftar Menu | B.di.M’s Stock")

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
        @include('layouts.components.alert-flash-messages')
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> Tabel Menu </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBarang" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Menu
                                    </button>
                                    <div class="col-sm-4 float-end mt-3">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-secondary filterCustom" data-bs-toggle="modal"
                                                data-bs-target="#filterModal">
                                                <i class="fa fa-filter"></i>
                                            </button>
                                            <a href="/daftar-menu" class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/daftar-menu" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Cari menu..."
                                                    value="{{ request('search') }}">
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="column-nomor-menuT">No.</th>
                                                @if ($settings['show_image_menu'] ?? true)
                                                    <th class="column-image-menuT">Gambar</th>
                                                @endif
                                                <th class="column-name-menuT">Nama Menu</th>
                                                @if ($settings['show_keteranganM'] ?? true)
                                                    <th class="column-description-menuT">Deskripsi</th>
                                                @endif
                                                <th class="column-bahan-menuT">Bahan</th>
                                                <th class="column-action-menuT">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($menus as $menu)
                                                <tr>
                                                    <td class="column-nomor-menuT">{{ ($menus->currentPage() - 1) * $menus->perPage() + $loop->iteration }}
                                                    </td>
                                                    @if ($settings['show_image_menu'] ?? true)
                                                        <td class="text-center column-image-menuT">
                                                            <img src="{{ asset($menu->image ?? 'img/dummy/ss_menu.png') }}"
                                                                style="width: 100px; max-height: 100px;" alt="Img">
                                                        </td>
                                                    @endif
                                                    <td class="column-name-menuT">{{ $menu->name }}</td>
                                                    @if ($settings['show_keteranganM'] ?? true)
                                                        <td class="column-description-menuT">{!! nl2br(e($menu->description)) !!}</td>
                                                    @endif
                                                    <td class="column-bahan-menuT">
                                                        <ul>
                                                            @foreach($menu->komposisi as $komposisi)<li
                                                                class="{{ $komposisi->bahan->deleted_at ? 'text-danger' : '' }}">
                                                                {{ $komposisi->bahan->name }} -
                                                                {{ rtrim(rtrim(number_format($komposisi->jumlah, 3, ',', '.'), '0'), ',') }}
                                                                {{ $komposisi->bahan->satuan->name }}
                                                            </li>@endforeach
                                                        </ul>
                                                    </td>

                                                    <td class="column-action-menuT">
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
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Tidak ada data yang
                                                        ditemukan.</td>
                                                </tr>
                                            @endforelse
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
                <option value="">-- Pilih Bahan --</option>
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
                        <h1 class="modal-title text-primary fw-bold fs-5" id="exampleModalLabel">Tambah Menu</h1>
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
                                    placeholder="Masukkan nama menu..." autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label text-dark fw-bold">Deskripsi</label>
                                <textarea class="form-control" required autocomplete="off" id="description"
                                    name="description" rows="4" placeholder="Deskripsi menu..."></textarea>
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
            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90%; width: 600px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary fw-bold fs-5" id="exampleModalLabel">Edit Menu</h5>
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
                                    autocomplete="off" placeholder="Masukkan nama menu...">
                            </div>

                            <div class="mb-3">
                                <label for="editMenuDescription" class="form-label text-dark fw-bold">Deskripsi</label>
                                <textarea class="form-control" id="editMenuDescription" name="description" required
                                    autocomplete="off" rows="4" placeholder="Deskripsi menu..."></textarea>
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
                                'show_image_menu' => ['label' => 'Gambar', 'default' => true],
                                'show_keteranganM' => ['label' => 'Deskripsi menu', 'default' => true],
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
                            <label for="paginationSelect" class="form-label fw-bold text-dark">Jumlah Per Halaman</label>
                            <select class="form-select" name="pagination_menu" id="paginationSelect">
                                <option value="20" {{ ($settings['pagination_menu'] ?? 20) == 20 ? 'selected' : '' }}>20
                                </option>
                                <option value="50" {{ ($settings['pagination_menu'] ?? 20) == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ ($settings['pagination_menu'] ?? 20) == 100 ? 'selected' : '' }}>100
                                </option>
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