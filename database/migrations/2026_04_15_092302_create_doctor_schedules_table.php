// database/migrations/2024_01_01_000009_create_doctor_schedules_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day_of_week'); // 0=Sunday to 6=Saturday
            $table->time('time_slot');
            $table->enum('work_type', ['surgery', 'exam', 'holiday'])->default('exam');
            $table->timestamps();
            
            $table->unique(['doctor_id', 'day_of_week', 'time_slot']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_schedules');
    }
};