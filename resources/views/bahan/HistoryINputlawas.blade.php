@extends('layouts.main')
@section('StokBahan', 'active')
@section('container')



    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">History Input {{ $bahan->name }}</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="" href="/stok-bahan">Stok Bahan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">History Input - {{ $bahan->name }}
                                </li>
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

        <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
            <h4 class="mb-0 align-items-center justify-content-center">Riwayat Penambahan Stok untuk Bahan:
                <strong>{{ $bahan->name }}</strong>
            </h4>
            <button type="button" id="backStokBahan"
                class="btn  btn-sm d-flex align-items-center justify-content-center fw-bold"
                style="width: 38px; height: 32px; background-color: #e0e0e0;"
                onclick="window.location.href='{{ url('/stok-bahan') }}'">
                X
            </button>

        </div>




        <div class=" row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title fs-5 fw-bold mt-2"> History Input {{ $bahan->name }} </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBahan" class="table table-bordered text-dark table-sm" style="" border="1">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#barangModal">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Stok
                                    </button>
                                    <div class="col-sm-2 float-end mt-3">
                                        <div class="d-flex gap-2">
                                        <a href="{{ url('/stok-bahan/bahanMasuk/' . Hashids::encode($bahan->id)) }}"
                                                class="btn btn-outline-secondary btn-sm" title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            
                                        </div>

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
                                            @if ($bahanMasuks->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($bahanMasuks as $bahanMasuk)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $bahanMasuk->date }}</td>
                                                        <td class="text-end">
                                                            {{ rtrim(rtrim(number_format($bahanMasuk->jumlah, 3, ',', '.'), '0'), ',') }}
                                                        </td>
                                                        <td>{{ $bahanMasuk->bahan->satuan->name ?? '-' }}</td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm btn_editstokbahan"
                                                                data-id="{{ $bahanMasuk->id ?? 'NULL' }}"
                                                                data-date="{{ $bahanMasuk->date ?? 'NULL' }}"
                                                                data-jumlah="{{ $bahanMasuk->jumlah ?? 'NULL' }}"
                                                                data-satuan_name="{{ $bahanMasuk->bahan->satuan->name ?? 'NULL' }}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </button>



                                                            <form
                                                                action="{{ route('historyBahan.delete', Hashids::encode($bahanMasuk->id)) }}"
                                                                method="POST" class="d-inline"
                                                                onsubmit="return confirm('Yakin akan Mendelete Data?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button class="btn btn-danger btn-sm" type="submit">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>



                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $bahanMasuks->onEachSide(0.5)->links('pagination::bootstrap-5') }}
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
                    <form method="POST" action="{{ route('historyBahan.store') }}">
                        @csrf

                        <input type="hidden" name="bahan_id" value="{{ Hashids::encode($bahan->id) }}">


                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="jumlah" class="form-label text-dark fw-bold me-2">Jumlah</label>
                            <input type="number" step="0.001"  min="0" max="99999999999.999" required class="form-control" id="jumlah"
                                name="jumlah" value="0" style="max-width: 150px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Satuan</label>
                            <input type="text" class="form-control" value="{{ $bahan->satuan->name }}" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit bahanMasuk-->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Edit Data Bahan
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('historyBahan.update') }}" id="editBarangForm" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="text" name="id" id="txtid">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control  @error('name') is-invalid @enderror" name="date"
                                id="txtdate" required>
                            @error('txtid')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="jumlah" class="form-label text-dark fw-bold me-2">Jumlah</label>
                            <input type="number" step="0.001"  min="0" max="99999999999.999" required
                                class="form-control  @error('name') is-invalid @enderror" id="txtjumlah" name="jumlah"
                                value="0" style="max-width: 150px;">
                            @error('txtid')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Satuan</label>
                            <input id="txtsatuan_name" type="text" class="form-control" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection