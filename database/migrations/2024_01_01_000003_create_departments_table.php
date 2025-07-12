<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('department_head_id')->nullable();
            $table->decimal('budget', 15, 2)->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('established_date');
            $table->timestamps();

            $table->index(['name', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
