<?php
// database/migrations/xxxx_xx_xx_000000_create_clinic_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clinic_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('location')->nullable();
            $table->enum('emergency_mode', ['ON', 'OFF'])->default('OFF');
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            
            $table->foreign('clinic_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinic_settings');
    }
};