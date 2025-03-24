@extends('layouts.main')
@section('menu', 'active')
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
                                    <form action="/daftar-menu" method="get" class="form-inline" onsubmit="">
                                        <input class="form-control form-control-sm" type="text" name="search"
                                            placeholder="Search" value="{{request('search')}}">
                                    </form>
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
                                                                <li>{{ $komposisi->bahan->name }} - {{ $komposisi->jumlah }}
                                                                    {{ $komposisi->bahan->satuan->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>

                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm btn_editbarang"
                                                            data-id="{{ $menu->id }}">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </button>

                                                        <form action="/daftar-menu/{{ $menu->id }}" class="d-inline"
                                                            method="post">
                                                            @method('DELETE')
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
                        {{ $menus->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection