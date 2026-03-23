<nav class="admin-navbar">
    <div class="navbar-left">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">
            @yield('page-title', 'Dashboard')
        </div>
    </div>

    <div class="navbar-right">
        <div class="admin-dropdown">
            <button class="dropdown-toggle" id="adminDropdown">
                <div class="admin-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <span class="admin-name">
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
                <i class="fas fa-chevron-down"></i>
            </button>

            <div class="dropdown-menu" id="adminDropdownMenu">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
