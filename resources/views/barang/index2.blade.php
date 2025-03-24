@extends('layouts.main')
@section('Barang', 'active')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title ">Data Barang</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Barang</li>
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
                    <div class="card-title fs-5 fw-bold mt-2"> Tabel Barffdfdf </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableBarang" class="table table-bordered text-dark table-sm" style="" border="1">
                            <div class="mb-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#barangModal">
                                    <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                                </button>
                                <div class="col-sm-2 float-end mt-3">
                                    <form action="/barang" method="get" class="form-inline" onsubmit="">
                                        <input class="form-control form-control-sm" type="text" name="search" placeholder="Search" value="{{request('search')}}">
                                    </form>
                                <div>
                            </div>
                            <thead class="table-primary">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama barang</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection


<script>
    $(document).ready(function() {
        $.noConflict();
        var token = '';

        var table = $('#tableBarang').DataTable({
            ajax: {
                url: '{{ route("data-barang") }}',
                type: 'GET'
            },
            serverSide: true,
            processing: true,
            order: [
                [0, 'desc']
            ], // Urutkan berdasarkan kolom pertama (column array '0') secara descending
            columns: [{
                    data: 'id',
                    name: 'id', 
                    orderable: true,
                    searchable: false,
                    // render agar yg tertampil angka 1- dst
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'jumlah',
                    name: 'jumlah',
                    
                },
                {
                    data: 'stok',
                    name: 'stok',
                    
                },
                
                {
                    data: 'id',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                            <td>
                                
                            </td>
                        `;
                    }
                },
            ]
        })
        setInterval(function() {
            table.ajax.reload(null, false); // user paging is not reset on reload
        }, 30000); // refresh tiap 30 detik
    })
</script>