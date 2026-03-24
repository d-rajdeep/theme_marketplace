@extends('layouts.app')

@section('title', 'My Account - Themeour')

@section('content')
    <div class="account-wrapper">
        <div class="container account-container">

            <button class="mobile-sidebar-toggle" onclick="toggleAccountMenu()">
                <i class="fas fa-bars"></i> <span>My Account Menu</span>
            </button>

            <aside class="account-sidebar" id="accountSidebar">
                <div class="user-profile-summary">
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div class="user-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <nav class="account-nav">
                    <a href="#" class="nav-tab-link active" data-target="dashboard-overview"><i
                            class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="#" class="nav-tab-link" data-target="dashboard-orders"><i class="fas fa-box"></i> My
                        Orders</a>
                    <a href="#" class="nav-tab-link" data-target="dashboard-downloads"><i
                            class="fas fa-cloud-download-alt"></i> My Downloads</a>
                    <a href="#" class="nav-tab-link" data-target="dashboard-profile"><i class="fas fa-user-edit"></i>
                        Profile Settings</a>

                    <div class="nav-divider"></div>

                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </nav>
            </aside>

            <main class="account-content">

                <div id="dashboard-overview" class="dashboard-section active">
                    <div class="welcome-banner">
                        <h2>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                        <p>From your account dashboard, you can view your recent orders, manage your downloads, and edit
                            your account details.</p>
                    </div>

                    <div class="account-stats">
                        <div class="stat-box" onclick="switchTab('dashboard-orders')" style="cursor: pointer;">
                            <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;"><i class="fas fa-box"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $totalOrders }}</h3>
                                <p>Total Orders</p>
                            </div>
                        </div>

                        <div class="stat-box" onclick="switchTab('dashboard-downloads')" style="cursor: pointer;">
                            <div class="stat-icon" style="background: #f0fdf4; color: #22c55e;"><i
                                    class="fas fa-cloud-download-alt"></i></div>
                            <div class="stat-info">
                                <h3>{{ $totalDownloads }}</h3>
                                <p>Available Downloads</p>
                            </div>
                        </div>

                        <div class="stat-box">
                            <div class="stat-icon" style="background: #fef2f2; color: #ef4444;"><i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-info">
                                <h3>0</h3>
                                <p>Wishlist Items</p>
                            </div>
                        </div>
                    </div>

                    <div class="recent-activity">
                        <div class="section-header">
                            <h3>Recent Orders</h3>
                            <a href="#" class="view-all-link" onclick="switchTab('dashboard-orders')">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders->take(3) as $order)
                                        <tr>
                                            <td class="order-id">{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if ($order->payment_status === 'completed')
                                                    <span class="status-badge completed">Completed</span>
                                                @else
                                                    <span
                                                        class="status-badge processing">{{ ucfirst($order->payment_status) }}</span>
                                                @endif
                                            </td>
                                            <td class="font-semibold">₹{{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center;">No recent orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="dashboard-orders" class="dashboard-section">
                    <div class="recent-activity">
                        <div class="section-header">
                            <h3>Order History</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="order-id">{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>{{ $order->items->count() }} item(s)</td>
                                            <td>
                                                @if ($order->payment_status === 'completed')
                                                    <span class="status-badge completed">Completed</span>
                                                @else
                                                    <span
                                                        class="status-badge processing">{{ ucfirst($order->payment_status) }}</span>
                                                @endif
                                            </td>
                                            <td class="font-semibold">₹{{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" style="text-align: center; padding: 30px;">You haven't placed
                                                any orders yet. <br><a href="{{ route('products.all') }}"
                                                    style="color: #6366f1;">Start Shopping</a></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="dashboard-downloads" class="dashboard-section">
                    <div class="recent-activity">
                        <div class="section-header">
                            <h3>Your Available Downloads</h3>
                        </div>
                        <div style="padding: 20px;">
                            @forelse($downloadableItems as $item)
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #f1f5f9;">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="{{ $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : 'https://via.placeholder.com/60' }}"
                                            style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                        <div>
                                            <h4 style="margin: 0; font-size: 16px; color: #1e293b; font-weight: 600;">
                                                {{ $item->product->name }}</h4>
                                            <span style="font-size: 13px; color: #64748b;">Order:
                                                {{ $item->order->order_number }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('product.download', $item->id) }}"
                                        style="background: #10b981; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: background 0.3s;"
                                        onmouseover="this.style.background='#059669'"
                                        onmouseout="this.style.background='#10b981'">
                                        <i class="fas fa-download"></i> Download Zip
                                    </a>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 40px;">
                                    <i class="fas fa-cloud-download-alt"
                                        style="font-size: 40px; color: #cbd5e1; margin-bottom: 15px;"></i>
                                    <p style="color: #64748b;">You don't have any downloadable products yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div id="dashboard-profile" class="dashboard-section">
                    <div class="welcome-banner">
                        <h3 style="margin-top:0;">Profile Details</h3>
                        <div style="margin-top: 20px;">
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">
                        <p style="color: #64748b; font-size: 14px;"><em>Note: Profile editing functionality will be added
                                here shortly.</em></p>
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* NEW: Hide all sections by default, show the active one */
        .dashboard-section {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .dashboard-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Preserve existing CSS styles */
        .account-wrapper {
            background-color: #f8fafc;
            min-height: calc(100vh - 80px);
            padding: 40px 0;
            font-family: 'Inter', sans-serif;
        }

        .account-container {
            display: flex;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            align-items: flex-start;
        }

        .mobile-sidebar-toggle {
            display: none;
            width: 100%;
            padding: 15px 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            cursor: pointer;
            margin-bottom: 20px;
            text-align: left;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .mobile-sidebar-toggle i {
            margin-right: 10px;
            color: #6366f1;
        }

        .account-sidebar {
            flex: 0 0 280px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            position: sticky;
            top: 100px;
            transition: all 0.3s ease;
        }

        .user-profile-summary {
            padding: 30px 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
        }

        .user-details h4 {
            margin: 0 0 4px 0;
            font-size: 16px;
            color: #1e293b;
            font-weight: 700;
        }

        .user-details p {
            margin: 0;
            font-size: 13px;
            color: #64748b;
        }

        .account-nav {
            padding: 15px 0;
        }

        .account-nav a {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            color: #475569;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .account-nav a i {
            width: 24px;
            font-size: 18px;
            color: #94a3b8;
            margin-right: 12px;
            transition: color 0.2s ease;
        }

        .account-nav a:hover {
            background: #f8fafc;
            color: #6366f1;
            padding-left: 30px;
        }

        .account-nav a:hover i {
            color: #6366f1;
        }

        .account-nav a.active {
            background: #eff6ff;
            color: #6366f1;
            border-right: 3px solid #6366f1;
        }

        .account-nav a.active i {
            color: #6366f1;
        }

        .nav-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 10px 25px;
        }

        .logout-form {
            margin: 0;
            padding: 5px 25px 15px;
        }

        .logout-btn {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: #ef4444;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            padding: 10px 0;
            display: flex;
            align-items: center;
            transition: opacity 0.2s;
        }

        .logout-btn i {
            width: 24px;
            font-size: 18px;
            margin-right: 12px;
        }

        .logout-btn:hover {
            opacity: 0.8;
        }

        .account-content {
            flex: 1;
            min-width: 0;
        }

        .welcome-banner {
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            margin-bottom: 30px;
        }

        .welcome-banner h2 {
            margin: 0 0 10px 0;
            font-size: 24px;
            color: #1e293b;
            font-weight: 800;
        }

        .welcome-banner p {
            margin: 0;
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
        }

        .account-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-info h3 {
            margin: 0 0 4px 0;
            font-size: 24px;
            font-weight: 800;
            color: #1e293b;
        }

        .stat-info p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .recent-activity {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .section-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fdfdfd;
        }

        .section-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }

        .view-all-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        .view-all-link:hover {
            text-decoration: underline;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .activity-table th {
            background: #f8fafc;
            padding: 15px 25px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-table td {
            padding: 18px 25px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 15px;
        }

        .activity-table tr:last-child td {
            border-bottom: none;
        }

        .activity-table tr:hover td {
            background-color: #f8fafc;
        }

        .order-id {
            font-weight: 700;
            color: #1e293b !important;
        }

        .font-semibold {
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.processing {
            background: #fef9c3;
            color: #854d0e;
        }

        @media (max-width: 992px) {
            .account-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .account-container {
                flex-direction: column;
            }

            .mobile-sidebar-toggle {
                display: block;
            }

            .account-sidebar {
                width: 100%;
                flex: none;
                display: none;
                position: static;
                margin-bottom: 20px;
            }

            .account-sidebar.active {
                display: block;
                animation: slideDown 0.3s ease-out;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .account-stats {
                grid-template-columns: 1fr;
            }

            .welcome-banner {
                padding: 20px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Toggle mobile menu visibility
        function toggleAccountMenu() {
            const sidebar = document.getElementById('accountSidebar');
            sidebar.classList.toggle('active');
        }

        // SPA Tab Switching Logic
        function switchTab(targetId) {
            // 1. Remove active class from all links
            document.querySelectorAll('.nav-tab-link').forEach(link => {
                link.classList.remove('active');
                // If the link matches the target, add active back
                if (link.getAttribute('data-target') === targetId) {
                    link.classList.add('active');
                }
            });

            // 2. Hide all sections
            document.querySelectorAll('.dashboard-section').forEach(section => {
                section.classList.remove('active');
            });

            // 3. Show the targeted section
            document.getElementById(targetId).classList.add('active');

            // 4. Close mobile menu if open
            if (window.innerWidth <= 768) {
                document.getElementById('accountSidebar').classList.remove('active');
            }
        }

        // Attach event listeners to sidebar links
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.nav-tab-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    switchTab(this.getAttribute('data-target'));
                });
            });
        });
    </script>
@endpush
