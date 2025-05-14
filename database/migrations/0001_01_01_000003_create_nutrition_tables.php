<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nutrient_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name_dutch')->unique();
            $table->string('name_english')->unique();
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });

        Schema::create('nutrients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrient_group_id')->index();
            $table->string('code')->unique();
            $table->string('component_dutch')->unique();
            $table->string('component_english')->unique();
            $table->string('unit');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });

        Schema::create('food_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name_dutch')->unique();
            $table->string('name_english')->unique();
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });

        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_group');
            $table->string('name_dutch')->unique();
            $table->string('name_english')->unique();
            $table->double('protein');
            $table->double('fat');
            $table->double('saturated_fat');
            $table->double('carbs');
            $table->double('sugar');
            $table->double('fiber');
            $table->double('ash');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });

        Schema::create('food_nutrient', function (Blueprint $table) {
            $table->foreignId('nutrient_id');
            $table->foreignId('food_id');
            $table->unique(['nutrient_id', 'food_id']);
            $table->double('quantity');
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_groups');
        Schema::dropIfExists('foods');
        Schema::dropIfExists('nutrient_groups');
        Schema::dropIfExists('nutrients');
        Schema::dropIfExists('nutrient_food');
        Schema::dropIfExists('food_nutrient');
    }
};
