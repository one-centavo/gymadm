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
        Schema::create('memberships_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->unique();
            $table->string('description',255)->nullable();
            $table->decimal('price',10,2);
            $table->integer('duration_value');
            $table->enum('duration_unit', ['days', 'weeks', 'months']);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships_plans');
    }
};
