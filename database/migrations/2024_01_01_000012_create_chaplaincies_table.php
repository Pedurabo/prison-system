<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chaplaincies', function (Blueprint $table) {
            $table->id();
            $table->enum('service_type', ['mass', 'prayer', 'counseling', 'study', 'ceremony', 'other']);
            $table->enum('religion', ['christianity', 'islam', 'judaism', 'hinduism', 'buddhism', 'other']);
            $table->date('service_date');
            $table->timestamp('service_time');
            $table->string('location');
            $table->foreignId('chaplain_staff_id')->constrained('staff');
            $table->text('description');
            $table->integer('capacity');
            $table->integer('attendees_count')->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();

            $table->index(['service_date', 'religion']);
            $table->index(['status', 'service_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chaplaincies');
    }
};
