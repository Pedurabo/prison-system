<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->enum('request_type', ['electrical', 'plumbing', 'hvac', 'security', 'structural', 'cleaning', 'other']);
            $table->enum('priority_level', ['low', 'medium', 'high', 'emergency']);
            $table->string('location');
            $table->text('description');
            $table->foreignId('reported_by_staff_id')->constrained('staff');
            $table->foreignId('assigned_to_staff_id')->nullable()->constrained('staff');
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('request_date');
            $table->timestamp('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'priority_level']);
            $table->index(['request_date', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
