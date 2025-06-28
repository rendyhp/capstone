@extends('layouts.header')
@section('container')
@section('title', 'Lupa Password | B.di.M’s Stock')

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
            <h3 class="mb-4 text-center">Lupa Password</h3>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100" style="border-radius: 20px;">Kirim Link Reset
                    Password</button>
                <p class="small fw-bold mt-3">Kembali <a href="/login" class="link-danger">ke halaman Login</a></p>
            </form>
        </div>
    </section>
@endsection