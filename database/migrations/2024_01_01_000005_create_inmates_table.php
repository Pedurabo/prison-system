<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inmates', function (Blueprint $table) {
            $table->id();
            $table->string('inmate_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('admission_date');
            $table->date('release_date')->nullable();
            $table->string('sentence_length');
            $table->string('crime_category');
            $table->enum('security_level', ['minimum', 'medium', 'maximum', 'supermax']);
            $table->string('cell_number');
            $table->string('block');
            $table->enum('status', ['active', 'released', 'transferred', 'deceased'])->default('active');
            $table->string('nationality');
            $table->text('address_before_incarceration');
            $table->string('emergency_contact');
            $table->string('next_of_kin');
            $table->string('photo_path')->nullable();
            $table->text('fingerprint_data')->nullable();
            $table->timestamps();

            $table->index(['inmate_number', 'status']);
            $table->index(['security_level', 'status']);
            $table->index(['block', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inmates');
    }
};
