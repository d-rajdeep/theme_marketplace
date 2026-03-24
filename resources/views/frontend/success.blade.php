@extends('layouts.app')
@section('title', 'Order Successful - Themeour')

@section('content')
    <div
        style="background-color: #f8fafc; min-height: calc(100vh - 200px); padding: 80px 20px; text-align: center; font-family: 'Inter', sans-serif;">
        <div
            style="max-width: 800px; margin: 0 auto; background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">

            <div
                style="width: 80px; height: 80px; background: #dcfce7; color: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px;">
                <i class="fas fa-check"></i>
            </div>

            <h1 style="font-size: 36px; font-weight: 800; color: #1e293b; margin-bottom: 10px;">Payment Successful!</h1>
            <p style="color: #64748b; font-size: 16px; margin-bottom: 30px;">Thank you for your purchase. Your order
                <strong>{{ $order->order_number }}</strong> is complete.
            </p>

            <div
                style="text-align: left; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                <h3
                    style="margin: 0 0 15px 0; font-size: 18px; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                    Your Downloads</h3>

                @foreach ($order->items as $item)
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <img src="{{ $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : 'https://via.placeholder.com/50' }}"
                                style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                            <div>
                                <h4 style="margin: 0; font-size: 15px; color: #1e293b; font-weight: 600;">
                                    {{ $item->product->name }}</h4>
                                <span style="font-size: 12px; color: #64748b;">Lifetime License</span>
                            </div>
                        </div>
                        <a href="{{ route('product.download', $item->id) }}"
                            style="background: #6366f1; color: white; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('dashboard') }}"
                style="display: inline-block; background: #f1f5f9; color: #475569; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-right: 15px;">Go
                to Dashboard</a>
            <a href="{{ route('products.all') }}"
                style="display: inline-block; background: #6366f1; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Continue
                Shopping</a>
        </div>
    </div>
@endsection
