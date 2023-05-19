<?php

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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->enum('type', ['amount', 'percent'])->default('amount');
            $table->unsignedSmallInteger('value');
            $table->unsignedSmallInteger('min_amount')->nullable();
            $table->unsignedSmallInteger('max_amount')->nullable();
            $table->timestamp('starting_time')->nullable();
            $table->timestamp('ending_time')->nullable();
            $table->boolean('active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
