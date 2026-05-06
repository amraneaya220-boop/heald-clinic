<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'clinic_id')) {
                $table->foreignId('clinic_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('invoices', 'clinic_name')) {
                $table->string('clinic_name')->nullable();
            }
            if (!Schema::hasColumn('invoices', 'items')) {
                $table->json('items')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn(['clinic_id', 'clinic_name', 'items']);
        });
    }
};