<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <div class="d-flex align-items-center rounded p-2 ms-3" id="clock">
                <span class="text-gray-600 fw-bold fs-6"></span>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav ms-auto mb-lg-0 dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3 mt-2">
                                <h6 class="mb-0 text-gray-600">
                                    {{ Session::get('user_info')['username'] ?? 'Guest' }}
                                </h6>
                                <p class="mb-0 text-sm text-gray-600">Administrator</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                @php
                                    $username = Session::get('user_info')['username'] ?? 'User';
                                    $initial = strtoupper(substr($username, 0, 1));
                                    $colors = ['#FF5733', '#33A1FF', '#FF33A8', '#33FF57', '#A833FF', '#FFC733'];
                                    $bgColor = $colors[ord($initial) % count($colors)];
                                @endphp

                                <div class="avatar avatar-md"
                                    style="background-color: {{ $bgColor }}; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 20px; font-weight: bold; color: white;">
                                    {{ $initial }}
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ Session::get('user_info')['username'] }}
                            </h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/profile"><i class="icon-mid bi bi-person me-2"></i> My
                                Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                Settings</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('oauth.logout') }}"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<script>
    function updateClock() {
        const now = new Date();
        now.setHours(now.getHours());
        let hours = now.getHours().toString().padStart(2, '0');
        let minutes = now.getMinutes().toString().padStart(2, '0');
        let seconds = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('clock').innerText = `${hours}:${minutes}:${seconds} WIB`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
