@extends('layouts.main')
@section('Transaksi', 'active')
@section('container')

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Transaksi</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @if(session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('transaksi.index') }}" method="GET" class="mb-3 d-flex align-items-center">
            <label for="tanggalbahan" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" id="tanggalbahan" name="date" value="{{ $date }}">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <div class="card custom-card">
            <div class="card-header">
                <h5 class="card-title">Tabel Transaksi</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#barangModal">
                    <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah menu
                </button>

                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    Impor CSV
                </button>

                <form action="{{ route('transaksi.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="date">Tanggal</label>
                    <input type="date" name="date" required>

                    <label for="file">File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required>

                    <button type="submit">Upload</button>
                </form>

                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Menu</th>
                            <th>Check</th>
                            <th>Jumlah</th>
                            <th>Bahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paginated as $key => $transaksi)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $transaksi['menu_name'] }}</td>
                                <td><span class="text-success">✅</span></td>
                                <td>{{ $transaksi['total_jumlah'] }}</td>
                                <td>
                                    <ul>
                                        @foreach($transaksi['bahans'] as $bahan)
                                            <li>{{ $bahan['bahan_name'] }} -
                                                {{ rtrim(rtrim(number_format($bahan['total_bahan'], 3, ',', '.'), '0'), ',') }}
                                                {{ $bahan['satuan_name'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit-btn"
                                        data-id="{{ $transaksi['menu_id'] }}">Edit</button>
                                    <!-- Hapus butuh id transaksi spesifik, jadi disesuaikan jika ada -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>



                {{ $paginated->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Modal Upload Excel -->
        <div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('transaksi.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadExcelModalLabel">Upload File Excel / CSV</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <input type="file" class="form-control" name="file" accept=".csv,.xlsx" required>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="container modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Transaksi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action='/transaksi'>
                            @csrf
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="menu_id" class="form-label text-dark fw-bold">Nama Menu</label>
                                <select class="form-control" required id="menu_id" name="menu_id">
                                    <option value="">-- Pilih Menu --</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->id }}" data-komposisi='@json($menu->komposisi)'>
                                            {{ $menu->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <label for="jumlah" class="form-label text-dark fw-bold me-2">Jumlah</label>
                                <input type="number" step="1" min="1" required class="form-control number0" id="jumlah"
                                    name="jumlah" value="1" style="max-width: 150px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Komposisi</label>
                                <div class="mb-3">
                                    <ul id="komposisiPreview" class="list-group small"></ul>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary text-white" name="SaveButton">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            @csrf @method('PUT')
                            <input type="hidden" id="transaksiId">
                            <div class="form-group">
                                <label for="editJumlah">Jumlah</label>
                                <input type="number" id="editJumlah" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <script>
            document.getElementById('uploadForm').addEventListener('submit', function (e) {
                e.preventDefault();

                let fileInput = document.getElementById('fileInput');
                if (!fileInput.files.length) {
                    document.getElementById('uploadMessage').innerHTML = '<div class="text-danger">Pilih file terlebih dahulu!</div>';
                    return;
                }

                let formData = new FormData();
                formData.append('file', fileInput.files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ url("/transaksi/import") }}', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('uploadMessage').innerHTML = '<div class="text-success">' + data.success + '</div>';
                            setTimeout(() => location.reload(), 1500); // Reload setelah sukses
                        } else {
                            document.getElementById('uploadMessage').innerHTML = '<div class="text-danger">' + data.error + '</div>';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".edit-btn").forEach(button => {
                    button.addEventListener("click", function () {
                        let transaksiId = this.dataset.id;
                        fetch(`/transaksi/${transaksiId}/edit`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById("transaksiId").value = data.id;
                                document.getElementById("editJumlah").value = data.jumlah;
                                $('#editModal').modal('show');
                            });
                    });
                });

                document.getElementById("editForm").addEventListener("submit", function (event) {
                    event.preventDefault();
                    let transaksiId = document.getElementById("transaksiId").value;
                    let jumlah = document.getElementById("editJumlah").value;
                    fetch(`/transaksi/${transaksiId}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({ jumlah: jumlah })
                    }).then(response => response.json())
                        .then(() => location.reload());
                });
            });
        </script>
@endsection