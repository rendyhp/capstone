@extends('layouts.header')
@section('UserData', 'active')
@section('container')
@section('title', 'Register | Bdim’s Stock')

  @push('addStyle')
    <style>
    #moving-image {
    animation-name: moveImage;
    animation-duration: 3s;
    animation-timing-function: ease-in-out;
    animation-iteration-count: infinite;
    transform: translateX(0);
    }

    #togglePassword {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    border-radius: 50%;
    }

    @keyframes moveImage {
    0% {
      transform: translateX(0);
    }

    50% {
      transform: translateX(100px);
    }

    100% {
      transform: translateX(0);
    }
    }

    .divider:after,
    .divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
    }

    .h-custom {
    height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
    .h-custom {
      height: 100%;
    }
    }

    .form-container {
    border: 2px solid #ccc;
    margin-top: 6vh;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-y: auto;
    max-height: 80vh;
    width: 55vh;
    }


    .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 10px;
    width: 400px;
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

  <section class="vh-100">
    <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
      <img id="moving-image" src="{{ asset('img/draw.jpg') }}" class="img-fluid animated" alt="Register Illustration">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
      <form method="POST" action="{{ route('user-data.registerStore') }}" class="form-container">
        @csrf

        <img src="{{ asset('img/login.png') }}" alt="logo" style="height: 100px;">

        <div class="divider d-flex align-items-center my-4">
        <p class="text-center fw-bold mx-3 mb-0 fs-3">REGISTER</p>
        </div>

        @if (session()->has('message'))
      <div class="alert alert-success" role="alert">
      {{ session('message') }}
      </div>
      @endif
        <div class="form-floating">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
          value="{{ old('name') }}" placeholder="Nama" style="border-radius: 20px; width: 400px;" required
          autocomplete="off">
        <label for="name">Nama</label>
        @error('name')
      <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
        </div>
        <div class="form-floating mt-3">
        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
          value="{{ old('username') }}" placeholder="Username" style="border-radius: 20px; width: 400px;" required
          autocomplete="off">
        <label for="username">Username</label>
        @error('username')
      <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
        </div>
        <div class="form-floating mt-3">
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
          value="{{ old('email') }}" placeholder="Email" style="border-radius: 20px; width: 400px;" required
          autocomplete="off">
        <label for="email">Email</label>
        @error('email')
      <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
        </div>
        <div class="form-floating mt-3">
        <select class="form-select @error('role') is-invalid @enderror" name="role"
          style="border-radius: 20px; width: 400px;" required autocomplete="off">
          <option value="" disabled selected>Pilih Role</option>

          @if (Auth::user()->role == 'OWNER')
        <option value="OWNER" {{ old('role') == 'OWNER' ? 'selected' : '' }}>OWNER</option>
        <option value="MANAJER" {{ old('role') == 'MANAJER' ? 'selected' : '' }}>MANAJER</option>
        <option value="STAF" {{ old('role') == 'STAF' ? 'selected' : '' }}>STAF</option>
      @elseif (Auth::user()->role == 'MANAJER')
        <option value="STAF" {{ old('role') == 'STAF' ? 'selected' : '' }}>STAF</option>
      @else

      @endif
        </select>
        <label for="role">Role</label>
        @error('role')
      <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
        </div>

        <div class="form-floating mt-3">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
          name="password" placeholder="Password" style="border-radius: 20px; width: 400px;" required
          autocomplete="off">
        <label for="password">Password</label>
        @error('password')
      <div class="text-danger small mt-1">{{ $message }}</div>
      @enderror
        <!-- <button type="button" id="togglePassword" class="btn btn-outline-secondary"
      style="position: absolute; right: 10px; top: 30px;">
      Show
      </button> -->
        </div>

        <div class="form-floating mt-3">
        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password"
          style="border-radius: 20px; width: 400px;" required autocomplete="off">
        <label for="password-confirm">Konfirmasi Password</label>
        </div>


        <button type="submit" class="btn btn-primary btn-lg mt-4"
        style="padding-left: 2.5rem; padding-right: 2.5rem; width: 400px; border-radius: 20px;">
        {{ __('Register') }}
        </button>

        <p class="small fw-bold mt-3">Kembali <a href="/protected/user-data" class="link-danger">ke halaman user
          data</a></p>

        </p>
      </form>
      </div>
    </div>
    </div>
  </section>

  @push('addScript')
    <script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
    const passwordField = document.getElementById('password');
    const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', passwordFieldType);


    this.textContent = passwordFieldType === 'password' ? 'Show' : 'Hide';
    });
    </script>
  @endpush

@endsection