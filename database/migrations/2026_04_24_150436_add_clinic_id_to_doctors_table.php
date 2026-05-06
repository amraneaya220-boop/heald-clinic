<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'clinic_id')) {
                $table->unsignedBigInteger('clinic_id')->nullable()->after('id');
                $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('set null');
            }
        });
        
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'clinic_id')) {
                $table->unsignedBigInteger('clinic_id')->nullable()->after('id');
                $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('set null');
            }
        });
        
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'clinic_id')) {
                $table->unsignedBigInteger('clinic_id')->nullable()->after('id');
                $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
        });
        
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
        });
        
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
        });
    }
};