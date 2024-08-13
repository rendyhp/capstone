@extends('layouts.header')
@section('container')
<style>
    #moving-image {
        /* Menggunakan animasi */
        animation-name: moveImage;
        animation-duration: 3s; /* Durasi animasi (3 detik) */
        animation-timing-function: ease-in-out; /* Gaya animasi */
        animation-iteration-count: infinite; /* Animasi berulang tanpa henti */

        /* Atur awal dan akhir posisi */
        transform: translateX(0); /* Posisi awal */
    }

    /* Definisikan animasi "moveImage" */
    @keyframes moveImage {
        0% {
            transform: translateX(0); /* Posisi awal (tidak bergerak) */
        }
        50% {
            transform: translateX(100px); /* Posisi setengah animasi (bergerak ke kanan) */
        }
        100% {
            transform: translateX(0); /* Posisi akhir (kembali ke awal) */
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
        flex-direction: column;
        align-items: center;
        overflow: auto;
    }
    .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius:10px;
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
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img id="moving-image" src="assets/img/hero-img.png" class="img-fluid animated" alt="">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="POST" action="{{ route('login') }}" class="form-container">
                    @csrf
                    <div>
                      <img src="/img/login.png" alt="logo" style="height: 100px;">
                    </div>
                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0 fs-3">LOGIN</p>
                    </div>
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa fa-exclamation-triangle me-2" aria-hidden="true"></i>
                                    &nbsp{{ session()->get('error') }}
                                </div>
                            </div>
                        </div>
                    @endif 
                    <div class="form-floating">
                        <!-- Email input -->
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="floatingInput"
                        value="{{ old('email') }}" placeholder="name@example.com" style="border-radius: 20px; width: 400px;" required>
                        <label for="floatingInput">{{ __('Email Address') }}</label>
                    </div>
                
                    <!-- Password input -->
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        value="{{ old('password') }}"   id="floatingPassword" placeholder="Password" style="border-radius: 20px; width: 400px;" required>
                        <label for="floatingPassword">{{ __('Password') }}</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3" style="width: 400px;">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" value="" id="form2Example3" required />
                            <label class="form-check-label" for="form2Example3">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem; width: 400px; border-radius: 20px;">
                            {{ __('Login') }}
                        </button>
                        <div class="mt-4">
                          <a href="#!" class="text-body fs-7 fw-bold">Forgot password ?</a>
                        </div>
                        <p class="small fw-bold mt-2 pt-1 mb-4">Don't have an account ? <a
                                href="{{ route('register') }}" class="link-danger">{{ __('Register') }}</a></p>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
