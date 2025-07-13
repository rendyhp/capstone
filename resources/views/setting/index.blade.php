@extends('layouts.setting')
@section('Profile', 'active')
@section('container')
@section('title', "Profil | B.di.M’s Stock")

    <style>
        .cards {
            height: auto;
            background-color: #f7fcfb;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .cards h3 {
            color: #333;
            /* Warna teks */
        }

        .cards p {
            color: #555;
        }
    </style>
    
    @include('layouts.components.alert-flash-messages')

    <div class="container cards">
        <a href="{{ url('/dashboard') }}"><i class="fa fa-angle-double-left me-2 mb-3"></i>Kembali | Ke dashboard</a>
        <h2 class="mt-3 text-uppercase fs-2">Profil</h2>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Nama</div>
                    <div class="col-8">: {{ $user->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Email</div>
                    <div class="col-8">: {{ $user->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Role</div>
                    <div class="col-8">: {{ $user->role }}</div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col-3 fw-bold">No. HP (WA)</div>
                    <div class="col-8">
                        : {{ isset($profile->phone) && $profile->phone !== '62' ? '+' . $profile->phone : '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Tanggal Lahir</div>
                    <div class="col-8">
                        : {{ $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->translatedFormat('j F Y') : '-' }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Jenis Kelamin</div>
                    <div class="col-8">: 
                        @if($profile->gender == 'L')
                            Laki-laki
                        @elseif($profile->gender == 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-3 fw-bold">Alamat</div>
                    <div class="col-8">: {{ $profile->address ?? '-' }}</div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            Edit Profil
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('setting.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5 text-primary fw-bold">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label text-dark fw-bold">Nama</label>
                            <input name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-dark fw-bold">No. HP (WA)</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input name="phone" class="form-control" value="{{ substr($profile->phone, 2) }}"
                                    maxlength="13" placeholder="Masukkan nomor WA...">
                            </div>
                            <small class="form-text text-danger">*Dimulai dari 08xxxx atau 8xxxx</small>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-dark fw-bold">Tanggal Lahir</label>
                            <input type="date" style="width: initial;" name="birth_date" class="form-control" value="{{ $profile->birth_date }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-dark fw-bold">Jenis Kelamin</label>
                            <select name="gender" class="form-select">
                                <option value="" disabled selected style="background-color: #e9ecef; color: #6c757d;">Pilih
                                    Jenis Kelamin</option>
                                <option value="L" @selected($profile->gender == 'L')>Laki-laki</option>
                                <option value="P" @selected($profile->gender == 'P')>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-dark fw-bold">Alamat</label>
                            <textarea type="text" name="address" class="form-control" rows="4" autocomplete="off"
                                value="{{ $profile->address }}" placeholder="Masukkan alamat..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push("addScript")
        <script>
            $(document).ready(function () {
                $('.select2').select2({
                    placeholder: "Pilih Jenis Kelamin",
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
    @endpush

@endsection