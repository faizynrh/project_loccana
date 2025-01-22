<nav class="navbar navbar-expand-lg" style="background-color: #006DF0; position: sticky; top: 0; z-index: 1050;">
    <div class="container-fluid">
        <span class="navbar-brand" id="toggleSidebar">
            <i class="bi bi-list text-white" style="font-size: 24px; cursor: pointer;"></i>
        </span>
        <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2"
                style="width: 40px; height: 40px;">
            <div class="dropdown me-3">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ Session::get('user_info')['username'] ?? 'Guest' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('oauth.logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
