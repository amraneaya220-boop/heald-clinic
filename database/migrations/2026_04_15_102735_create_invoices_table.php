<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            
            // معلومات المريض والطبيب (نسخة احتياطية)
            $table->string('patient_name');
            $table->string('patient_phone')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('consultation_type')->nullable();
            
            // التواريخ
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->date('invoice_date');
            
            // الرسوم والخدمات
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->decimal('lab_fee', 10, 2)->default(0);
            $table->decimal('extra_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            
            // طريقة الدفع والحالة
            $table->enum('payment_method', ['Cash', 'Baridi Mob', 'Eddahabia Card', 'Visa/Mastercard'])->default('Cash');
            $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->default('pending');
            
            // معلومات إضافية
            $table->text('notes')->nullable();
            $table->json('services_details')->nullable(); // تخزين تفاصيل الخدمات الإضافية
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};