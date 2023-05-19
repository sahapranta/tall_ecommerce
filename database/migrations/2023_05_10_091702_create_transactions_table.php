<?php

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class, 'order_id')->constrained('orders');
            $table->foreignIdFor(Customer::class, 'customer_id')->constrained('customers');
            $table->string('code')->index();
            $table->string('client_secret');
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->json('result')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
