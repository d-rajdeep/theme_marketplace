<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-top-content">
                <div class="header-contact">
                    <span><i class="fas fa-phone-alt"></i> +1 234 567 890</span>
                    <span><i class="fas fa-envelope"></i> support@themeur.com</span>
                </div>
                <div class="header-user">
                    @auth
                        <div class="user-dropdown">
                            <button class="user-btn">
                                <i class="fas fa-user"></i>
                                {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                <a href="{{ route('profile') }}"><i class="fas fa-user-edit"></i> Profile</a>
                                <a href="{{ route('downloads') }}"><i class="fas fa-download"></i> My Downloads</a>
                                <a href="{{ route('orders') }}"><i class="fas fa-shopping-bag"></i> Orders</a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="auth-links">
                            <a href="{{ route('login') }}" class="login-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                            <a href="{{ route('register') }}" class="register-link"><i class="fas fa-user-plus"></i>
                                Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
