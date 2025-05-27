@extends('layouts.setting')
@section('SetApiToken', 'active')
@section('container')
@section('title', "API Notifikasi | BdiM’s Stock")

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
        <div class="alert alert-danger text-sm alert-dismissible">
            {!! session('error') !!}
        </div>
    @endif


    <div class="container cards">
        <a href="{{ url('/dashboard') }}">
            <i class="fa fa-angle-double-left me-2 mb-3"></i>Kembali | Ke dashboard
        </a>

        <h2 class="mt-3 text-uppercase fs-2">Atur Token API Fonnte WhatsApp</h2>

        <p>Status: <strong class="text-success"></strong></p>
        <p><strong>Nama pengirim:</strong><br>{{ $setApiToken->name ?? '-' }}</p>
        <p><strong>No. WA Pengirim:</strong><br> +{{ $setApiToken->phone ?? '-' }}</p>
        <p><strong>Token terhubung:</strong><br>{{ $setApiToken->token_name ?? '-' }}</p>

        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editTokenAPIModal">Edit
            Token</button>

    </div>

    <div class="modal fade" id="editTokenAPIModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('setting.set-api-token.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Token</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Nama perangkat tersambung</label>
                            <input name="name" class="form-control" value="{{ $setApiToken->name ?? '-' }}">
                        </div>
                        <div class="mb-2">
                            <label>No. HP (WA) tersambung</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input name="phone" class="form-control" value="{{ substr($setApiToken->phone, 2)}}"
                                    maxlength="13" placeholder="Masukkan nomor WA...">
                            </div>
                            <small class="form-text text-danger">*Dimulai dari 08xxxx atau 8xxxx</small>
                        </div>
                        <div class="mb-2">
                            <label>Token API (Fonnte)</label>
                            <input type="text" name="token_name" class="form-control"
                                value="{{ $setApiToken->token_name ?? '' }}" placeholder="Masukkan token API...">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection