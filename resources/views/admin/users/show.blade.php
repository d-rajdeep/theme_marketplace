@extends('admin.layouts.app')

@section('title', 'User Details - Themeour')
@section('page-title', 'User Details')

@section('content')
    <div class="user-details-container">
        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>

        <div class="details-grid">
            <!-- User Profile Card -->
            <div class="profile-card">
                <div class="profile-header">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder" style="background: {{ $user->avatar_color ?? '#6366f1' }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="profile-info">
                        <h2>{{ $user->name }}</h2>
                        <p class="user-email-full">
                            <i class="fas fa-envelope"></i> {{ $user->email }}
                        </p>
                        @if ($user->email_verified_at)
                            <span class="verified-badge-full">
                                <i class="fas fa-check-circle"></i> Email Verified
                            </span>
                        @else
                            <span class="unverified-badge">
                                <i class="fas fa-clock"></i> Email Not Verified
                            </span>
                        @endif
                    </div>
                </div>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->orders_count ?? 0 }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">₹{{ number_format($user->total_spent ?? 0, 2) }}</div>
                        <div class="stat-label">Total Spent</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->created_at->format('d M, Y') }}</div>
                        <div class="stat-label">Member Since</div>
                    </div>
                </div>

                <div class="profile-details">
                    <h3>Account Information</h3>
                    <div class="details-list">
                        <div class="detail-item">
                            <span class="detail-label">User ID:</span>
                            <span class="detail-value">#{{ $user->id }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Username:</span>
                            <span class="detail-value">{{ $user->username ?? 'Not set' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Account Status:</span>
                            <span class="detail-value">
                                @if ($user->status === 'active')
                                    <span class="status-active">Active</span>
                                @else
                                    <span class="status-inactive">Inactive</span>
                                @endif
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Joined Date:</span>
                            <span class="detail-value">{{ $user->created_at->format('F d, Y h:i A') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Last Updated:</span>
                            <span class="detail-value">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders History -->
            <div class="orders-card">
                <div class="card-header">
                    <h3><i class="fas fa-shopping-cart"></i> Order History</h3>
                    <span class="order-count-badge">{{ $user->orders->count() }} Orders</span>
                </div>

                @if ($user->orders && $user->orders->count() > 0)
                    <div class="orders-list">
                        @foreach ($user->orders as $order)
                            <div class="order-item">
                                <div class="order-header">
                                    <div class="order-id">
                                        <strong>Order #{{ $order->id }}</strong>
                                        <span class="order-date">{{ $order->created_at->format('d M, Y') }}</span>
                                    </div>
                                    <div class="order-status">
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            ];
                                            $statusColor = $statusColors[$order->status] ?? 'secondary';
                                        @endphp
                                        <span class="order-status-badge status-{{ $statusColor }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="order-items">
                                    @foreach ($order->items as $item)
                                        <div class="order-item-detail">
                                            <div class="item-info">
                                                <span class="item-name">{{ $item->product->name ?? 'Product' }}</span>
                                                <span class="item-quantity">x {{ $item->quantity }}</span>
                                            </div>
                                            <div class="item-price">₹{{ number_format($item->price, 2) }}</div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="order-footer">
                                    <div class="order-total">
                                        <span>Total:</span>
                                        <strong>₹{{ number_format($order->total_amount, 2) }}</strong>
                                    </div>
                                    <a href="#" class="view-order-link">
                                        View Details <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-orders">
                        <i class="fas fa-shopping-bag"></i>
                        <p>No orders placed yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Danger Zone (Only for admins) -->
        @if (auth()->user()->role === 'admin')
            <div class="danger-zone">
                <h4>Danger Zone</h4>
                <div class="danger-content">
                    <div class="danger-info">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Delete this user</strong>
                            <p>Once deleted, all user data including orders will be permanently removed.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Delete User
                    </button>
                </div>
            </div>

            <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .user-details-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 30px;
        }

        /* Profile Card */
        .profile-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .profile-header {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-avatar-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: 600;
        }

        .profile-info h2 {
            font-size: 24px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .user-email-full {
            color: #6b7280;
            margin-bottom: 8px;
        }

        .user-email-full i {
            margin-right: 5px;
        }

        .verified-badge-full {
            display: inline-block;
            padding: 4px 12px;
            background: #d1fae5;
            color: #10b981;
            border-radius: 20px;
            font-size: 12px;
        }

        .unverified-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #fee2e2;
            color: #ef4444;
            border-radius: 20px;
            font-size: 12px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
        }

        .profile-details h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .details-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-label {
            font-weight: 500;
            color: #6b7280;
        }

        .detail-value {
            color: var(--dark);
        }

        /* Orders Card */
        .orders-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-header h3 {
            font-size: 18px;
            color: var(--dark);
        }

        .card-header h3 i {
            margin-right: 8px;
            color: var(--primary);
        }

        .order-count-badge {
            background: #f3f4f6;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: #6b7280;
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .order-item {
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            padding: 15px;
            transition: all 0.3s;
        }

        .order-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-id strong {
            font-size: 14px;
            color: var(--dark);
        }

        .order-date {
            font-size: 12px;
            color: #9ca3af;
            margin-left: 10px;
        }

        .order-status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .status-success {
            background: #d1fae5;
            color: #10b981;
        }

        .status-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .status-info {
            background: #dbeafe;
            color: #3b82f6;
        }

        .status-danger {
            background: #fee2e2;
            color: #ef4444;
        }

        .order-items {
            margin-bottom: 12px;
        }

        .order-item-detail {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .item-info {
            display: flex;
            gap: 10px;
        }

        .item-name {
            font-size: 13px;
            color: #4b5563;
        }

        .item-quantity {
            font-size: 12px;
            color: #9ca3af;
        }

        .item-price {
            font-size: 13px;
            font-weight: 500;
            color: var(--dark);
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid #f0f0f0;
        }

        .order-total span {
            font-size: 12px;
            color: #6b7280;
        }

        .order-total strong {
            font-size: 16px;
            color: var(--dark);
            margin-left: 8px;
        }

        .view-order-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
        }

        .view-order-link:hover {
            text-decoration: underline;
        }

        .empty-orders {
            text-align: center;
            padding: 40px;
        }

        .empty-orders i {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 10px;
        }

        .empty-orders p {
            color: #9ca3af;
        }

        /* Danger Zone */
        .danger-zone {
            margin-top: 30px;
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 16px;
            padding: 20px;
        }

        .danger-zone h4 {
            color: #dc2626;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #fed7d7;
        }

        .danger-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .danger-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .danger-info i {
            font-size: 24px;
            color: #dc2626;
        }

        .danger-info strong {
            display: block;
            color: #991b1b;
            margin-bottom: 5px;
        }

        .danger-info p {
            color: #7f1a1a;
            font-size: 13px;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .details-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-stats {
                grid-template-columns: 1fr;
            }

            .danger-content {
                flex-direction: column;
                align-items: stretch;
            }

            .danger-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function confirmDelete() {
            if (confirm(
                    'Are you sure you want to delete this user? This action cannot be undone and all user data will be permanently removed.'
                    )) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endpush
