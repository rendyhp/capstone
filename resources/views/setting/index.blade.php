@extends('layouts.setting')
@section('Profile', 'active')
@section('container')
@section('title', "Profile | BdiM’s Stock")

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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible">{{ session('error') }}</div>
    @endif

    <div class="container cards">
        <a href="{{ url('/dashboard') }}"><i class="fa fa-angle-double-left me-2 mb-3"></i>Kembali | Ke dashboard</a>
        <h2 class="mt-3 text-uppercase fs-2">Profil</h2>

        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}
                </p>

                <p><strong>Role:</strong> {{ $user->role }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>No. HP (WA):</strong>
                    {{ isset($profile->phone) && $profile->phone !== '62' ? '+' . $profile->phone : '-' }}
                </p>
                <p><strong>Alamat:</strong> {{ $profile->address ?? '-' }}</p>
                <p><strong>Tanggal Lahir:</strong>
                    {{ $profile->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->translatedFormat('j F Y') : '-' }}
                </p>
                <p><strong>Jenis Kelamin:</strong>
                    @if($profile->gender == 'L')
                        Laki-laki
                    @elseif($profile->gender == 'P')
                        Perempuan
                    @else
                        -
                    @endif
                </p>

            </div>
        </div>

        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit
            Profil</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('setting.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Nama</label>
                            <input name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="mb-2">
                            <label>No. HP (WA)</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input name="phone" class="form-control" value="{{ substr($profile->phone, 2) }}"
                                    placeholder="Masukkan nomor WA...">
                            </div>
                            <small class="form-text text-danger">*Dimulai dari 08xxxx atau 8xxxx</small>
                        </div>
                        <div class="mb-2">
                            <label>Alamat</label>
                            <textarea type="text" name="address" class="form-control" rows="4" autocomplete="off"
                                value="{{ $profile->address }}" placeholder="Masukkan alamat..."></textarea>
                        </div>
                        <div class="mb-2">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ $profile->birth_date }}">
                        </div>
                        <div class="mb-2">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control select2">
                                <option value="L" @selected($profile->gender == 'L')>Laki-laki</option>
                                <option value="P" @selected($profile->gender == 'P')>Perempuan</option>
                            </select>
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