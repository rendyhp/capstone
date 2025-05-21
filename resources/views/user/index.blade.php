@extends('layouts.main')
@section('UserData', 'active')
@section('container')
@section('title', "User Data | BdiM’s Stock")

    @php
        $currentUrl = request()->path();
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title ">User Data</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="" href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">User Data</li>
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
                        <div class="card-title fs-5 fw-bold mt-2"> Data User </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableBarang" class="table table-bordered text-dark table-sm">
                                <div class="mb-3">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success"
                                        onclick="window.location.href='/protected/user-data/register'">
                                        <i class="fa fa-plus me-2" aria-hidden="true"></i>Register
                                    </button>

                                    <div class="col-sm-3 float-end mt-3">
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="/protected/user-data" class="btn btn-outline-secondary btn-sm"
                                                title="Refresh">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <form action="/protected/user-data" method="get" class="form-inline d-flex">
                                                <input class="form-control form-control-sm" autocomplete="off" type="text"
                                                    name="search" placeholder="Search" value="{{ request('search') }}">
                                            </form>
                                        </div>

                                        <div>
                                        </div>
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama User</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($userDatas->isEmpty())
                                                <p>Tidak ada data yang ditemukan.</p>
                                            @else
                                                @foreach ($userDatas as $user)
                                                    <tr>
                                                        <td>{{ ($userDatas->currentPage() - 1) * $userDatas->perPage() + $loop->iteration }}
                                                        </td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>
                                                            <span class="masked-email">{{ $maskEmail($user->email) }}</span>
                                                            <span class="full-email d-none"></span>

                                                            @if (
                                                                    ($role === 'OWNER') ||
                                                                    ($role === 'MANAJER' && ($user->role === 'STAF' || $user->id === auth()->user()->id))
                                                                )
                                                                <button class="btn btn-sm btn-light toggle-email"
                                                                    data-user-id="{{ $user->id }}" style="border: none;"
                                                                    title="Lihat email penuh">
                                                                    <i class="fas fa-eye text-secondary"></i>
                                                                </button>
                                                            @endif
                                                        </td>


                                                        <td>{{ $user->role }}</td>


                                                        <td>
                                                            {{-- Tombol Delete --}}
                                                            @if (auth()->user()->role == 'OWNER' && ($user->role == 'MANAJER' || $user->role == 'STAF'))
                                                                <form action="/protected/user/{{ $user->id }}/delete" class="d-inline"
                                                                    method="post">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button class="btn btn-danger btn-sm" type="submit"
                                                                        onclick="return confirm('Yakin akan Mendelete Data?')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif (auth()->user()->role == 'MANAJER' && $user->role == 'STAF')
                                                                <form action="/protected/user/{{ $user->id }}/delete" class="d-inline"
                                                                    method="post">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button class="btn btn-danger btn-sm" type="submit"
                                                                        onclick="return confirm('Yakin akan Mendelete Data?')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            {{-- Tombol Reset Password --}}
                                                            @if (
                                                                    (auth()->user()->role == 'OWNER' && ($user->role == 'MANAJER' || $user->role == 'STAF')) ||
                                                                    (auth()->user()->role == 'MANAJER' && $user->role == 'STAF')
                                                                )
                                                                <form action="/protected/user/{{ $user->id }}/reset-password"
                                                                    class="d-inline" method="post">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button class="btn btn-warning btn-sm" type="submit"
                                                                        onclick="return confirm('Reset password ke default?')">
                                                                        <i class="fa fa-key"></i> Reset
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                            </table>
                            {{ $userDatas->onEachSide(0.5)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('addScript')
        <script>
            document.querySelectorAll('.toggle-email').forEach(button => {
                button.addEventListener('click', function () {
                    const userId = this.getAttribute('data-user-id');
                    const td = this.closest('td');
                    const masked = td.querySelector('.masked-email');
                    const full = td.querySelector('.full-email');
                    const icon = this.querySelector('i'); // Ambil ikon dari tombol

                    if (full.textContent.trim()) {
                        masked.classList.toggle('d-none');
                        full.classList.toggle('d-none');

                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    } else {
                        fetch(`/protected/user/${userId}`)
                            .then(response => response.json())
                            .then(data => {
                                full.textContent = data.email;
                                masked.classList.add('d-none');
                                full.classList.remove('d-none');

                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            })
                            .catch(() => {
                                alert('Gagal memuat email.');
                            });
                    }
                });
            });
        </script>
    @endpush

@endsection