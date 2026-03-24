@extends('layouts.app')

@section('title', 'Shopping Cart - Themeour')

@section('content')
    <div
        style="background-color: #f8fafc; min-height: calc(100vh - 200px); padding: 60px 20px; font-family: 'Inter', sans-serif;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <h1 style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 30px;">Shopping Cart</h1>

            @if (session('success'))
                <div
                    style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (count($cart) > 0)
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: start;">

                    <div
                        style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #f1f5f9;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                                <tr>
                                    <th
                                        style="padding: 20px; color: #64748b; font-weight: 600; font-size: 14px; text-transform: uppercase;">
                                        Product</th>
                                    <th
                                        style="padding: 20px; color: #64748b; font-weight: 600; font-size: 14px; text-transform: uppercase;">
                                        Price</th>
                                    <th
                                        style="padding: 20px; color: #64748b; font-weight: 600; font-size: 14px; text-transform: uppercase; text-align: right;">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $id => $details)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 20px; display: flex; align-items: center; gap: 15px;">
                                            <div
                                                style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; background: #f1f5f9;">
                                                <img src="{{ $details['thumbnail'] ? asset('storage/' . $details['thumbnail']) : 'https://via.placeholder.com/80x60?text=No+Img' }}"
                                                    alt="{{ $details['name'] }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <h4
                                                    style="margin: 0 0 5px 0; font-size: 16px; font-weight: 700; color: #1e293b;">
                                                    {{ $details['name'] }}</h4>
                                                <span
                                                    style="background: #e0e7ff; color: #4338ca; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">
                                                    {{ ucfirst($details['type']) }}
                                                </span>
                                                @if ($details['quantity'] > 1)
                                                    <span style="font-size: 13px; color: #64748b; margin-left: 10px;">Qty:
                                                        {{ $details['quantity'] }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 20px; font-size: 18px; font-weight: 700; color: #1e293b;">
                                            ₹{{ number_format($details['price'] * $details['quantity'], 2) }}
                                        </td>
                                        <td style="padding: 20px; text-align: right;">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit"
                                                    style="background: #fee2e2; color: #ef4444; border: none; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#fecaca'"
                                                    onmouseout="this.style.background='#fee2e2'">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div
                        style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; position: sticky; top: 100px;">
                        <h3
                            style="margin: 0 0 20px 0; font-size: 20px; font-weight: 800; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                            Order Summary</h3>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 15px; color: #64748b; font-size: 15px;">
                            <span>Subtotal: ({{ count($cart) }} items)</span>
                            <span style="color: #1e293b; font-weight: 600;">₹{{ number_format($total, 2) }}</span>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 15px; color: #64748b; font-size: 15px;">
                            <span>Quantity:</span>
                            <span style="color: #1e293b; font-weight: 600;">{{ $details['quantity'] }}</span>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 20px; color: #10b981; font-size: 15px;">
                            <span>Discount:</span>
                            <span>- ₹200.00</span>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 25px; padding-top: 20px; border-top: 1px dashed #cbd5e1; font-size: 20px; font-weight: 800; color: #1e293b;">
                            <span>Total</span>
                            <span style="color: #6366f1;">₹{{ number_format($total, 2) }}</span>
                        </div>

                        <a href="{{route('checkout.index')}}"
                            style="display: block; width: 100%; text-align: center; background: #6366f1; color: white; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: 700; text-decoration: none; transition: background 0.3s; box-shadow: 0 4px 6px -1px rgba(99,102,241,0.4);"
                            onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                            Proceed to Checkout <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                        </a>

                        <div style="margin-top: 20px; text-align: center; color: #94a3b8; font-size: 13px;">
                            <i class="fas fa-lock"></i> Secure encrypted checkout
                        </div>
                    </div>

                </div>
            @else
                <div
                    style="background: white; border-radius: 16px; padding: 60px 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                    <div
                        style="width: 80px; height: 80px; background: #f1f5f9; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 20px;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 style="font-size: 24px; font-weight: 800; color: #1e293b; margin-bottom: 10px;">Your cart is empty
                    </h3>
                    <p style="color: #64748b; margin-bottom: 30px;">Looks like you haven't added any premium assets to your
                        cart yet.</p>
                    <a href="{{ route('products.all') }}"
                        style="display: inline-block; background: #6366f1; color: white; padding: 14px 28px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: background 0.3s;">
                        Explore Products
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
