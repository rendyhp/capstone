@extends('layouts.main')
@section('DataBahan', 'active')
@section('container')

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">History Input Nama</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="" href="/data-bahan">Data Bahan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">History Input - Nama</li>
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
                        <div class="card-title fs-5 fw-bold mt-2"> History INput bahan Nama </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Bahan
                                    </button>
                                    <div class="col-sm-2 float-end mt-3">
                                        <form action="/data-bahan/historyInput" method="get" class="form-inline"
                                            onsubmit="">
                                            <input class="form-control form-control-sm" type="text" name="search"
                                                placeholder="Search" value="{{request('search')}}">
                                        </form>
                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($historyInputs->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($historyInputs as $historyInput)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $historyInput->name }}</td>
                                                        <td>
                                                            @if (strpos($historyInput->minimum, '.') === false)
                                                                {{ intval($historyInput->minimum) }}
                                                            @else
                                                                {{ rtrim(rtrim($historyInput->minimum, '0'), '.') }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $historyInput->satuan->name ?? '-' }}</td>

                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editbahan">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>



                                                            <form action="/data-bahan/delete/{{ $historyInput->id }}"
                                                                class="d-inline" method="post">
                                                                @method('PUT')
                                                                @csrf
                                                                <button class="btn btn-danger btn-sm" type="submit"
                                                                    onclick="return confirm('Yakin akan Mendelete Data?')"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </form>

                                                            <button type="button" class="btn btn-outline-success"
                                                                onclick="window.location.href='{{ url('/data-bahan/historyBahan/' . $historyInput->id) }}'">
                                                                <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Stok
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $historyInputs->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Bahan Nama</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="/data-bahan/historyBahan/{{ $bahans->id }}/store">
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}"
                                required>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="jumlah" class="form-label text-dark fw-bold me-2">Jumlah</label>
                            <input type="number" step="1" min="1" required class="form-control number0" id="jumlah"
                                name="jumlah" value="1" style="max-width: 150px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Satuan</label>
                            <input type="number" step="1" min="1" required class="form-control number0" id="jumlah"
                                name="jumlah" value="1" style="max-width: 150px;">

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" name="SaveButton">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection