<?php
// database/migrations/2024_01_01_000005_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['clinic', 'ad']);
            $table->foreignId('entity_id'); // clinic_id or ad_id
            $table->string('entity_name');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};