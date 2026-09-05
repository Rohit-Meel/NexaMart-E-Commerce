<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->nullOnDelete();

            $table->string('order_number')->unique();

            $table->decimal('subtotal', 10, 2);

            $table->decimal('discount', 10, 2)->default(0);

            $table->decimal('shipping_charge', 10, 2)->default(0);

            $table->decimal('tax', 10, 2)->default(0);

            $table->decimal('total_amount', 10, 2);

            $table->string('coupon_code')->nullable();

            $table->enum('payment_method', [
                'cod',
                'online'
            ])->default('cod');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded'
            ])->default('pending');

            $table->enum('order_status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            $table->text('customer_note')->nullable();

            $table->timestamp('placed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};