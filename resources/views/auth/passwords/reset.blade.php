@extends('layouts.header')
@section('container')
@section('title', 'Reset Password | Bdim’s Stock')

    @push('addStyle')
        <style>
            .form-container {
                border: 2px solid #ccc;
                border-radius: 10px;
                padding: 20px;
                max-width: 450px;
                margin: 50px auto;
            }

            .alert {
                padding: 15px;
                margin-bottom: 20px;
                border: 1px solid transparent;
                border-radius: 10px;
            }

            .alert-success {
                color: #3c763d;
                background-color: #dff0d8;
                border-color: #d6e9c6;
            }

            .alert-danger {
                color: #a94442;
                background-color: #f2dede;
                border-color: #ebccd1;
            }
        </style>
    @endpush

    <section class="vh-100 d-flex justify-content-center align-items-center">
        <div class="form-container">
            <h3 class="mb-4 text-center">Reset Password</h3>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" minlength="8" maxlength="20">
                    <small class="form-text text-muted">*Minimal 8 dan maksimal 20 karakter.</small>
                    <p>
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </p>

                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Konfirmasi Password Baru</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password" minlength="8" maxlength="20">
                    <small class="form-text text-muted">*Harus sama persis dengan password baru.</small>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="border-radius: 20px;">Reset Password</button>
            </form>
        </div>
    </section>
@endsection