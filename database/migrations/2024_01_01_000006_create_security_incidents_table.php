<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('security_incidents', function (Blueprint $table) {
            $table->id();
            $table->string('incident_number')->unique();
            $table->enum('incident_type', ['fight', 'contraband', 'escape_attempt', 'self_harm', 'assault', 'disturbance', 'other']);
            $table->enum('severity_level', ['low', 'medium', 'high', 'critical']);
            $table->string('location');
            $table->text('description');
            $table->timestamp('incident_date');
            $table->foreignId('reported_by_staff_id')->constrained('staff');
            $table->foreignId('inmate_id')->nullable()->constrained('inmates');
            $table->foreignId('department_id')->constrained('departments');
            $table->enum('status', ['open', 'investigating', 'resolved', 'closed'])->default('open');
            $table->text('investigation_notes')->nullable();
            $table->text('resolution')->nullable();
            $table->timestamp('resolved_date')->nullable();
            $table->foreignId('resolved_by_staff_id')->nullable()->constrained('staff');
            $table->timestamps();

            $table->index(['incident_date', 'status']);
            $table->index(['severity_level', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('security_incidents');
    }
};
