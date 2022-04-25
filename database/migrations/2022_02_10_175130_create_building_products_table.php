<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->text('address')->nullable();
            $table->string('size');
            $table->string('bedroom');
            $table->string('bathroom');
            $table->string('hall');
            $table->string('price');
            $table->string('phone')->nullable();
            $table->foreignId('building_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('rent')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('admin_check')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_products');
    }
}
