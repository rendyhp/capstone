@extends('layouts.main')
@section('User', 'active')
@section('container')

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
            <h2 class="pageheader-title ">Data User</h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data User</li>
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
                    <div class="card-title fs-5 fw-bold mt-2"> Tabel User </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableBarang" class="table table-bordered text-dark table-sm" style="" border="1">
                            <div class="mb-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#userModal">
                                    <i class="fa fa-plus me-2" aria-hidden="true"></i>Tambah Data
                                </button>
                                <div class="col-sm-2 float-end mt-3">
                                    <form action="/user" method="get" class="form-inline" onsubmit="">
                                        <input class="form-control form-control-sm" type="text" name="search" placeholder="Search" value="{{request('search')}}">
                                    </form>
                                <div>
                            </div>
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Unit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isEmpty())
                                    <p>Tidak ada data yang ditemukan.</p>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->password }}</td>
                                            <td>{{ $user->role}}</td>
                                            <td>{{ $user->unit}}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm btn_edituser" data-no="{{ $user->id }}"
                                                    data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                    data-password="{{ $user->password }}" data-role=" {{ $user->role }} ">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </button>

                                                <form action="user/{{ $user->id }}" class="d-inline" method="post">
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
                        {{ $users->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah Barang-->

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="container modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Tambah User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="Post" action='/user'>
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label text-dark fw-bold">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Input Username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-dark fw-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Input Email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-dark fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Input Password">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label text-dark fw-bold">role</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="admin" value="admin">
                                    <label class="form-check-label" for="admin">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="user" value="user">
                                    <label class="form-check-label" for="user">User</label>
                                </div>
                            </div>
                    </div>
                    <div class="up-section mb-3">
                        <div class="mb-3">
                            <select class="form-select text-dark" id="unit" name="unit">
                            <option disabled selected>Pilih Opsi</option>
                            @foreach($UPs as $up)
                                <option value="{{$up->id}}">{{ $up->up_nama }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Simpan</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Barang-->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Form Edit Data User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/user/edit" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <input hidden type="number" name="no" id="txtno">
                            <label for="username" class="form-label text-dark fw-bold">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="txtusername"
                                name="name">
                            @error('username')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark fw-bold">Email</label>
                            <input type="email" class="form-control" id="txtemail" name="email"
                                placeholder="Input Email">
                            @error('email')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark fw-bold">Password</label>
                            <input type="password" class="form-control" id="txtpassword" name="password"
                                placeholder="Input Password">
                            @error('password')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label text-dark fw-bold">Role</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="admin" value="admin" {{ $user->role === 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="admin">Admin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" id="user" value="user" {{ $user->role === 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user">User</label>
                                </div>
                            </div>
                        </div>
                        <div class="up-section mb-3">
                            <label for="unit" class="form-label text-dark fw-bold">Unit Pengatur</label>
                            <div class="mb-3">
                                <select class="form-select text-dark" id="unit" name="unit">
                                <option disabled selected>
                                    Pilih UP
                                </option>
                                @foreach($UPs as $up)
                                    <option value="{{$up->id}}">{{ $up->up_nama }}</option>
                                @endforeach
                                </select>
                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-white" nama="SaveButton">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
