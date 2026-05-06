<?php
// database/migrations/2024_01_01_000010_create_announcements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('clinic')->nullable();
            $table->string('city')->nullable();
            $table->string('doctor')->nullable();
            $table->enum('type', ['Service', 'Product', 'Offer']);
            $table->text('description');
            $table->string('price')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('image')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};