<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chaplaincy_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chaplaincy_id')->constrained('chaplaincies')->onDelete('cascade');
            $table->foreignId('inmate_id')->constrained('inmates')->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('attendance_status', ['present', 'absent', 'excused']);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['chaplaincy_id', 'inmate_id'], 'chaplaincy_inmate_unique');
            $table->index(['attendance_date', 'attendance_status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chaplaincy_attendances');
    }
};
