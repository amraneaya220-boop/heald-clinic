<?php
// database/migrations/2024_01_01_000007_create_admin_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name')->default('Admin User');
            $table->string('admin_email')->default('admin@mediease.com');
            $table->string('admin_password_hash');
            $table->decimal('default_commission', 5, 2)->default(5.00);
            $table->string('currency')->default('DZD');
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            $table->boolean('appointment_reminders')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};