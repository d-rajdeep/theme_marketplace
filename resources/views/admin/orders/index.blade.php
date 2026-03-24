@extends('admin.layouts.app')

@section('title', 'Manage Orders - Themeour')
@section('page-title', 'Orders')

@section('content')
    <div class="orders-container">
        <div class="page-header">
            <div class="header-info">
                <h2>Manage Orders</h2>
                <p>View and manage all customer orders</p>
            </div>
            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="orderSearch" placeholder="Search by order #, customer..." class="search-input">
                </div>
                <div class="filter-dropdown">
                    <select id="statusFilter" class="filter-select">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="data-table">
            @if ($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table" id="ordersTable">
                        <thead>
                            <tr>
                                <th width="100">Order #</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr data-status="{{ $order->payment_status }}">
                                    <td>
                                        <strong>{{ $order->order_number }}</strong>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="customer-name">
                                                <i class="fas fa-user"></i>
                                                {{ $order->billing_name ?? ($order->user->name ?? 'Guest') }}
                                            </div>
                                            <div class="customer-email">
                                                <i class="fas fa-envelope"></i>
                                                {{ $order->billing_email ?? ($order->user->email ?? 'N/A') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="items-count">
                                            <i class="fas fa-box"></i>
                                            {{ $order->items->count() }} items
                                        </span>
                                    </td>
                                    <td>
                                        <span class="order-amount">
                                            ₹{{ number_format($order->total_amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="payment-info">
                                            <span class="payment-method">
                                                <i class="fas fa-credit-card"></i>
                                                {{ ucfirst($order->payment_method ?? 'Razorpay') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="status-select" data-order-id="{{ $order->id }}"
                                            data-current-status="{{ $order->payment_status }}">
                                            <option value="pending"
                                                {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="processing"
                                                {{ $order->payment_status == 'processing' ? 'selected' : '' }}>Processing
                                            </option>
                                            <option value="completed"
                                                {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed
                                            </option>
                                            <option value="cancelled"
                                                {{ $order->payment_status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="order-date">
                                            {{ $order->created_at->format('d M, Y') }}
                                        </div>
                                        <small>{{ $order->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-icon btn-view"
                                                title="View Order Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn-icon btn-delete" title="Delete Order"
                                                onclick="confirmDelete({{ $order->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $order->id }}"
                                                action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>No Orders Found</h3>
                    <p>No orders have been placed yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .orders-container {
            padding: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-info h2 {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .header-info p {
            color: var(--gray);
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .search-input {
            padding: 10px 15px 10px 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            width: 250px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .filter-select {
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            background: white;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background: #f9fafb;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 13px;
            border-bottom: 2px solid #e5e7eb;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .customer-name {
            font-weight: 500;
            color: var(--dark);
        }

        .customer-name i,
        .customer-email i {
            width: 14px;
            margin-right: 5px;
            color: #9ca3af;
        }

        .customer-email {
            font-size: 12px;
            color: #6b7280;
        }

        .items-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: #f3f4f6;
            border-radius: 12px;
            font-size: 13px;
            color: #4b5563;
        }

        .order-amount {
            font-weight: 600;
            color: var(--primary);
            font-size: 16px;
        }

        .payment-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .payment-method {
            font-size: 12px;
            color: #6b7280;
        }

        .payment-method i {
            margin-right: 3px;
        }

        .status-select {
            padding: 6px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            background: white;
            transition: all 0.3s;
        }

        .status-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .status-select option[value="pending"] {
            color: #d97706;
        }

        .status-select option[value="processing"] {
            color: #3b82f6;
        }

        .status-select option[value="completed"] {
            color: #10b981;
        }

        .status-select option[value="cancelled"] {
            color: #ef4444;
        }

        .order-date {
            font-size: 13px;
            color: var(--dark);
            margin-bottom: 2px;
        }

        .order-date+small {
            font-size: 11px;
            color: #9ca3af;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-view {
            background: #e0e7ff;
            color: #6366f1;
        }

        .btn-view:hover {
            background: #6366f1;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('orderSearch');
            const ordersTable = document.getElementById('ordersTable');

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = ordersTable.getElementsByTagName('tr');

                    for (let i = 1; i < rows.length; i++) {
                        const row = rows[i];
                        const orderId = row.cells[0]?.textContent.toLowerCase() || '';
                        const customerName = row.cells[1]?.textContent.toLowerCase() || '';

                        if (orderId.includes(searchValue) || customerName.includes(searchValue)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            }

            // Status filter
            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const selectedStatus = this.value;
                    const rows = ordersTable.getElementsByTagName('tr');

                    for (let i = 1; i < rows.length; i++) {
                        const row = rows[i];
                        const rowStatus = row.getAttribute('data-status');

                        if (!selectedStatus || rowStatus === selectedStatus) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            }

            // Status update via AJAX
            const statusSelects = document.querySelectorAll('.status-select');
            statusSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const orderId = this.dataset.orderId;
                    const newStatus = this.value;

                    if (confirm(`Change order status to ${newStatus.toUpperCase()}?`)) {
                        fetch(`/admin/orders/${orderId}/status`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    payment_status: newStatus
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const row = select.closest('tr');
                                    if (row) row.setAttribute('data-status', newStatus);
                                    showNotification('Order status updated successfully!',
                                        'success');
                                } else {
                                    showNotification('Failed to update order status', 'error');
                                    select.value = select.dataset.currentStatus;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('An error occurred', 'error');
                                select.value = select.dataset.currentStatus;
                            });
                    } else {
                        select.value = select.dataset.currentStatus;
                    }
                });
            });
        });

        function confirmDelete(orderId) {
            if (confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
                document.getElementById('delete-form-' + orderId).submit();
            }
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show`;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
@endpush
