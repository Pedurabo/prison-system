<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_services', function (Blueprint $table) {
            $table->id();
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->date('meal_date');
            $table->text('menu_description');
            $table->text('nutritional_info')->nullable();
            $table->decimal('cost_per_serving', 8, 2);
            $table->integer('servings_prepared');
            $table->text('dietary_restrictions')->nullable();
            $table->text('allergen_info')->nullable();
            $table->foreignId('prepared_by_staff_id')->constrained('staff');
            $table->foreignId('approved_by_staff_id')->nullable()->constrained('staff');
            $table->enum('status', ['planned', 'prepared', 'served', 'cancelled'])->default('planned');
            $table->timestamps();

            $table->index(['meal_date', 'meal_type']);
            $table->index(['status', 'meal_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_services');
    }
};
