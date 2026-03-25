@extends('layouts.app')

@section('title', 'Secure Checkout - Themeour')

@section('content')
    <div
        style="background-color: #f8fafc; min-height: calc(100vh - 200px); padding: 60px 20px; font-family: 'Inter', sans-serif;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <h1 style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 30px;">Secure Checkout</h1>

            <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST"
                style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; align-items: start;">
                @csrf

                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                <div
                    style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                    <h3
                        style="margin: 0 0 20px 0; font-size: 20px; font-weight: 800; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                        Billing Information
                    </h3>

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Full
                            Name</label>
                        <input type="text" name="billing_name" value="{{ auth()->user()->name }}" required
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 15px; outline: none;"
                            onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Email
                            Address (For Receipt & Downloads)</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; background: #f8fafc; border-radius: 8px; font-size: 15px; color: #94a3b8;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Contact
                            Number</label>
                        <input type="text" name="billing_phone" required placeholder="+1 234 567 8900"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 15px; outline: none;"
                            onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Country</label>
                        <select name="billing_country" id="countrySelect" required onchange="toggleCustomCountry()"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 15px; outline: none; background: white;"
                            onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
                            <option value="">Select a Country</option>
                            <option value="India">India</option>
                            <option value="United States">United States</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="Australia">Australia</option>
                            <option value="Other">Other (Please specify)</option>
                        </select>
                    </div>

                    <div id="customCountryBox" style="margin-bottom: 20px; display: none;">
                        <label
                            style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Enter
                            Your Country</label>
                        <input type="text" name="custom_country" id="customCountryInput"
                            placeholder="Type your country name"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 15px; outline: none;"
                            onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>

                    <div
                        style="background: #eff6ff; border: 1px solid #bfdbfe; padding: 15px; border-radius: 8px; display: flex; align-items: center; gap: 15px; margin-top: 30px;">
                        <i class="fas fa-info-circle" style="color: #3b82f6; font-size: 24px;"></i>
                        <p style="margin: 0; font-size: 14px; color: #1e40af;">Since these are digital products, no shipping
                            address is required. You will receive download links immediately after payment.</p>
                    </div>
                </div>

                <div
                    style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; position: sticky; top: 100px;">
                    <h3
                        style="margin: 0 0 20px 0; font-size: 20px; font-weight: 800; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                        Your Order
                    </h3>

                    <div style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                        @foreach ($cart as $details)
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px dashed #e2e8f0;">
                                <div>
                                    <h5 style="margin: 0; font-size: 14px; color: #1e293b;">{{ $details['name'] }} <span
                                            style="color: #94a3b8; font-weight: normal;">x{{ $details['quantity'] }}</span>
                                    </h5>
                                </div>
                                <span
                                    style="font-weight: 600; color: #1e293b; font-size: 14px;">₹{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div
                        style="display: flex; justify-content: space-between; margin-bottom: 25px; padding-top: 15px; font-size: 22px; font-weight: 800; color: #1e293b;">
                        <span>Total Pay</span>
                        <span style="color: #6366f1;">₹{{ number_format($total, 2) }}</span>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <h5 style="margin: 0 0 10px 0; font-size: 14px; color: #64748b; text-transform: uppercase;">Payment
                            Method</h5>
                        <div
                            style="border: 2px solid #6366f1; background: #f8fafc; padding: 15px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-weight: 600; color: #1e293b;"><i class="fas fa-credit-card"
                                    style="color: #6366f1; margin-right: 8px;"></i> Credit Card / UPI</span>
                            <div style="display: flex; gap: 5px;">
                                <i class="fab fa-cc-visa" style="font-size: 24px; color: #1a1f71;"></i>
                                <i class="fab fa-cc-mastercard" style="font-size: 24px; color: #eb001b;"></i>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="payButton"
                        style="width: 100%; text-align: center; background: #10b981; color: white; border: none; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: background 0.3s; box-shadow: 0 4px 6px -1px rgba(16,185,129,0.4);"
                        onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                        <i class="fas fa-lock"></i> Pay ₹{{ number_format($total, 2) }} Securely
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('payButton').onclick = function(e) {
            e.preventDefault();

            // Basic HTML5 validation before opening popup
            const form = document.getElementById('checkoutForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            var options = {
                "key": "{{ env('RAZORPAY_KEY') }}",
                "amount": "{{ $total * 100 }}", // Amount is in currency subunits (paise)
                "currency": "INR",
                "name": "Themeour Marketplace",
                "description": "Digital Asset Purchase",
                "image": "https://via.placeholder.com/150?text=Themeour", // Replace with your logo
                "order_id": "{{ $razorpayOrderId }}", // Generated securely in CheckoutController
                "handler": function(response) {
                    // On success, populate the hidden inputs with Razorpay IDs
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;

                    // Submit the main form to your server
                    document.getElementById('checkoutForm').submit();
                },
                "prefill": {
                    "name": "{{ auth()->user()->name }}",
                    "email": "{{ auth()->user()->email }}",
                    "contact": document.querySelector('input[name="billing_phone"]').value
                },
                "theme": {
                    "color": "#6366f1" // Matches your brand's indigo primary color
                }
            };

            var rzp1 = new Razorpay(options);

            rzp1.on('payment.failed', function(response) {
                alert("Payment failed: " + response.error.description);
            });

            rzp1.open();
        };

        // Custom Country Toggle Logic
        function toggleCustomCountry() {
            const selectBox = document.getElementById('countrySelect');
            const customBox = document.getElementById('customCountryBox');
            const customInput = document.getElementById('customCountryInput');

            if (selectBox.value === 'Other') {
                customBox.style.display = 'block';
                customInput.setAttribute('required', 'required');
            } else {
                customBox.style.display = 'none';
                customInput.removeAttribute('required');
                customInput.value = '';
            }
        }
    </script>
@endpush
