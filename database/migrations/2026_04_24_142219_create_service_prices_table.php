<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->integer('consult')->default(2500);
            $table->integer('radio')->default(4000);
            $table->integer('mri')->default(12000);
            $table->integer('scan')->default(15000);
            $table->timestamps();
            
            $table->foreign('clinic_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_prices');
    }
};