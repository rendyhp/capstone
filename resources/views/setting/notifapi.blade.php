@extends('layouts.setting')
@section('Notifapi', 'active')
@section('container')
@section('title', "API Notifikasi | B.di.M’s Stock")

    <style>
        .cards {
            background-color: #f7fcfb;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
    </style>

    @include('layouts.components.alert-flash-messages')
    
    <div class="container cards">
        <a href="{{ url('/dashboard') }}">
            <i class="fa fa-angle-double-left me-2 mb-3"></i>Kembali | Ke dashboard
        </a>

        <h2 class="mt-3 text-uppercase fs-2">Notifikasi WhatsApp</h2>

        @if ($user->wa_api_token)
            <p>Status: <strong class="text-success">Terhubung</strong></p>
            <p><strong>No. WA terhubung:</strong><br> +{{ $user->profile->phone ?? '-' }}</p>

            <form action="{{ route('setting.notifikasi-api.disconnect') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger mt-2">Putuskan Hubungan</button>
            </form>

            <p class="mt-3">Notifikasi barang/bahan menipis akan otomatis dikirim ke WhatsApp Anda.</p>
        @else
            <p>Status: <strong class="text-danger">Belum terhubung dengan notifikasi WhatsApp</strong></p>
            <p>Silakan hubungkan akun dengan klik tombol dibawah ini.</p>

            <form action="{{ route('setting.notifikasi-api.connect') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success mt-2">Hubungkan Kembali</button>
            </form>
        @endif
    </div>

@endsection