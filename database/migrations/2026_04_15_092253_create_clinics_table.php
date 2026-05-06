// database/migrations/2024_01_01_000001_create_clinics_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('HealD Clinic');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->text('location')->nullable();
            $table->text('address')->nullable();
             $table->enum('subscription', ['monthly', 'yearly'])->default('monthly');
            $table->enum('emergency_mode', ['ON', 'OFF'])->default('OFF');
            $table->string('email')->nullable();
            $table->date('paid_until')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->longText('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinics');
    }
};
