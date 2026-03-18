<nav class="navbar">
    <div class="container">
        <div class="navbar-content">
            <div class="navbar-brand">
                <a href="{{ url('/') }}">
                    {{-- <img src="{{ asset('images/logo.svg') }}" alt="Themeur Logo" class="logo"> --}}
                    <span class="brand-text">Themeur</span>
                </a>
            </div>

            <div class="navbar-search">
                <form action="#" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Search themes, plugins, templates..."
                        value="{{ request('q') }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="navbar-menu">
                <ul class="nav-links">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ url('/') }}"></i> Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                             Themes <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">WordPress Themes</a></li>
                            <li><a href="#">HTML Templates</a></li>
                            <li><a href="#">E-commerce Themes</a></li>
                            <li><a href="#">Blog Themes</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                             Plugins <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">WooCommerce Plugins</a></li>
                            <li><a href="#">SEO Plugins</a></li>
                            <li><a href="#">Security Plugins</a></li>
                            <li><a href="#">Performance Plugins</a></li>
                        </ul>
                    </li>
                    <li><a href="#"></i> Pricing</a></li>
                    <li><a href="#"></i> About</a></li>
                    <li><a href="#"></i> Contact</a></li>
                </ul>

                <div class="nav-actions">
                    <a href="#" class="cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                    <button class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <span class="mobile-menu-title">Menu</span>
            <button class="mobile-menu-close"><i class="fas fa-times"></i></button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-paint-brush"></i> WordPress Themes</a></li>
            <li><a href="#"><i class="fas fa-code"></i> HTML Templates</a></li>
            <li><a href="#"><i class="fas fa-plug"></i> Plugins</a></li>
            <li><a href="#"><i class="fas fa-tags"></i> Pricing</a></li>
            <li><a href="#"><i class="fas fa-info-circle"></i> About</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Contact</a></li>
        </ul>
    </div>
</nav>
