// database/migrations/2024_01_01_000006_create_reviews_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->tinyInteger('rating')->check('rating BETWEEN 1 AND 5');
            $table->text('review');
            $table->date('review_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};