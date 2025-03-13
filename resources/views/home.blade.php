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
    <div id="loading">
        @include('loading.loadingpage')
    </div>
    <div id="content" style="display: none;">
        <div class="custom-bg d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0 text-white">
                        <h1 class="display-4 fw-bold mb-4">
                            Selamat Datang di <span class="text-warning">PT. Endira Alda</span>
                        </h1>
                        <div class="mt-4">
                            <a href="{{ route('oauth.redirect') }}"
                                class="btn btn-login text-white py-3 px-5 rounded-pill fw-semibold">
                                Login
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="img-container">
                            <div class="img-overlay"></div>
                            <img src="{{ asset('assets/img/home/5278822.jpg') }}" alt="Modern Business Illustration"
                                class="img-fluid rounded-circle floating">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#loading").fadeOut(2000, function() {
                $("#content").fadeIn(1000);
            });
        });
    </script>
</body>
