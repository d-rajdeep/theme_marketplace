@extends('admin.layouts.app')

@section('title', 'Admin Dashboard - Themeour')
@section('page-title', 'Dashboard')
@section('content')

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h2>Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</h2>
                <p>Here's what's happening with your marketplace today.</p>
            </div>
            <div class="date-badge">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ date('l, F j, Y') }}</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-value">{{ number_format($stats['total_users']) }}</h3>
                    <p class="stat-label">Total Users</p>
                    <span class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> +12%
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon products">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-value">{{ number_format($stats['total_products']) }}</h3>
                    <p class="stat-label">Total Products</p>
                    <span class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> +8%
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-value">{{ number_format($stats['total_orders']) }}</h3>
                    <p class="stat-label">Total Orders</p>
                    <span class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> +15%
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-value">₹{{ number_format($stats['total_revenue'], 2) }}</h3>
                    <p class="stat-label">Total Revenue</p>
                    <span class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> +23%
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon categories">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-value">{{ number_format($stats['total_categories']) }}</h3>
                    <p class="stat-label">Total Categories</p>
                    <span class="stat-trend neutral">
                        <i class="fas fa-minus"></i> No change
                    </span>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section (Optional - You can remove if not needed) -->
        <div class="recent-section">
            <div class="section-header">
                <h3>Recent Activity</h3>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="activity-details">
                        <p><strong>New order</strong> received from John Doe</p>
                        <small>2 minutes ago</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-details">
                        <p><strong>New user</strong> registered: Jane Smith</p>
                        <small>15 minutes ago</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="activity-details">
                        <p><strong>New product</strong> added: WordPress Theme Pro</p>
                        <small>1 hour ago</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Form (Hidden but preserved) -->
    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
        @csrf
    </form>

@endsection

@push('styles')
    <style>
        .dashboard-container {
            padding: 0;
        }

        /* Welcome Section */
        .welcome-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 25px 30px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 16px;
            color: white;
        }

        .welcome-text h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .welcome-text p {
            opacity: 0.9;
            font-size: 14px;
        }

        .date-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }

        .date-badge i {
            margin-right: 8px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid #f0f0f0;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .stat-icon.users {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }

        .stat-icon.products {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-icon.orders {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .stat-icon.revenue {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .stat-icon.categories {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .stat-label {
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-trend {
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 20px;
            background: #f9fafb;
        }

        .stat-trend.positive {
            color: #10b981;
        }

        .stat-trend.neutral {
            color: #6b7280;
        }

        .stat-trend i {
            font-size: 10px;
        }

        /* Recent Activity Section */
        .recent-section {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }

        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .view-all:hover {
            color: var(--primary-dark);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            border-radius: 12px;
            transition: background 0.3s;
        }

        .activity-item:hover {
            background: #f9fafb;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(99, 102, 241, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 18px;
        }

        .activity-details {
            flex: 1;
        }

        .activity-details p {
            color: var(--dark);
            font-size: 14px;
            margin-bottom: 4px;
        }

        .activity-details small {
            color: var(--gray);
            font-size: 12px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-section {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 28px;
            }

            .recent-section {
                padding: 20px;
            }
        }
    </style>
@endpush
