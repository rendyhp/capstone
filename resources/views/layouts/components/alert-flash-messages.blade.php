<style>
    .custom-alert {
        position: fixed;
        top: 60px;
        right: 5%;
        max-width: 50%;
        z-index: 100;
        animation: slideIn 0.5s ease, fadeOut 0.5s ease 9.5s forwards;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(90px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateY(-60px);
        }
    }

    .progress-timer {
        height: 2px;
        background-color: #007bff;
        animation: shrink 9.5s linear forwards;
    }

    @keyframes shrink {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }
</style>

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible custom-alert" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-check me-2" aria-hidden="true"></i>
                {!! session('success') !!}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="progress-timer"></div>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible custom-alert" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-exclamation-triangle me-2" aria-hidden="true"></i>
                {!! session('error') !!}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="progress-timer"></div>
    </div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible custom-alert" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-exclamation-triangle me-2" aria-hidden="true"></i>
                {!! session('warning') !!}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="progress-timer"></div>
    </div>
@endif