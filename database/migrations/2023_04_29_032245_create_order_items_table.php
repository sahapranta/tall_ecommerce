<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Models\Variant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->unsigned();
            $table->decimal('unit_price', 10, 2);
            $table->string('item_description')->nullable();
            $table->foreignIdFor(Order::class, 'order_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Variant::class, 'variant_id')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
