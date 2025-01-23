<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!!</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>

<body>
    <div class="custom-bg d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <!-- Text Content -->
                <div class="col-lg-6 mb-5 mb-lg-0 text-white">
                    <h1 class="display-4 fw-bold mb-4">
                        Selamat Datang di <span class="text-warning">PT. Endira Alda</span>
                    </h1>
                    <div class="mt-4">
                        <a href="{{ route('oauth.redirect') }}"
                            class="btn btn-login text-white py-3 px-5 rounded-pill fw-semibold">
                            Login
                        </a>
                        {{-- <a href="/dashboard" class="btn btn-login text-white py-3 px-5 rounded-pill fw-semibold">
                            Login
                        </a> --}}
                    </div>
                </div>

                <!-- Image Content -->
                <div class="col-lg-6">
                    <div class="img-container">
                        <div class="img-overlay"></div>
                        <img src="assets/img/home/img-home.png" alt="Modern Business Illustration"
                            class="img-fluid rounded-circle floating">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
