<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-crown"></i>
            <span>Themeur Admin</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-menu">
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}" class="nav-link">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}" class="nav-link">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ url('/') }}" class="back-to-site">
            <i class="fas fa-globe"></i>
            <span>Back to Site</span>
        </a>
    </div>
</aside>
