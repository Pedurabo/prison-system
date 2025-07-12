<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inmate_id')->constrained('inmates');
            $table->foreignId('attending_staff_id')->constrained('staff');
            $table->timestamp('visit_date');
            $table->text('diagnosis')->nullable();
            $table->text('symptoms');
            $table->text('treatment');
            $table->text('medications')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('follow_up_required')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->string('medical_condition')->nullable();
            $table->text('allergies')->nullable();
            $table->string('emergency_contact');
            $table->string('blood_type')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->timestamps();

            $table->index(['inmate_id', 'visit_date']);
            $table->index(['follow_up_required', 'follow_up_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
};
