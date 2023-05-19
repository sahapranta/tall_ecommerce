<?php

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use App\Models\User;
use App\Models\Variant;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('has_special_offer')->index()->default(false)->nullable();
            $table->enum('offer_type', ['percent', 'amount'])->default('amount')->nullable();
            $table->unsignedInteger('offer_value')->nullable();
            $table->string('status')->default((ProductStatusEnum::Draft)->value);
            $table->bigInteger('sale_count')->default(0);
            $table->foreignIdFor(Category::class, 'category_id')->constrained();
            $table->foreignIdFor(User::class, 'user_id')->constrained();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
