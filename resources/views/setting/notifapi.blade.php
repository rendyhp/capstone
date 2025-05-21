@extends('layouts.setting')
@section('Notifapi', 'active')
@section('container')
@section('title', "API Notifikasi | BdiM’s Stock")

    <style>
        .cards {
            background-color: #f7fcfb;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .qr-code {
            max-width: 250px;
            margin-top: 15px;
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

        <h2 class="mt-3 text-uppercase fs-2">Hubungkan akun dengan notifikasi API WhatsApp</h2>

        @if ($isConnected)
            <p>Status: <strong class="text-success">Terhubung</strong></p>

            <form action="{{ route('setting.notifikasi-api.disconnect') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Putuskan Hubungan</button>
            </form>

            <p class="mt-3">Notifikasi barang habis akan otomatis dikirim ke WhatsApp Anda.</p>
        @else
            <p>Status: <strong class="text-danger">Belum Terhubung</strong></p>

            <p>Scan QR code berikut menggunakan aplikasi WhatsApp Anda untuk menghubungkan akun dengan layanan notifikasi.</p>

            @if ($qrCode)
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" class="qr-code" />
            @else
                <p>QR code sedang dibuat, silakan tunggu sebentar...</p>
            @endif

            <form action="{{ route('setting.notifikasi-api.generate') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-primary">Generate QR Code</button>
            </form>
        @endif

    </div>

@endsection