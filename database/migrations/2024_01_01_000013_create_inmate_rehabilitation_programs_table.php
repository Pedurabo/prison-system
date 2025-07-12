<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inmate_rehabilitation_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inmate_id')->constrained('inmates')->onDelete('cascade');
            $table->foreignId('rehabilitation_program_id')->constrained('rehabilitation_programs')->onDelete('cascade');
            $table->date('enrollment_date');
            $table->date('completion_date')->nullable();
            $table->enum('status', ['enrolled', 'in_progress', 'completed', 'dropped', 'suspended'])->default('enrolled');
            $table->text('progress_notes')->nullable();
            $table->decimal('grade_percentage', 5, 2)->nullable();
            $table->timestamps();

            $table->unique(['inmate_id', 'rehabilitation_program_id'], 'inmate_program_unique');
            $table->index(['status', 'enrollment_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inmate_rehabilitation_programs');
    }
};
