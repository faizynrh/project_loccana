<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        #error {
            background-color: #ebf3ff;
            padding: 2rem 0;
            min-height: 100vh
        }

        #error .img-error {
            height: 435px;
            object-fit: contain;
            padding: 3rem 0
        }

        #error .error-title {
            font-size: 3rem;
            margin-top: 1rem
        }

        html[data-bs-theme=dark] #error {
            background-color: #151521
        }
    </style>
</head>

<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/img/errors/error-404.svg') }}" alt="Not Found">
                    <h1 class="error-title">NOT FOUND</h1>
                    <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
                    <a href="/dashboard" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
