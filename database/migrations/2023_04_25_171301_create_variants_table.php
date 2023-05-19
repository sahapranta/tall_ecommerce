<?php

use App\Models\Product;
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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->foreignIdFor(Product::class, 'product_id')->constrained()->cascadeOnDelete();
            // $table->decimal('purchase_price', places: 2);
            $table->decimal('sale_price', places: 2);
            $table->decimal('offer_price', places: 2);
            $table->string('shipping_weight')->nullable();
            $table->timestamp('offer_start')->nullable();
            $table->timestamp('offer_end')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('free_shipping')->default(0);
            $table->boolean('active')->index()->default(1);
            $table->boolean('is_default')->index()->default(0);
            $table->string('dimension')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
