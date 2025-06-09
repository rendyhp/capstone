@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-check me-2" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-exclamation-triangle me-2" aria-hidden="true"></i>
                &nbsp{{ session()->get('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-exclamation-triangle me-2" aria-hidden="true"></i>
                &nbsp{{ session()->get('warning') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif