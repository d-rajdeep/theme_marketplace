@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number . ' - Themeour')
@section('page-title', 'Order Details')

@section('content')
    <div class="order-details-container">
        <div class="back-button">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>

        <div class="order-header">
            <div class="order-info">
                <h2>Order {{ $order->order_number }}</h2>
                <p class="order-date">Placed on {{ $order->created_at->format('F d, Y h:i A') }}</p>
            </div>
            <div class="order-status-actions">
                <div class="status-badge-large status-{{ $order->payment_status }}">
                    <i class="fas fa-circle"></i>
                    {{ ucfirst($order->payment_status) }}
                </div>
                <select id="quickStatusUpdate" class="status-select-large" data-order-id="{{ $order->id }}"
                    data-current-status="{{ $order->payment_status }}">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->payment_status == 'processing' ? 'selected' : '' }}>Processing
                    </option>
                    <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="cancelled" {{ $order->payment_status == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>
        </div>

        <div class="details-grid">
            <div class="info-card">
                <h3><i class="fas fa-user"></i> Billing Information</h3>
                <div class="info-content">
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $order->billing_name ?? ($order->user->name ?? 'Guest User') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $order->billing_email ?? ($order->user->email ?? 'N/A') }}</span>
                    </div>
                    @if ($order->billing_phone)
                        <div class="info-row">
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $order->billing_phone }}</span>
                        </div>
                    @endif
                    @if ($order->billing_country)
                        <div class="info-row">
                            <span class="info-label">Country:</span>
                            <span class="info-value">{{ $order->billing_country }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-info-circle"></i> Order Information</h3>
                <div class="info-content">
                    <div class="info-row">
                        <span class="info-label">Order Number:</span>
                        <span class="info-value">{{ $order->order_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Order Date:</span>
                        <span class="info-value">{{ $order->created_at->format('F d, Y h:i A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment Method:</span>
                        <span class="info-value">{{ ucfirst($order->payment_method ?? 'Razorpay') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment Status:</span>
                        <span class="payment-status-badge payment-{{ $order->payment_status ?? 'pending' }}">
                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-receipt"></i> Order Summary</h3>
                <div class="info-content">
                    <div class="info-row total-row">
                        <span class="info-label">Total Amount:</span>
                        <span class="info-value total-amount">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div style="margin-top: 15px; font-size: 12px; color: #6b7280;">
                        <i class="fas fa-check-circle text-success"></i> Digital Products - No shipping required
                    </div>
                </div>
            </div>
        </div>

        <div class="order-items-card">
            <h3><i class="fas fa-shopping-bag"></i> Purchased Products</h3>
            <div class="table-responsive">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>
                                    <div class="product-info-cell">
                                        @if ($item->product && $item->product->thumbnail)
                                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                                alt="{{ $item->product->name }}" class="product-thumb">
                                        @else
                                            <div class="product-thumb-placeholder">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        @endif
                                        <div class="product-details">
                                            <strong>{{ $item->product->name ?? 'Deleted Product' }}</strong>
                                            <small>{{ $item->product->category->name ?? 'Uncategorized' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="product-type-badge type-{{ $item->product->type ?? 'template' }}">
                                        {{ ucfirst($item->product->type ?? 'Product') }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="item-total">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="grand-total">
                            <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                            <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="order-timeline-card">
            <h3><i class="fas fa-history"></i> Order Timeline</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Order Placed</h4>
                        <p>{{ $order->created_at->format('F d, Y h:i A') }}</p>
                        <small>{{ $order->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                @if ($order->payment_status == 'processing' || $order->payment_status == 'completed')
                    <div class="timeline-item">
                        <div class="timeline-icon" style="background: #3b82f6;">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>Processing Payment</h4>
                            <p>{{ $order->updated_at->format('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                @endif

                @if ($order->payment_status == 'completed')
                    <div class="timeline-item">
                        <div class="timeline-icon" style="background: #10b981;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>Payment Completed (Downloads Active)</h4>
                            <p>{{ $order->updated_at->format('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                @endif

                @if ($order->payment_status == 'cancelled')
                    <div class="timeline-item">
                        <div class="timeline-icon" style="background: #ef4444;">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>Order Cancelled</h4>
                            <p>{{ $order->updated_at->format('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-details-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .order-header {
            background: var(--white);
            border-radius: 16px;
            padding: 25px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .order-info h2 {
            font-size: 24px;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .order-date {
            color: #6b7280;
            font-size: 14px;
        }

        .order-status-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .status-badge-large {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-badge-large i {
            font-size: 10px;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-processing {
            background: #dbeafe;
            color: #3b82f6;
        }

        .status-completed {
            background: #d1fae5;
            color: #10b981;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #ef4444;
        }

        .status-select-large {
            padding: 8px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .info-card {
            background: var(--white);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .info-card h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-card h3 i {
            margin-right: 8px;
            color: var(--primary);
        }

        .info-content {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-label {
            font-weight: 500;
            color: #6b7280;
            font-size: 13px;
        }

        .info-value {
            color: var(--dark);
            font-size: 14px;
        }

        .total-row {
            padding-top: 10px;
            border-top: 1px solid #f0f0f0;
            margin-top: 5px;
        }

        .total-amount {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .payment-status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .payment-paid,
        .payment-completed {
            background: #d1fae5;
            color: #10b981;
        }

        .payment-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .payment-failed,
        .payment-cancelled {
            background: #fee2e2;
            color: #ef4444;
        }

        .order-items-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .order-items-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .items-table th {
            padding: 12px;
            border-bottom: 2px solid #f0f0f0;
            color: #6b7280;
            font-size: 13px;
        }

        .items-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-info-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-thumb-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }

        .product-details strong {
            display: block;
            font-size: 14px;
            color: var(--dark);
        }

        .product-details small {
            color: #6b7280;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }

        .grand-total td {
            padding-top: 15px;
            font-size: 16px;
            border-bottom: none;
        }

        .order-timeline-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .order-timeline-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #f0f0f0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: -30px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transform: translateX(-50%);
            z-index: 1;
        }

        .timeline-content h4 {
            font-size: 15px;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .timeline-content p {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .timeline-content small {
            font-size: 11px;
            color: #9ca3af;
        }
    </style>
@endpush
