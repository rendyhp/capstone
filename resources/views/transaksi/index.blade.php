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
                <button type="button" class="btn btn-success mb-3"
                    onclick="window.location.href='{{ url('/transaksi/create') }}'">
                    Tambah Transaksi
                </button>

                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    Impor CSV
                </button>

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
                        @forelse($transaksis as $key => $transaksi)
                            @php $isMatched = $transaksi->menu_id !== null; @endphp
                            <tr class="{{ $isMatched ? '' : 'table-danger' }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ optional($transaksi->menu)->name ?? $transaksi->menu_name }}</td>
                                <td>{!! $isMatched ? '<span class="text-success">✅</span>' : '<span class="text-danger">❌</span>' !!}
                                </td>
                                <td>{{ $transaksi->jumlah }}</td>
                                <td>
                                    @if($isMatched && optional($transaksi->menu)->komposisi)
                                        <ul>
                                            @foreach($transaksi->menu->komposisi as $komposisi)
                                                @if(optional($komposisi->bahan)->name)
                                                    <li>{{ $komposisi->bahan->name }} - {{ $komposisi->jumlah * $transaksi->jumlah }}
                                                        {{ optional($komposisi->bahan->satuan)->name }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Tidak ada data</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $transaksi->id }}">Edit</button>
                                    <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Modal Upload CSV -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Impor Data Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="fileForm" action="{{ route('transaksi.import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="fileInput" name="file" class="form-control mb-3"
                                accept=".csv,.xls,.xlsx">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                        <div id="uploadMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('fileForm').addEventListener('submit', function (event) {
                event.preventDefault();

                let formData = new FormData(this);
                let uploadMessage = document.getElementById('uploadMessage');

                uploadMessage.innerHTML = "<span class='text-info'>Uploading...</span>";

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            uploadMessage.innerHTML = "<span class='text-success'>Data berhasil diimpor!</span>";
                            setTimeout(() => location.reload(), 1500); // Refresh halaman setelah upload
                        } else {
                            uploadMessage.innerHTML = "<span class='text-danger'>" + data.error + "</span>";
                        }
                    })
                    .catch(error => {
                        uploadMessage.innerHTML = "<span class='text-danger'>Terjadi kesalahan saat mengupload!</span>";
                    });
            });

        </script>


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