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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->string('description')->nullable();
            $table->string('owner')->nullable();
            $table->string('owner_number')->nullable();
            $table->string('radius')->default(50)->nullable();
            $table->integer('timer')->default(0)->nullable();
            $table->string('department_index')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
