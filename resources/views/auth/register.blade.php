@extends('layouts.header')
@section('container')
<link>
<style>
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
        .rounded-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Additional styles to center the icon */
            position: relative;
            overflow: hidden;
        }
        .form-container {
        border: 2px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column; Menengahkan form di dalam border */
    }
</style>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="img/draw.jpg"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
      <form method="POST" action="{{ route('register') }} " class="form-container">
        @csrf
          @if (session()->has('message'))
            <div class="alert alert-success" role="alert">
              {{ session('message') }}
            </div>
          @endif
          <div class="d-flex flex-column align-items-center">
              <img src="/img/login.png" alt="logo" style="height: 100px;">
          </div>
          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0 fs-3">REGISTER</p>
          </div>
          <!-- Input nama -->
          <div class="form-floating">
            <input type="nama" class="form-control @error('name') is-invalid @enderror" name="name"
              value="{{ old('name') }}" style="border-radius: 20px;" placeholder="Nama"
              autofocus required>
            <label for="floatingInput">Nama</label>
            @error('name')
              {{ $message }}
            @enderror
          </div>
          <!-- Email input -->
          <div class="form-floating mt-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" style="border-radius: 20px;" placeholder="Password" required>
            <label for="floatingPassword">Email</label>
                @error('email')
                    {{ $message }}
                @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-floating mt-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                id="password" value="{{ old('password') }}" style="border-radius: 20px;"
                placeholder="Password" required autocomplete="new-password">
                <label for="password">{{ __('Password') }}</label>
                    @error('password')
                        {{ $message }}
                    @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating mt-3">
                <input type="password" class="form-control" name="password_confirmation"
                id="password-confirm" style="border-radius: 20px;"
                placeholder="ConfirmPass" required autocomplete="new-password">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
              </div>
            </div>
          </div>
          <div class="up-section mt-3">
            <select class="form-select text-dark" id="unit" name="unit" style="border-radius: 20px; height:60px;">
              <option disabled selected>Unit</option>
              @foreach($UPs as $up)
                <option value="{{$up->id}}">{{ $up->up_nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="row mt-3">
            <div class="">
                <button type="submit" style="border-radius: 20px;" class="w-100 btn btn-primary btn-lg">
                    {{ __('Register') }}
                </button>
                <div class="row mt-3">
                  <div class="d-flex flex-column align-items-center">
                      <label for="" class="mt-2 mb-3">Sudah punya akun? <a href="/login" style="font-weight: bold;">Login</a></label>
                  </div>
                </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
  </div>
@endsection