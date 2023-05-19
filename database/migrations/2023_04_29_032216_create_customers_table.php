<?php

use App\Models\User;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone')->unique()->nullable();
            // $table->string('password', 60)->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->date('dob')->nullable();
            $table->string('sex')->nullable();
            $table->timestampTz('last_visited_at')->nullable();
            $table->ipAddress('last_visited_from')->nullable();
            $table->string('stripe_id')->nullable();
            $table->text('card_holder_name')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->boolean('active')->default(true);
            // $table->string('verification_token', 100)->nullable();
            $table->json('info')->nullable();
            // $table->text('two_factor_secret')->nullable();
            // $table->text('two_factor_recovery_codes')->nullable();
            // $table->timestamp('two_factor_confirmed_at')->nullable();
            // $table->rememberToken();
            // $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
