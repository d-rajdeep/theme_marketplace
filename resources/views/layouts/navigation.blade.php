<nav class="navbar">
    <div class="container">
        <div class="navbar-content">
            <div class="navbar-brand">
                <a href="{{ route('home') }}">
                    <span class="brand-text">Themeur</span>
                </a>
            </div>

            <div class="navbar-search">
                <form action="{{ route('products.all') }}" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Search themes, plugins, templates..."
                        value="{{ request('q') }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="navbar-menu">
                <ul class="nav-links">
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('products.all', ['type' => 'theme']) }}" class="dropdown-toggle">
                            Themes <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('products.all', ['type' => 'theme']) }}">All WordPress Themes</a></li>
                            <li><a href="{{ route('products.all', ['type' => 'template']) }}">HTML Templates</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('products.all', ['type' => 'plugin']) }}" class="dropdown-toggle">
                            Plugins <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('products.all', ['type' => 'plugin']) }}">All Plugins</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('products.all') }}">All Products</a></li>
                </ul>

                <div class="nav-actions">
                    <a href="{{ route('cart.index') }}" class="cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="nav-cart-count">
                            {{ session()->has('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                    <button class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <span class="mobile-menu-title">Menu</span>
            <button class="mobile-menu-close"><i class="fas fa-times"></i></button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ route('products.all', ['type' => 'theme']) }}"><i class="fas fa-paint-brush"></i> WordPress
                    Themes</a></li>
            <li><a href="{{ route('products.all', ['type' => 'template']) }}"><i class="fas fa-code"></i> HTML
                    Templates</a></li>
            <li><a href="{{ route('products.all', ['type' => 'plugin']) }}"><i class="fas fa-plug"></i> Plugins</a>
            </li>
            <li><a href="{{ route('products.all') }}"><i class="fas fa-box"></i> All Products</a></li>
        </ul>
    </div>
</nav>
