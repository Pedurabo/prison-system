<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inmate_id')->constrained('inmates');
            $table->string('visitor_name');
            $table->string('visitor_relationship');
            $table->string('visitor_id_number');
            $table->string('visitor_phone');
            $table->date('visit_date');
            $table->timestamp('visit_time');
            $table->integer('duration_minutes');
            $table->enum('visit_type', ['family', 'legal', 'official', 'religious']);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->foreignId('approved_by_staff_id')->nullable()->constrained('staff');
            $table->text('notes')->nullable();
            $table->text('visitor_address');
            $table->timestamps();

            $table->index(['inmate_id', 'visit_date']);
            $table->index(['status', 'visit_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
};
