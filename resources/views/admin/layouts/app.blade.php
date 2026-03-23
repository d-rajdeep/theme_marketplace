<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.head')

<body>
    <div class="admin-wrapper">
        @include('admin.layouts.sidebar')

        <div class="admin-main">
            @include('admin.layouts.navbar')

            <main class="admin-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/js/admin.js') }}"></script>

    @stack('scripts')
</body>

</html>
