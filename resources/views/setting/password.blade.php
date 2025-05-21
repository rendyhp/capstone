@extends('layouts.setting')
@section('Password', 'active')
@section('container')
@section('title', "Ubah Password | BdiM’s Stock")

    <style>
        .cards {
            background-color: #f7fcfb;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible">{{ session('error') }}</div>
    @endif

    <div class="container cards">
        <a href="{{ url('/dashboard') }}"><i class="fa fa-angle-double-left me-2 mb-3"></i>Kembali | Ke dashboard</a>

        <h2 class="mt-3 text-uppercase fs-2">Perbarui Password</h2>

        <form action="{{ route('setting.password.update') }}" method="POST">
            @csrf
            <div class="mb-3 mt-4">
                <label for="current_password" class="form-label">Password Lama</label>
                <input type="password" class="form-control" name="current_password" required>
                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" name="new_password" minlength="8" maxlength="20" required>
                <small class="form-text text-muted">*Minimal 8 dan maksimal 20 karakter.</small>
                <p>
                    @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                </p>

            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="new_password_confirmation" minlength="8" maxlength="20"
                    required>
                <small class="form-text text-muted">*Harus sama persis dengan password baru.</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Password Baru</button>
        </form>
    </div>

@endsection