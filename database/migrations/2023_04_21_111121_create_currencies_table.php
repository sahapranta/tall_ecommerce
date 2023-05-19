<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('sign');
            $table->string('name');
            $table->decimal('exchange_rate', 10, 4);
            $table->string('format')->default('start');
            $table->integer('decimal_places')->default(2)->index();
            $table->boolean('active')->default(1)->index();
            $table->boolean('default')->default(0)->index();
            $table->timestamps();
        });

        // This is not safe
        // $query = "CREATE TRIGGER update_default
        //     BEFORE UPDATE ON currencies
        //     FOR EACH ROW
        //     BEGIN
        //         IF NEW.default = 1 THEN
        //             SET `default`=0 WHERE `default`=1;
        //         END IF;
        //     END;
        // ";
        // DB::connection()->getPdo()->exec($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
