<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Endira Alda</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .custom-bg {
            background: linear-gradient(135deg, #5689E6, #5FA3E7, #87CEEB);
        }

        .btn-next {
            background-color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-next:hover {
            transform: translateX(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .list-decor::before {
            content: "✔";
            color: #FFD700;
            margin-right: 10px;
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="custom-bg min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-between">
            <div class="w-full lg:w-1/2 text-white mb-8 lg:mb-0">
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                    Selamat Datang di <span class="text-yellow-300">PT. Endira Alda</span>
                </h1>
                <div class="login-register">
                    <a href="{{ route('oauth.redirect') }}"
                        class="px-10 py-4 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-500 text-white font-semibold inline-block shadow-lg hover:shadow-xl hover:from-yellow-500 hover:to-yellow-600 transition duration-300 ease-in-out transform hover:scale-105">
                        Login
                    </a>
                </div>

            </div>

            <div class="w-full lg:w-1/2 flex justify-center">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-blue-500 via-transparent to-transparent opacity-40 rounded-full">
                    </div>

                    <div class="relative rounded-full overflow-hidden w-100 h-90 mx-auto">
                        <img src="assets/images/img-home.png" alt="Modern Business Illustration"
                            class="max-w-full h-auto object-cover relative z-10">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
