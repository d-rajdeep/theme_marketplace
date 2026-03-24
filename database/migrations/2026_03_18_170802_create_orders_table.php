<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('razorpay');
            $table->string('payment_status')->default('completed'); // pending, completed, failed
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_phone')->nullable(); // Contact Number
            $table->string('billing_country')->nullable(); // Includes 'Other' custom countries
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
