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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->integer('location_id');
            $table->integer('task_id');
            $table->integer('assigned_user_id');
            $table->string('description')->nullable();
            $table->string('comment')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->string('radius')->nullable();
            $table->integer('timer')->default(0)->nullable();
            $table->integer('status')->default(0);
            $table->integer('number')->nullable();
            $table->string('position')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('department_index')->default(1);
            $table->dateTime('check_in_time')->nullable();
            $table->dateTime('check_out_time')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
