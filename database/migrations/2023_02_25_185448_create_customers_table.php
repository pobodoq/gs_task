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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstName')->nullable(false);
            $table->string('lastName')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phoneNumber')->nullable(false);
            $table->string('street')->nullable(false);
            $table->string('houseNumber')->nullable(false);
            $table->string('postCode')->nullable(false);
            $table->string('city')->nullable(false);
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
