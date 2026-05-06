// database/migrations/2024_01_01_000002_create_doctors_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialty');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('working_days')->nullable();
            $table->enum('status', ['active', 'onleave', 'blocked'])->default('active');
            $table->longText('avatar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
