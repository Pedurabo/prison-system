<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rehabilitation_programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->enum('program_type', ['substance_abuse', 'education', 'vocational_training', 'anger_management', 'life_skills', 'other']);
            $table->text('description');
            $table->foreignId('instructor_staff_id')->constrained('staff');
            $table->integer('capacity');
            $table->integer('duration_weeks');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['planned', 'active', 'completed', 'cancelled'])->default('planned');
            $table->decimal('cost', 10, 2)->default(0);
            $table->string('location');
            $table->text('prerequisites')->nullable();
            $table->boolean('certificate_provided')->default(false);
            $table->timestamps();

            $table->index(['program_type', 'status']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('rehabilitation_programs');
    }
};
