<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    {{-- @vite('resources/js/app.js') --}}
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .error-container {
            text-align: center;
            background-color: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .error-icon {
            font-size: 6rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="error-container">
                    <i class="bi bi-exclamation-triangle error-icon"></i>
                    <h1 class="display-4 text-danger mb-3">404</h1>
                    <h2 class="mb-4">Page Not Found</h2>
                    <p class="lead text-muted mb-4">
                        Sorry, the page you are looking for might have been removed,
                        had its name changed, or is temporarily unavailable.
                    </p>
                    <a href="/dashboard" class="btn btn-primary">
                        <i class="bi bi-house-door me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
