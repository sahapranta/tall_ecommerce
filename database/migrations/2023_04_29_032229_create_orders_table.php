<?php

use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->index();
            $table->foreignIdFor(Customer::class, 'customer_id')->constrained();
            $table->unsignedSmallInteger('items_count');
            $table->decimal('taxrate', 10, 2)->nullable();
            $table->decimal('taxable', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->foreignIdFor(Coupon::class, 'coupon_id')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('shipping_weight', 10, 2)->nullable();
            $table->decimal('shipping_charge', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->boolean('approved')->default(0);
            $table->string('shipping_method')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->date('shipping_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('tracking_id')->index();
            $table->string('payment_status')->default('unpaid')->index();
            $table->string('payment_method')->nullable();
            $table->string('message_to_customer')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
