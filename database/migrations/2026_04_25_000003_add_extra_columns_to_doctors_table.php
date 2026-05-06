<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'experience')) {
                $table->string('experience')->nullable()->after('clinic_id');
            }
            if (!Schema::hasColumn('doctors', 'consultation_fee')) {
                $table->decimal('consultation_fee', 10, 2)->nullable()->after('experience');
            }
            if (!Schema::hasColumn('doctors', 'about')) {
                $table->text('about')->nullable()->after('consultation_fee');
            }
        });
    }

    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (Schema::hasColumn('doctors', 'experience')) {
                $table->dropColumn('experience');
            }
            if (Schema::hasColumn('doctors', 'consultation_fee')) {
                $table->dropColumn('consultation_fee');
            }
            if (Schema::hasColumn('doctors', 'about')) {
                $table->dropColumn('about');
            }
        });
    }
};

